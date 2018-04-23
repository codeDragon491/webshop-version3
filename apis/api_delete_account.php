<?php

        // Data comes from the browser
        $sUserName = $_POST['txtEmailorPhoneNumber'];
        $sPassword = $_POST['txtPassword'];

        try {
                
                // connect to the database
                require 'connect.php';
                // create a query
                $query = $conn->prepare("DELETE FROM users WHERE userName=:userName AND password=:password");
                $query->bindParam( ':userName' , $sUserName );
                $query->bindParam( ':password' , $sPassword );
                // run the query
                $bResult = $query->execute();
                $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}'; // means if the query is true or false
                echo $sjResponse;


        } catch (Exception $e) {
        
                echo "ERROR";

        }

?>


