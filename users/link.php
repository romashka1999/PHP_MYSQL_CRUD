<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "roma_DB";

//მიერთება სერვერთან
$link = mysqli_connect($hostname,$username,$password)
or die ("error".mysqli_error($link));

//მონაცემთა ბაზის შექმნა
$query = "CREATE DATABASE roma_DB";
$result = mysqli_query($link,$query)
or die("error".mysqli_error($link));
if($result) echo "ბაზა შეიქმნა წარატებით__";

//ბაზასთან მიერთება
$link = mysqli_connect($hostname,$username,$password,$database)
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
if($result) echo "ცხრილი წარმატებით შეიქმნა";
?>
