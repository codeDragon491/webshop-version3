<?php 

    try {
    
            // connect to the database
            require 'connect.php';
            // create a query to get all colum records
            $query = $conn->prepare("SELECT productCode, productName, buyPrice, quantityInStock, image FROM products ORDER BY productName");
            // run the query
            $bResult = $query->execute();
            // fetch the result as an associative array and turn it into a string
            $sajResult = json_encode( $query->fetchAll(PDO::FETCH_ASSOC) );
            // send response to the client if query is true or false
            $sjResponse = $bResult ? $sajResult : '{"status":"error"}'; 
            echo $sjResponse; 
    
    
    } catch (Exception $e) {
          
            echo "ERROR";
    
    }

?>  