<?php

    session_start();

    // data from the browser
    $sUserName = $_POST['txtEmailorPhoneNumber'];
    $sPassword = $_POST['txtPassword'];

    try {
        
        // connect to the database
        require 'connect.php';
        // create a query to compare data in the database with data from the browser
        $query = $conn->prepare("SELECT users.userId, users.userName, users.firstName, users.lastName, 
        users.password, users.image, userRoles.userRole FROM users JOIN userRoles ON 
        users.userRoles_roleId = userRoles.roleId WHERE userName=:userName AND password=:password");
        $query->bindParam( ':userName' , $sUserName );
        $query->bindParam( ':password' , $sPassword );
        // run query 
        $bResult = $query->execute();  
        $ajResult = $query->fetch(PDO::FETCH_ASSOC);
        // take each property one by one
        $sUserId = $ajResult['userId'];
        $_SESSION['sUserId'] = $sUserId;
        $sUserRole = $ajResult['userRole'];
        $sUserName = $ajResult['userName'];
        $sFirstName = $ajResult['firstName'];
        $sLastName = $ajResult['lastName'];
        $sImagePath = $ajResult['image'];
        $sjResponse = $query->rowCount() == 1 ? '{"status":"ok", "userId":"'.$sUserId.'", 
        "userRole":"'.$sUserRole.'", "userName":"'.$sUserName.'", "firstName":"'.$sFirstName.'", 
        "lastName":"'.$sLastName.'", "image":"'.$sImagePath.'"}' : '{"status":"error"}'; 
        echo $sjResponse; 
            } catch (Exception $e) {
            
                echo "ERROR";
        
            }
?>
