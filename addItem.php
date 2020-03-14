<?php
// Initialize the session
include 'database/dbConnect.php';

$sql = "SELECT * FROM  item_category WHERE Status=1 ";
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

  <link href="css.css" rel="stylesheet" />
</head>

<script>

$(function(){
  $("#nav-placeholder").load("navBar.html");
});

function showModal() {
      if ($("#itemEng").val()  &&  $("#itemSin").val() &&  $("#supplierCode").val()&&  $("#select-state").val()&&  $("#purchasedPrice").val() &&  $("#sellingPrice").val() &&  $("#description").val()) {
        var A = "<h4>Name-ENG: <kbd>" +$("#itemEng").val()+"</kbd></h4></br>";
        var B = "<h4>Name-Sin: <kbd>" +$("#itemSin").val()+"</kbd></h4></br>" ;
        var C = "<h4>supplier Code: <kbd>" +$("#supplierCode").val()+"</kbd></h4></br>";
        var D = "<h4>Category: <kbd>" +$("#select-state").children("option").html()+"</kbd></h4></br>" ;
        var E = "<h4>Purchased Price: <kbd> Rs " +$("#purchasedPrice").val()+".00</kbd></h4></br>";
        var F = "<h4>Selling Price: <kbd> Rs " +$("#sellingPrice").val()+".00</kbd></h4></br>" ;
        var G = "<h4>Description: <kbd>" +$("#description").val()+"</kbd></h4></br>" ;
        $("#modelBody").html(A+B+C+D+E+F+G);
        $('#confirmModel').modal('show');
      }

}
function closeNrelaod(){
  location.reload();
}

function addItem() {
  $('#confirmModel').data('bs.modal')._config.backdrop = 'static'; 

  $.ajax({
    url:"database/addItemDb.php",
    type:"post",
    data: {'itemEng': $("#itemEng").val(), 'itemSin': $("#itemSin").val(),'supplierCode': $("#supplierCode").val(), 'category': $("#select-state").val(),'purchasedPrice': $("#purchasedPrice").val(), 'sellingPrice': $("#sellingPrice").val(), 'description': $("#description").val()},
    success:function(data){
        document.getElementById("modelBody").innerHTML = data;
        if (data.indexOf("item") > -1){
          document.getElementById("modelFooter").innerHTML = "<button type=\"button\" class=\"btn btn-success\" onclick=\"closeNrelaod();\">Close</button>";
        } 
    },
    error: function() {
      console.log("failed");    //prints "string"
    }
  });
}

$(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });


</script>

<body>

<div id="nav-placeholder"></div>
<div class="container-fluid">
</br></br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Item Name-English</span>
        </div>
        <input type="text" class="form-control" id="itemEng">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Item Name-සිංහල &nbsp;&nbsp;</span>
        </div>
        <input type="text" class="form-control" id="itemSin" >
    </div>
    
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">supplier Code &nbsp;&nbsp;</span>
        </div>
        <input type="text" class="form-control" id="supplierCode" >
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Category &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </div>
        <select id="select-state" class="form-control" placeholder="Pick a state...">
            <option value="">Select a state...</option>
            <?php
                while($row = $result->fetch_assoc()){
                    echo '<option value="'.$row["CategoryCode"].'">'.$row["Category"].'</option>';
                    
                }
                $result->close();
                $conn->next_result();
            ?>
        </select>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Purchased Price &nbsp;&nbsp;</span>
        </div>
        <input type="text" class="form-control" id="purchasedPrice" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Selling Price &nbsp;&nbsp;</span>
        </div>
        <input type="text" class="form-control" id="sellingPrice" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Description &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </div>
        <input type="text" class="form-control" id="description" >
    </div>

    <button type="submit" class="btn btn-primary" onclick=" showModal();">Create Category</button> </br></br>
  </div>
</div>

<table class="table  table-hover ">
  <thead class="thead-dark">
      <tr>
        <th>Item Code </th>
        <th>supplier Code</th>
        <th>Category Code</th>
        <th>Item Name-English</th>
        <th>Ite Name-සිංහල</th>
        <th>Purchased Price</th>
        <th>Selling Price</th>
        <th>Created Date</th>
        <th>OtherDescriptions</th>
      </tr>
  </thead>
    <tbody class = "tableBody" class = "tableBody">
      <?php
      $sql = "SELECT * FROM  item_list WHERE Status=1 ORDER BY ItemCode DESC LIMIT 100";
      $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
          echo '<tr><td>'.$row["ItemCode"].'</td><td>'.$row["supplierCode"].'</td><td>'.$row["CategoryCode"].'</td><td>'.$row["ItemName"].'</td><td>'.$row["ItemNameSinhala"].'</td><td>'.$row["PurchasedPrice"].'</td><td>'.$row["SellingPrice"].'</td><td>'.$row["CreatedDate"].'</td><td>'.$row["OtherDescriptions"].'</td></tr>';
        }
        $result->close();
        $conn->next_result();
      ?>
    </tbody>                              
</table>




</div>

<!-- day close model -->
<div class="modal fade" id="confirmModel">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header" id ="modelHeader">
          <h4 class="modal-title">Confirm item details</h4>
        </div>
        <!-- Modal body -->
        <div class="modal-body" id ="modelBody"></div>
        <!-- Modal footer -->
        <div class="modal-footer" id ="modelFooter">
        <button type="button" class="btn btn-primary" onclick="addItem();">Confirm</button>
        </div>
        
      </div>
    </div>
  </div>

</body>
</html>