<?php

// get the productimage and save it with a unique id
$sFileExtension = pathinfo($_FILES['fileProductImage']['name'], PATHINFO_EXTENSION);
$sFolder = 'images/';
$sFileName = 'productimage-' . uniqid() . '.' . $sFileExtension;
$sSaveFileTo = $sFolder . $sFileName;
move_uploaded_file($_FILES['fileProductImage']['tmp_name'], $sSaveFileTo);

// create 12 digits productCode with a prefix of 10
$prefix = 10;
$randnum = rand(1111111111, 9999999999);
$sProductCode = $prefix . $randnum;
// data from the browser
$sProductName = $_POST['txtProductName'];
$sQuantityInStock = $_POST['nrProductQuantity'];
$sBuyPrice = $_POST['nrProductPrice'];
$sImagePath = $sFolder . $sFileName;

try {

    // connect to the database
    require 'connect.php';
    // create query
    $query = $conn->prepare("INSERT INTO products ( productCode, productName, quantityInStock, buyPrice, image ) VALUES ( :productCode, :productName, :quantityInStock, :buyPrice, :image )");
    $query->bindParam(':productCode', $sProductCode);
    $query->bindParam(':productName', $sProductName);
    $query->bindParam(':quantityInStock', $sQuantityInStock);
    $query->bindParam(':buyPrice', $sBuyPrice);
    $query->bindParam(':image', $sImagePath);
    // run the query
    $bResult = $query->execute();
    // send response to teh client if the query is true or false
    $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}';
    echo $sjResponse;

} catch (Exception $e) {

    echo "ERROR";

}
