<html>
    <head>
       <link rel="stylesheet" href="style.css">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
       <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Zen+Kurenaido&display=swap" rel="stylesheet">

<header>
    <div class="container-fluid" style="background-color: black;">
        <div class="row">
            <div class="col-2">
                <img src="logo.png" class="img-fluid p-2" style="width: 200px; height: 150px;">
                
            </div>
            <div class="col">
                <h1 class="text-center text-white" style="margin-top: 50px;">Weather Application</h1>
            </div>
            
        </div>
    </div>
  </header>
<body>


  <div class="row">
        <div class="col">

            <div class="btn-group btn-group-toggle col mt-4 p-4"  data-toggle="buttons">
            
                <button type="button" id="list" class="btn btn-warning btn-lg">List</button>
        
                <button type="button" id="grid" class="btn btn-dark btn-lg">Grid</button>

            </div>
        </div>
        <button class="btn btn-danger p-4 m-5"id="add" type="button"><b>Add City</b></button>
    </div>

    <div class="container bg-light" id="listcontainer">
        <div class="row">
            <div class="col mt-4">
                <table class="table table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">City</th>
                        <th scope="col">Country</th>
                        <th scope="col">Temperature</th>
                      </tr>
                    </thead>

                    <?php
                    include_once("config.php");
                    $select_sql = "SELECT * FROM `weather_table`";
                    $con_query = mysqli_query($con,$select_sql);
                    $count = 0;
                    while($row = mysqli_fetch_assoc($con_query))
                    {
                        $count = $count + 1;
                        ?>                            
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row["City"]; ?></td>
                                <td><?php echo $row["Country"]; ?></td>
                                <?php
                                    $city_name = $row["City"];
                                    $response = apireq($city_name);

                                    if(isset($response['weather'])){
                                        $temp =$response["main"]["temp"];

                                        $temp = (float)$temp;
                                        $temp =  $temp-273.15;
                                        echo'<td>'. $temp .'<sup>*</sup>C</td> ';

                                        // echo'<td>'. $response["weather"][0]["main"] .'</td> ';
                                    }
                                ?>
                            </tr>
                        <?php
                    }
   
        ?>

                    </table>
            </div>  
        </div>
    </div>
    
        
<div class="container" id="gridcontainer">
    <div class="row">
        <?php
            $con_query = mysqli_query($con,$select_sql);
            // print_r(mysqli_fetch_assoc($con_query));

            while($row = mysqli_fetch_assoc($con_query))    
            {
                ?>
                <div class="card m-2 p-5">
                    <h4 class="text-success " > 

                                            <?php
                                                $city_name = $row["City"];
                                                                $response = apireq($city_name);
                                                               
                                                                echo $weather_info[0];
         
                                                                $weather =  strtolower($response["weather"][0]["main"]);
                                                                 echo"</h5><img src='Image/$weather.png' class='rounded-circle'>";
                                                                echo '<h4>'.$response["weather"][0]["main"].'</h4>';                    
                                                                if(isset($response['weather'])){
                                                                    $temp =$response["main"]["temp"];

                                                                    $temp = (float)$temp;
                                                                    $temp =  $temp-273.15;
                                                                    echo '<div class="card-text mt-2 mb-1"> '. $temp .'<sup>*</sup>C</div>';
                                                                }
                                                                ?>
                                                <h5 class="card-title mt-2 mb-1"><?php echo $city_name; ?></h5>
                                                <div class="card-text mt-2 mb-1">Country:<?php echo $row["Country"]; ?> </div>
                                            

                </div>
                                        <?php
                                        }
                                        ?>
    </div>
</div>


    <div style= "margin-top: 25%;">
        <footer class="p-5 bg-dark">
            Weather
        </footer>

<div class="container-fluid" id="addcity">
    <div class="row">
        <div class="col-4 m-auto" id="Add_details">
            
                <form id="form" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                        <button type="button" id="close" class="btn btn-danger btn-sm" style="float:right; margin-top: -50px;">X</button>
                                </div>
                            </div>
                                

                        <label class="text-white">City Name</label>
                        <input type="text" class="form-control" id="City" name="City" placeholder="Enter City Name">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg mt-3">Search</button>

                        <p id="error_msg" class="mt-4 text-white">

                        </p>
                    </div>
                </form>
        </div>
    </div>
</div> 


<script type="text/javascript">



$(document).ready(function(){
$("#add").on('click',function(){
    $("#addcity").css("display","block");
})
$("#close").on('click',function(){
    $("#addcity").css("display","none");
})
$("#grid").on('click',function(){
    $("#listcontainer").css("display","none");
    $("#gridcontainer").css("display","block");
})
$("#list").on('click',function(){
    $("#gridcontainer").css("display","none");
    $("#listcontainer").css("display","block");
})
    $("#form").on('submit',function(e){
            e.preventDefault();
            $.ajax({
            url: 'insert.php',
            type : 'post',
            data : $("#form").serialize(),
            success: function(d){
                console.log(d);
                if(d=='fail'){
                    document.getElementById("error_msg").innerHTML ="Not found";
                }
                else{
                    document.getElementById("error_msg").innerHTML ="Updated";
                    window.location.reload();
                }
            }

        })
       
    })
   

})
</script>
</div>
</body> 
</html>