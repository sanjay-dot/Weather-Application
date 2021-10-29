<?php

include("config.php");

$city_name = $_POST["City"];

if(ctype_alpha($city_name)){

$response = apireq($city_name);

if(isset($response["weather"])){

    $country = $response["sys"]["country"];
    
    echo $country;

    $sql_i = "INSERT INTO `weather_table`(`City`, `Country`) VALUES ('{$city_name}','{$country}')";

    if(mysqli_query($con,$sql_i)){
        echo "sucess";
    }

    else{
        echo "fail";
    }
}

else{
    echo "fail";
}

}

else{
    echo "fail";
}

   
?>