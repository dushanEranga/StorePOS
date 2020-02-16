<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storePos";


$q = intval($_GET['q']);
$con = new mysqli($servername, $username, $password, $dbname);
if($con->connect_error){
    die("Connection failed: ".$con->connect_error);
}

$sql = "SELECT ItemCode , supplierCode, CategoryCode, ItemName, ItemNameSinhala, SellingPrice, OtherDescriptions FROM item_list WHERE Status=1 AND CategoryCode='".$q."'";

$result = mysqli_query($con,$sql);


?>

<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}

body {
  margin: 40px;
}
.wrapper {
  display: grid;
  grid-template-rows: 100px 100px;
  grid-template-columns: 100px 100px 100px;
  grid-gap: 10px;
  background-color: #fff;
  color: #444;
  grid-template-columns: auto auto auto auto ;
}
.box {
  background-color: #444;
  border-radius: 5px;
  color: #fff;
  font-size: 150%;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: all 0.6s; /*sets a transition (for hover effect)*/
}
.box:hover {
  background: tomato; /*sets background colour*/
}
</style>
</head>
<body>


<div class="wrapper">
    <?php
        while($row = mysqli_fetch_array($result)){
            echo '<div class="box" onclick="showItems('.$row['ItemCode'].')"'.'>'.$row['ItemName'].'</div>';
        }
        mysqli_close($con);
    ?>
</div>
<script>
function showItems(str) {
  var xhttp;  
  document.getElementById("div1").innerHTML = "";
  if (str == "") {
    document.getElementById("div1").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("div1").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "./getCategories.php", true);
  xhttp.send();
}
</script>

</body>
</html>





