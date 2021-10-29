<?php

$con = mysqli_connect("localhost","root","Admin@321","weather");

if(!$con){
    echo " connection not successful".mysqli_error($con);
    
    }  
else{
    // echo "success";
    }

    
        function replaceJsonString($response) {
            $escapers = array("\'");
            $replace = array("\\/");
            $result = str_replace($escapers, $replace, $response);
            return $result;
        }
  
function apireq($city_name)
    {
        $url = 'https://api.openweathermap.org/data/2.5/weather?q='.$city_name.'&appid=fff7c83f41ced58422d5b40ec3c0c01a';
    
        $curl = curl_init($url);
    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        curl_setopt($curl, CURLOPT_POST, true);
    
        $response = curl_exec($curl);
    
        $curl_response = replaceJsonString($response);
    
        $response = json_decode($response,true);
    
        curl_close($curl);

        return $response;
    }

    ?>