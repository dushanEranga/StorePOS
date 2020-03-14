<?php

require_once 'dbConnect.php';

$catEng = $_POST["catEng"];
$catSin = $_POST["catSin"];
$catDes = $_POST["catDes"];


$sql = "INSERT INTO item_category (Category,CategorySinhala,description,Status,DateEntered) VALUES('$catEng','$catSin','$catDes',1,now())";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "Category added successfully.";
    echo "Category ID is : $last_id";
}else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);

?>
