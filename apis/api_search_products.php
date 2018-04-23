<?php

  // data from the BROWSER
  $sSearch = $_GET['search'];
  // TURN it into UPPERCASE
  strtoupper( $sSearch );

try {
    
            // connect to the database
            require 'connect.php';
            // create a query to get all column records where search value equals productName
            $queryOne = $conn->prepare("SELECT productCode, productName, buyPrice, quantityInStock, image FROM products WHERE productName=:productName");
            $queryOne->bindParam( ':productName' , $sSearch );
            // run the query
            $queryOne->execute();
            // fetch result as an associative array an turn it to a string
            $sajResultOne = json_encode($queryOne->fetchAll(PDO::FETCH_ASSOC));
            // create another query: select all products if search does not match any productName
            $queryTwo = $conn->prepare("SELECT productCode, productName, buyPrice, quantityInStock, image FROM products");
            // run second query
            $queryTwo->execute();
            // fetch result as an associative array an turn it to a string
            $sajResultTwo = json_encode($queryTwo->fetchAll(PDO::FETCH_ASSOC)); 
            // send response to the client if query result empty or not
            $sjResponse = $queryOne->rowCount() == 1 ? $sajResultOne : $sajResultTwo;
            echo $sjResponse; 

    } catch (Exception $e) {
        
        echo "ERROR";

    }
    
?>