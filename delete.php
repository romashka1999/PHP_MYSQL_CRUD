<?php
require_once 'users/UsersFromMysql.php';

//GET მეთოდით წამოვიღეთ INDEX.PHP დან (ბრაუზერის ფაჯრიდან სადაც ID ში ჩავწეეთ $user['id])
if (isset($_GET['id'])) $userId = $_GET['id'];

//ფუნქციას ვიყენებთ UsersFromMysql.php -დან რომელიც გვიბრუნებს Json მონაცემებს
$users = getUsers();

//ციკლით ვგებულობთ თუ რომელი მომხმარებელია მიმდინარე
foreach($users as $i=>$user){
   if($users[$i]['id']==$userId){
      //მიმდინარე მომხმარებლის სურათის სახელს ვანიჭებთ ცვლადს რათა წავშალოთ სურათი დირექტორიაში
      $currentUserFileName =$users[$i]['picture'];
      break;
   }
}

//ფუნქციას ვიღებთ UsersFromMysql.php ფაილიდან ბაზასთან კონექციისთვის
openConnection();

//წავშალოთ შესაბამისი user ცხრილში
$query ="DELETE FROM users WHERE id = '$userId'";
$result = mysqli_query($link, $query)
   or die("error" . mysqli_error($link));

//დირექტორიაში მიმდინარე მომხმარებლის სურათის წაშლა
unlink(__DIR__."/users/images/$currentUserFileName");

//დავხუროთ კონექცია
closeConnection();

//ეს ბრძანება delete.php დასრულების შემდეგ ჩატვირთავს index.php -ს
header("Location: index.php");
?>


