<?php

require_once 'dbConnect.php';

$itemEng = $_POST["itemEng"];
$itemSin = $_POST["itemSin"];
$supplierCode = $_POST["supplierCode"];
$category = $_POST["category"];
$purchasedPrice = $_POST["purchasedPrice"];
$sellingPrice = $_POST["sellingPrice"];
$description = $_POST["description"];

$sql = "INSERT INTO item_list (supplierCode,CategoryCode,ItemName,ItemNameSinhala,PurchasedPrice,SellingPrice,CreatedDate,Status,OtherDescriptions) 
VALUES('$supplierCode','$category','$itemEng','$itemSin','$purchasedPrice','$sellingPrice',now(),1,'$description')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "New item added successfully.";
    echo "Item ID is : $last_id";
}else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);

?>
