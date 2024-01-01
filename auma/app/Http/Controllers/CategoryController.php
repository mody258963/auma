<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryResourse;
use App\Http\Controllers\API\BaseApiController;
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
                'App\Http\Resources\AudioResourse'
            ),
            "categories retreived succssefully",
            200
        );

     
    }


    public function getcategory(Request $request)
    {
        $categoryId = $request->input('category_id');
    
        $products = Course::query();
    
        if ($categoryId) {
            $products->where('category_id', $categoryId);
        }
    
        $filteredProducts = $products->get();
    
        return response()->json(['products' => $filteredProducts]);
    }
    
    public function addcategory(Request $request) {
        $data = Validator::make($request->all(), [
            'title' => 'required', // why we need title for user ?
            ])->validate();

            $data = $this->categoryRepository->create($data);
            
            return $this->success($data,'Category is added',201);

    }
    
}
