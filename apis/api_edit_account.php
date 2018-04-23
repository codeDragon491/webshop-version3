<?php

// Get the userimage and save it with a unique id
$sFileExtension = pathinfo($_FILES['fileUserImage']['name'], PATHINFO_EXTENSION);
$sFolder = 'images/';
$sFileName = 'userimage-' . uniqid() . '.' . $sFileExtension;
$sSaveFileTo = $sFolder . $sFileName;
move_uploaded_file($_FILES['fileUserImage']['tmp_name'], $sSaveFileTo);

// data from the browser
$sUserId = $_POST['txtUserId'];
$sNewUserName = $_POST['txtEmailorPhoneNumber'];
$sNewFirstName = $_POST['txtFirstName'];
$sNewLastName = $_POST['txtLastName'];
$sNewPassword = $_POST['txtPassword'];
$sNewImagePath = $sFolder . $sFileName;

try {

    // connect to the database
    require 'connect.php';
    // create an update query
    //$conn->beginTransaction();
    $queryUpdate = $conn->prepare("UPDATE users SET userName=:userName, firstName=:firstName,
            lastName=:lastName, password=:password, image=:image  WHERE userId=:userId");
    $queryUpdate->bindParam(':userId', $sUserId);
    $queryUpdate->bindParam(':userName', $sNewUserName);
    $queryUpdate->bindParam(':firstName', $sNewFirstName);
    $queryUpdate->bindParam(':lastName', $sNewLastName);
    $queryUpdate->bindParam(':password', $sNewPassword);
    $queryUpdate->bindParam(':image', $sNewImagePath);
    $bResult = $queryUpdate->execute();
    // create another query to get some of the updated values
    /*$querySelect = $conn->prepare("SELECT users.userName, users.firstName, users.lastName, users.image
    FROM users WHERE userId=:userId");
    $querySelect->bindParam( ':userId' , $sUserId );
    // run query
    $querySelect->execute();
    $ajResult = $querySelect->fetch(PDO::FETCH_ASSOC);
    // take each property one by one
    $sUserName = $ajResult['userName'];
    $sFirstName = $ajResult['firstName'];
    $sLastName = $ajResult['lastName'];
    $sImagePath = $ajResult['image'];*/
    // i.e. no query has failed, and we can commit the transaction
    //$conn->commit();
    $sjResponse = ($bResult && $queryUpdate->rowCount() == 1) ? '{"status":"ok", "userName":"' . $sNewUserName . '", "firstName":"' . $sNewFirstName . '",
             "lastName":"' . $sNewLastName . '", "image":"' . $sNewImagePath . '"}' : '{"status":"error"}';
    echo $sjResponse;
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    echo "ERROR";
    //$conn->rollback();

}
