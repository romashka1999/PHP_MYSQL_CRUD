<?php
require_once 'users/UsersFromMysql.php';

//ფუნქციას ვიღებთ UsersFromMysql.php ფაილიდან ბაზასთან კონექციისთვის
openConnection();

//create.php ფორმიდან დამატებულ მნიშვნელობებს ვიღებთ post მეთოდით
if(isset($_POST['name'])&&isset($_POST['username'])&&isset($_POST['email'])
    &&isset($_POST['phone'])&&isset($_POST['website'])){


$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$website = $_POST['website'];

//ფოტოს დამატება
    if(isset($_FILES['picture'])){
        if(!is_dir(__DIR__.'/users/images')){
            mkdir(__DIR__.'/users/images');
        }
        //ცვლადში შევინახოთ ატვირთული ფოტოს სახელი რომელსაც დავამატებთ შემდეგ sql-ში
        $fileName = $_FILES['picture']['name'];
        //ფოტო ავტვირთოთ დირექტორიაში
        move_uploaded_file($_FILES['picture']['tmp_name'],__DIR__."/users/images/$fileName");
    }

//მნიშვნელობებს ვსვამთ ცხრილში
$query ="INSERT INTO users (name,username,email,phone,website,picture)
    VALUES('$name','$username','$email','$phone','$website','$fileName')";
$result = mysqli_query($link,$query)
 or die ("error".mysqli_error($link));

//დავხუროთ კონექცია
closeConnection();

//მოცემული კოდი უზრუნველყოს რომ create.php დასრულების შემდეგ ჩაიტვირთოს index.php
header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create User :  </h3>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control">
                </div>
                <div class="form-group"><label>Email</label>
                    <input type="text" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group">
                    <label>Website</label>
                    <input type="text" name="website" class="form-control">
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="picture" class="form-control-file">
                </div>
                <button class="bts btn-success"> CREATE </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>