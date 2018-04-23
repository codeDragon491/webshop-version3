<?php
// get the userimage and save it with a unique id
$sFileExtension = pathinfo($_FILES['fileUserImage']['name'], PATHINFO_EXTENSION);
$sFolder = 'images/';
$sFileName = 'userimage-' . uniqid() . '.' . $sFileExtension;
$sSaveFileTo = $sFolder . $sFileName;
move_uploaded_file($_FILES['fileUserImage']['tmp_name'], $sSaveFileTo);

// data from the browser
$sUserName = $_POST['txtEmailorPhoneNumber'];
$sFirstName = $_POST['txtFirstName'];
$sLastName = $_POST['txtLastName'];
$sPassword = $_POST['txtPassword'];
$sImage = $sFolder . $sFileName;

try {

    // connect to the database
    require_once 'connect.php';
    // create a query to check if there are any records in the users table
    $querySelect = $conn->prepare("SELECT COUNT(userId) FROM users");
    // run the query
    $querySelect->execute();
    // fetch the result as an array indexed by column number as returned in the result set and turn it into a string
    $sajResult = json_encode($querySelect->fetch(PDO::FETCH_NUM));
    $sajResult === '["0"]' ? $sUserRole = 1 : $sUserRole = 2;
    // create another query to insert into users
    $queryInsert = $conn->prepare("INSERT INTO users ( userName, firstName, lastName, password, image,
                userRoles_roleId  ) VALUES ( :userName, :firstName, :lastName, :password, :image, :userRole )");
    $queryInsert->bindParam(':userName', $sUserName);
    $queryInsert->bindParam(':firstName', $sFirstName);
    $queryInsert->bindParam(':lastName', $sLastName);
    $queryInsert->bindParam(':password', $sPassword);
    $queryInsert->bindParam(':image', $sImage);
    $queryInsert->bindParam(':userRole', $sUserRole);
    // run the query
    $bResult = $queryInsert->execute();
    // send response to the client if the query is true or false
    $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}';
    echo $sjResponse;

} catch (Exception $e) {

    echo "ERROR";

}
