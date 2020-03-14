<?php

require_once 'dbConnect.php';

$float = $_POST["float"];
$Status = $_POST["Status"];

if(!$Status){
    $sql = "UPDATE day_end SET EndFloat=$float, CloseDate=now(), Status=1 WHERE Status=0";

    if ($conn->query($sql) === TRUE) {
        echo "Day Closed successfully. Please open a new day to start sales.";
    }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}else{
    $sql = "INSERT INTO day_end (OpenDate,CloseDate,StartFloat,EndFloat,ItemCount,Status) VALUES (now(),now(),$float,0,0,0)";

    if ($conn->query($sql) === TRUE) {
        echo "Day opened successfully. You can start sales.";
    }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

mysqli_close($conn);

?>
