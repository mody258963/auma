

{{-- <form method="POST">
@csrf

   <input type="hidden" name="id" value="{{ $user[0]['id'] }}"  >
   <input type="password" name="password" placeholder="New Password">
   <br><br>
   <input type="password" name="password_confirmation" placeholder="Confirm Password">
   <br><br>
   <input type="submit">
</form> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    /* Add general styles for the form */
form {
    max-width: 400px;
    margin: 0 auto;
    margin-top: 15%;
}

/* Style the input fields */
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Style the submit button */
input[type="submit"] {
    background-color: #4caf50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.reset{
    text-align: center;
    color: #45a049;
}
</style>
<body>

      <h1 class="reset">Reset Password</h1>
    <form method="POST">
        @csrf

           <input type="hidden"  name="id" value="{{ $user[0]['id'] }}"  >
           <input type="password" name="password" placeholder="New Password">
           <br><br>
           <input type="password" name="password_confirmation" placeholder="Confirm Password">
           <br><br>
           <input type="submit">
        </form>

</body>
</html>

