<?php

        // data from the browser
        $sUserId = $_GET['id'];

        try {
                // connect to the database
                require 'connect.php';
                // create a query
                $query = $conn->prepare("DELETE FROM users WHERE userId=:userId");
                $query->bindParam( ':userId' , $sUserId );
                // run the query
                $bResult = $query->execute();
                // send response to the client if query is true or false
                $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}'; 
                echo $sjResponse;
        
        
        } catch (Exception $e) {
                
                echo "ERROR";
        
        }

?>
