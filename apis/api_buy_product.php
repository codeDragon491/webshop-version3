<?php

    // data from the browser
    $sProductCode = $_GET['code'];

    try {
        // connect to the database
        require 'connect.php';
        // create a query
        $query = $conn->prepare("UPDATE products SET quantityInStock=quantityInStock-1 
        WHERE productCode=:productCode");
        $query->bindParam( ':productCode' , $sProductCode );
        // run the query
        $bResult = $query->execute();
        // send response to the client if the query is true or false
        $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}';
        echo $sjResponse;


    } catch (Exception $e) {
        
        echo "ERROR";

    }
?>
