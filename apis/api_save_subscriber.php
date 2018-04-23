<?php

       // data from the browser
       $sEmail =  $_POST['txtEmail'];
       $sFirstName = $_POST['txtFirstName'];
       $sLastName = $_POST['txtLastName'];
       $sGeoLocationLatitude = $_POST['lat'];
       $sGeoLocationLongtitude = $_POST['lng'];

    try {
    
        // connect to the database
        require 'connect.php';
        // create a query to insert into subscribers
        $query = $conn->prepare("INSERT INTO subscribers ( email, firstName, lastName, 
        geoLocationLatitude, geoLocationLongtitude ) VALUES ( :email, :firstName, :lastName, :geoLocationLatitude, :geoLocationLongtitude )");
        $query->bindParam( ':email' , $sEmail );
        $query->bindParam( ':firstName' , $sFirstName );
        $query->bindParam( ':lastName' , $sLastName );
        $query->bindParam( ':geoLocationLatitude' , $sGeoLocationLatitude );
        $query->bindParam( ':geoLocationLongtitude' , $sGeoLocationLongtitude );
        // run the query
        $bResult = $query->execute();
        // send response to the client if the query is true or false
        $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}'; 
        echo $sjResponse; 
    
    
        } catch (Exception $e) {
          
            echo "ERROR";
    
        }

?>
