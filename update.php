<?php
require_once 'users/UsersFromMysql.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{
    //ფუნქციას ვიღებთ UsersFromMysql.php ფაილიდან ბაზასთან კონექციისთვის
    openConnection();
    global $link;
    $userId =$_POST['id'];

    //update.php ფორმიდან დამატებულ მნიშვნელობებს ვიღებთ post მეთოდით
    if(isset($_POST['name'])&&isset($_POST['username'])&&isset($_POST['email'])
        &&isset($_POST['phone'])&&isset($_POST['website'])){

        //ცვლადებში ჩავწეროთ ფორმიდან ჩაწერილი მნიშვნელობები რომლებიც მივიღეთ POST - ით
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


        //შესაბამისი ID -ის მქონე useri -ის UPDATE (განახლება)
        $query ="UPDATE users SET name='$name',username='$username',email='$email',phone='$phone',website='$website',picture='$fileName' WHERE id=$userId";
        $result = mysqli_query($link,$query)
        or die ("error".mysqli_error($link));
    }
    //დავხუროთ კონექცია
    closeConnection();

    //მოცემული კოდი უზრუნველყოს რომ update.php დასრულების შემდეგ ჩაიტვირთოს index.php
    header("Location: index.php");
}
else if($_SERVER['REQUEST_METHOD']=='GET')
{
//GET მეთოდით წამოვიღეთ INDEX.PHP დან (ბრაუზერის ფაჯრიდან სადაც ID ში ჩავწეეთ $user['id])
if(isset($_GET['id'])) $userId = $_GET['id'];

//ფუნქციას ვიყენებთ UsersFromMysql.php -დან რომელიც გვიბრუნებს ცხრილის მონაცემებს
$users = getUsers();

/*ციკლით ვამოწმებთ თუ რომელ users - ის update ღილაკს დავაჭირეთ , როცა ღილაკი
  ამოქმედდა GET მეთოდით გადავეცით $userid -ს შესაბამისი user -ის id
*/
$currentUser = null;
foreach ($users as $user){
    if ($user['id'] == $userId){
        $currentUser = $user;
        break;
    }
}
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
<div class="container">
    <br>
    <div class="card">
        <div class="card-header">
            <h3>Update User :  <b><?php echo $user['name'];?></b></h3>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" value ="<?php echo isset($currentUser['id']) ? $currentUser['id'] : '' ?>" name="id" >
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $currentUser['name'];?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $currentUser['username'];?>" class="form-control">
                </div>
                <div class="form-group"><label>Email</label>
                    <input type="text" name="email" value="<?php echo $currentUser['email'];?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $currentUser['phone'];?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Website</label>
                    <input type="text" name="website" value="<?php echo $currentUser['website'];?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="picture" class="form-control-file">
                </div>
                <button class="bts btn-success"> SUBMIT </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>