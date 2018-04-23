<?php
// Get the userimage and save it with a unique id
$sFileExtension = pathinfo($_FILES['fileUserImage']['name'], PATHINFO_EXTENSION);
$sFolder = 'images/';
$sFileName = 'userimage-' . uniqid() . '.' . $sFileExtension;
$sSaveFileTo = $sFolder . $sFileName;
move_uploaded_file($_FILES['fileUserImage']['tmp_name'], $sSaveFileTo);

// data form browser
$sUserRole = $_POST['txtUserRole'];
$sUserName = $_POST['txtEmailorPhoneNumber'];
$sFirstName = $_POST['txtFirstName'];
$sLastName = $_POST['txtLastName'];
$sPassword = $_POST['txtPassword'];
$sImagePath = $sFileName;

try {

    // connect to the database
    require 'connect.php';
    // create query
    $query = $conn->prepare("INSERT INTO users ( userName, firstName, lastName, password, image,
        userRoles_roleId  ) VALUES ( :userName, :firstName, :lastName, :password, :image, :userRole )");
    $query->bindParam(':userName', $sUserName);
    $query->bindParam(':firstName', $sFirstName);
    $query->bindParam(':lastName', $sLastName);
    $query->bindParam(':password', $sPassword);
    $query->bindParam(':image', $sImagePath);
    $query->bindParam(':userRole', $sUserRole);
    // run the query
    $bResult = $query->execute();
    // send response to the client if the query is true or false
    $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}';
    echo $sjResponse;

} catch (Exception $e) {

    echo "ERROR";

}
