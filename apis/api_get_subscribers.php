<?php 

    try {
    
            // connect to the database
            require 'connect.php';
            // create a query to get all column records
            $query = $conn->prepare("SELECT subscriberId, email, firstName, lastName, geoLocationLatitude, geoLocationLongtitude FROM subscribers ORDER BY firstName,lastName");
            // run the query
            $bResult = $query->execute(); 
            // fetch the result as an asocciative array and turn it into a string
            $sajResult = json_encode( $query->fetchAll(PDO::FETCH_ASSOC) ); 
            // send response to the client if the query is true or false
            $sjResponse = $bResult ?  $sajResult : '{"status":"error"}'; 
            echo $sjResponse; 
    
    
    } catch (Exception $e) {
          
            echo "ERROR";
    }

?>