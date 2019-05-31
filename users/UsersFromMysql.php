<?php
$link = null;

function getUsers(){

    openConnection();
    global $link;

    //აღვწეროთ მასივი
    $users = [];

    //ცვლადში $result , წამოვიღოთ ცხრილიდან მონაცენები
    $query = "SELECT * FROM users";
    $result = mysqli_query($link,$query)
        or die ("error".mysqli_error($link));

    //თუ ბაზაში არის ერთი user მაინც
    if($result && mysqli_num_rows($result)>0){

        /*მითითებული ფუნქციით ვკითხულობთ სათითაოდ user-ის მონაცემებს
         ვანიჭებთ $row ცვლადს და შემდეგ $user მასივში ვამატებთ მას შესაბამის ინდექსზე.
        ციკლი დამთავდრება მაშინ როცა კურსორი წაიკითხავს ბოლო მონაცემს
        და მიანიჭებს მასივის ელემენტს
        */
        while($row = mysqli_fetch_assoc($result)){
            $users[]=$row;
        }
    }
    closeConnection();
    return $users;
}

//ფუნქცია ბაზასთან წვდომისთვის
function openConnection(){
    global $link;
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "roma_DB";

    $link = mysqli_connect($hostname,$username,$password,$database)
        or die ("error".mysqli_error($link));
}

//ფუნქცია ბაზასთან წვდომის დახურვისთვის
function closeConnection(){
    global $link;
    mysqli_close($link);
}
?>