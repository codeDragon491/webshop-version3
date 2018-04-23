<?php

// Get the productimage and save it with a unique id
$sFileExtension = pathinfo($_FILES['fileProductImage']['name'], PATHINFO_EXTENSION);
$sFolder = 'images/';
$sFileName = 'productimage-' . uniqid() . '.' . $sFileExtension;
$sSaveFileTo = $sFolder . $sFileName;
move_uploaded_file($_FILES['fileProductImage']['tmp_name'], $sSaveFileTo);

// data from the browser
$sProductCode = $_POST['txtProductCode'];
$sNewProductName = $_POST['txtProductName'];
$sNewBuyPrice = $_POST['nrProductPrice'];
$sNewQuantityInStock = $_POST['nrProductQuantity'];
$sNewImagePath = $sFolder . $sFileName;

try {

    // connect to the database
    require 'connect.php';
    // create a query
    $query = $conn->prepare("UPDATE products SET productName=:productName,
            quantityInStock=:quantityInStock, buyPrice=:buyPrice, image=:image WHERE productCode=:productCode");
    $query->bindParam(':productCode', $sProductCode);
    $query->bindParam(':productName', $sNewProductName);
    $query->bindParam(':quantityInStock', $sNewQuantityInStock);
    $query->bindParam(':buyPrice', $sNewBuyPrice);
    $query->bindParam(':image', $sNewImagePath);
    // run the query
    $bResult = $query->execute();
    // send response to the client if query is true or false
    $sjResponse = $bResult ? '{"status":"ok"}' : '{"status":"error"}';
    echo $sjResponse;

} catch (Exception $e) {

    echo "ERROR";

}
