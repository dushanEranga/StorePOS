<?php
// Initialize the session
include 'dbConnect.php';

$sql = "SELECT CategoryCode , Category, CategorySinhala FROM  item_category WHERE Status=1";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link href="css.css" rel="stylesheet" />
</head>

<script>
$(function(){
  $("#nav-placeholder").load("navBar.html");
});
</script>

<body>

<div id="nav-placeholder"></div>

</body>
</html>