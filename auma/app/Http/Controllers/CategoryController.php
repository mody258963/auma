<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryResourse;
use App\Http\Controllers\API\BaseApiController;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;


class CategoryController extends BaseApiController
{

    public function __construct(private CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return $this->success(
            $this->formatMany(
                $this->categoryRepository->all(),
                'App\Http\Resources\CategoryResourse'
            ),
            "categories retreived succssefully",
            200
        );


    }


    public function getcategorybyname(Request $request)
    {
        $categoryName = $request->input('title');

        $category = Course::query();

        if ($categoryName) {
            $category->join('categories', 'categories.id', '=', 'courses.category_id')
            ->where('categories.title', $categoryName);
        }

        $filteredcategory = $category->get();

        return response()->json($filteredcategory);
    }

    public function addcategory(Request $request) {
        $data = Validator::make($request->all(), [
            'title' => 'required', // why we need title for user ?
            ])->validate();

            $data = $this->categoryRepository->create($data);

            return $this->success($data,'Category is added',201);

    }

    public function updatecategory(Request $request , $id) {
        $data = Validator::make($request->all(), [
            'title' => 'required', // why we need title for user ?
            ])->validate();
            $category = $this->categoryRepository->find($id);


            $data = $this->categoryRepository->update($category,$data);

            return $this->success($data,'Category is added',201);

    }

    //------------------------------test--------------------------------

    // public function getCoursesByid($category){

    //     $course = $this->categoryRepository->find($category);
    //     return $course->course;
    // }

    public function destroy($id){
        $category = $this->categoryRepository->find($id);
        $this->categoryRepository->delete($category);
        return $this->success($this->formatMany(
            $this->categoryRepository->all(),
        'App\Http\Resources\courseResourse'),
        'Updated Succesfully',201);
    }

    function searchcategory($title)
    {
        $category = Category::where('title',"like","%".$title."%")->get();
        return response()->json( $category);

    }


}
