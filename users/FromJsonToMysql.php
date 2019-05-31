<?php
require_once "UsersFromMysql.php";

//ფუნქცია ბაზასთან წვდომისთვის
openConnection();

//ცხრილის წაშლა
$query = "DROP TABLE users";
$result = mysqli_query($link,$query)
or die ("error".mysqli_error($link));

//ცხრილის შექმნა
$query = "CREATE TABLE users(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
username VARCHAR(255) NOT NULL,
email VARCHAR(255),
phone VARCHAR(255),
website VARCHAR(255),
picture VARCHAR(255)
)";
$result = mysqli_query($link,$query)
or die ("error".mysqli_error($link));

$url = "http://jsonplaceholder.typicode.com/users";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$curlUsers = json_decode($result, true);

//JSON -ში ვსვამთ მონაცემებს , რომელებიც წამოვიღეთ CURL-ით

$arrForJson = json_encode($curlUsers, JSON_PRETTY_PRINT);
file_put_contents( 'users.json', $arrForJson);

//JSON - დან მიღებული მასივ-ცვლადიდან SQL ცხრილში ჩაწერა
foreach($curlUsers as $user){
    $query ="INSERT INTO users (name,username,email,phone,website)
    VALUES('".$user['name']."','".$user['username']."','".$user['email']."','".$user['phone']."','".$user['website']."')";
    $result = mysqli_query($link,$query)
    or die ("error".mysqli_error($link));
}

//ფუნქცია ბაზასთან წვდომის დახურვისთვის
closeConnection();

//მიმდინარე გვერდის ჩატვირთვის დარსულების შემდეგ ჩაიტვირთება მთავარი გვერდი
header("Location: /Roman Chikhladze JSON/index.php");
?>