<?php

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

ob_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storePos";

$arry = $_POST["order"];
$array = json_decode($arry,true);
$count = count($array);

$con = new mysqli($servername, $username, $password, $dbname);
if($con->connect_error){
    die("Connection failed: ".$con->connect_error);
}
//insert record Into daily_sales table and retrieve id
foreach($array as $item1 ){} //used this for loop to access totalQuantity and totalAmount
$sql = "INSERT INTO daily_sales (OrderDate, Quantity, ReturnStatus,TotalAmount,TotalPaid,TotalDiscount,CustomerId,UserId) 
        VALUES (now(), '".$item1["totalQuantity"]."',0,'".$item1["totalAmount"]."','".$item1["totalAmount"]."',0,1,1)";

if ($con->query($sql) === TRUE) {
    $last_id = $con->insert_id;
    foreach($array as $item )
    {
        if (--$count <= 0) {
            break;
        }
        //insert records Into daily_item_sales table 
        $sql = "INSERT INTO daily_item_sales (OrderId, ItemCode, Quantity,TotalDiscount,TotalPrice,OrderDate,ReturnStatus) 
                VALUES ($last_id, '".$item['id']."','".$item["quantity"]."',0,'".$item["subTotal"]."',now(),0)";

        if ($con->query($sql) === TRUE) {
            
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
    echo "Order ID is :". $last_id; //returns orderid to main page
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}

mysqli_close($con);

?>
