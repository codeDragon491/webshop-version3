<?php 

    try {
    
            // connect to the database
            require 'connect.php';
            // create a query 
            $query = $conn->prepare("SELECT users.userId, users.userName, users.firstName, users.lastName, 
            users.password, users.image, userRoles.userRole FROM users JOIN userRoles 
            ON users.userRoles_roleId = userRoles.roleId;");
            // run the query
            $bResult = $query->execute(); 
            //fetch the result as an associative array and turn it into a string
            $sajResult = json_encode( $query->fetchAll(PDO::FETCH_ASSOC) );
            // send response to the client if query true or false
            $sjResponse = $bResult ?  $sajResult : '{"status":"error"}'; 
            echo $sjResponse; 
    
    
    } catch (Exception $e) {
          
            echo "ERROR";
    
    }

?>