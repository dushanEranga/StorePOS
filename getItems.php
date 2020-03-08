<?php

require_once 'dbConnect.php';

$q = intval($_GET['q']);

$sql = "SELECT ItemCode , supplierCode, CategoryCode, ItemName, ItemNameSinhala, SellingPrice, OtherDescriptions FROM item_list WHERE Status=1 AND CategoryCode='".$q."'";

$result = mysqli_query($conn,$sql);

ob_end_clean();

while($row = mysqli_fetch_array($result)){
    //echo '<div class="box" id="'.$row['ItemCode'].'" onclick="showItems('.$row['ItemCode'].')"'.'>'.$row['ItemName'].'</div> </div>';
    echo '<div class="box" id="'.$row['ItemCode'].'"  >
            <div><span class="name">'.$row['ItemName'].'</span></div> <span>: RS. </span>
            <div><span class="price">'.$row['SellingPrice'].'</span> </div>
          </div>';
}
mysqli_close($conn);


?>

