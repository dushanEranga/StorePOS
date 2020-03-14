<?php

require_once 'dbConnect.php';

$arry = $_POST["order"];
$array = json_decode($arry,true);
$count = count($array);

foreach($array as $item1 ){} //used this for loop to access totalQuantity and totalAmount
$totalQuantity = $item1["totalQuantity"];
$totalAmount = $item1["totalAmount"];
$discount = 0;

//insert record Into daily_sales table and retrieve id
$sql = "CALL  placeOrder(".$totalQuantity.",".$totalAmount.",".$totalAmount.",0,1,1,0,@LID)";
if ($conn->query($sql) === TRUE) {
    $result = $conn->query("SELECT @LID as id");
    while($row = $result->fetch_assoc()){
        $lastID = $row["id"];
      }
    echo "Order ID is :". $lastID; //returns orderid to main page
}


foreach($array as $item ){ //used this for loop to access totalQuantity and totalAmount

    if (--$count <= 0) {
    break;
}

    $sql = "CALL placeOrderDetails(".$lastID.",".$item["id"].",".$item["quantity"].",".$item["subTotal"].",0,".$item["unitPrice"].",0,1,1)";


    if ($conn->query($sql) === TRUE) {
         
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->next_result();
}

//$rs=$conn->store_result();

$sql = "CALL AddItemCount(".$totalQuantity.")";

if ($conn->query($sql) === TRUE) {
    //echo "Order ID is :". $lastID; //returns orderid to main page
}else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);

?>
