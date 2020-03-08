<?php

require_once 'dbConnect.php';

$arry = $_POST["order"];
$array = json_decode($arry,true);
$count = count($array);

//insert record Into daily_sales table and retrieve id
foreach($array as $item1 ){} //used this for loop to access totalQuantity and totalAmount
$sql = "INSERT INTO daily_sales (OrderDate, Quantity, ReturnStatus,TotalAmount,TotalPaid,TotalDiscount,CustomerId,UserId) 
        VALUES (now(), '".$item1["totalQuantity"]."',0,'".$item1["totalAmount"]."','".$item1["totalAmount"]."',0,1,1)";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    foreach($array as $item )
    {
        if (--$count <= 0) {
            break;
        }
        //insert records Into daily_item_sales table 
        $sql = "INSERT INTO daily_item_sales (OrderId, ItemCode, Quantity,TotalDiscount,TotalPrice,OrderDate,ReturnStatus) 
                VALUES ($last_id, '".$item['id']."','".$item["quantity"]."',0,'".$item["subTotal"]."',now(),0)";

        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        
        $conn->next_result();

        $sql = "CALL AddItemCount(".$item["quantity"].")";

        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    echo "Order ID is :". $last_id; //returns orderid to main page
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);

?>
