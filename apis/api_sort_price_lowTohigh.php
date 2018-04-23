<?php

try {
    
            // connect to the database
            require 'connect.php';
            // create a query to get all column records by price low to high
            $query = $conn->prepare("SELECT productCode, productName, buyPrice, quantityInStock, image FROM products ORDER BY buyPrice");
            // run the query
            $bResult = $query->execute();
            // fetch result as an associative array and turn it to a string
            $sajResult = json_encode($query->fetchAll(PDO::FETCH_ASSOC));                                                                                                                                                                                                     
            // send response to the client if query true or false
            $sjResponse = $bResult ? $sajResult : '{"status":"error"}'; 
            echo $sjResponse;

    } catch (Exception $e) {
        
        echo "ERROR";

    }

?>
