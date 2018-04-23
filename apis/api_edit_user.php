<?php

// Get the userimage and save it with a unique id
$sFileExtension = pathinfo($_FILES['fileUserImage']['name'], PATHINFO_EXTENSION);
$sFolder = 'images/';
$sFileName = 'userimage-' . uniqid() . '.' . $sFileExtension;
$sSaveFileTo = $sFolder . $sFileName;
move_uploaded_file($_FILES['fileUserImage']['tmp_name'], $sSaveFileTo);

// data from the browser
$sUserId = $_POST['txtUserId'];
$sNewUserRole = $_POST['txtUserRole'];
$sNewUserName = $_POST['txtEmailorPhoneNumber'];
$sNewFirstName = $_POST['txtFirstName'];
$sNewLastName = $_POST['txtLastName'];
$sNewPassword = $_POST['txtPassword'];
$sNewImagePath = $sFolder . $sFileName;

try {

    // connect to the database
    require 'connect.php';
    // create a query
    $query = $conn->prepare("UPDATE users SET userName=:userName, firstName=:firstName,
        lastName=:lastName, password=:password, image=:image, userRoles_roleId=:userRole
        WHERE userId=:userId");
    $query->bindParam(':userId', $sUserId);
    $query->bindParam(':userRole', $sNewUserRole);
    $query->bindParam(':userName', $sNewUserName);
    $query->bindParam(':firstName', $sNewFirstName);
    $query->bindParam(':lastName', $sNewLastName);
    $query->bindParam(':password', $sNewPassword);
    $query->bindParam(':image', $sNewImagePath);
    // run the query
    $bResult = $query->execute();
    // send response to the client if query is true or false
    $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}';
    echo $sjResponse;

} catch (Exception $e) {

    echo "ERROR";

}
