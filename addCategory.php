<?php
// Initialize the session
include 'database/dbConnect.php';

$sql = "SELECT * FROM  item_category WHERE Status=1 ORDER BY CategoryCode DESC";
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

function showModal() {
      if ($("#catEng").val()  &&  $("#catSin").val()) {
        document.getElementById("modelBody").innerHTML = "<h2>Your new category is <kbd>" +$("#catEng").val()+"</kbd> / <kbd>" +$("#catSin").val()+"</kbd>.</h2></br><h3><kbd>" +$("#catDes").val()+"</kbd></h3>";
        $('#confirmModel').modal('show');
      }
}
function closeNrelaod(){
  location.reload();
}

function addCat() {
  $('#confirmModel').data('bs.modal')._config.backdrop = 'static'; 

  $.ajax({
    url:"database/addCatDb.php",
    type:"post",
    data: {'catEng': $("#catEng").val(), 'catSin': $("#catSin").val(), 'catDes': $("#catDes").val()?$("#catDes").val():'N/A'},
    success:function(data){
        document.getElementById("modelBody").innerHTML = data;
        if (data.indexOf("Category") > -1){
          document.getElementById("modelFooter").innerHTML = "<button type=\"button\" class=\"btn btn-success\" onclick=\"closeNrelaod();\">Close</button>";
        } 
    },
    error: function() {
      console.log("failed");    //prints "string"
    }
  });
}


</script>

<body>

<div id="nav-placeholder"></div>
<div class="container-fluid">
</br></br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">New Category - English</span>
        </div>
        <input type="text" class="form-control" id="catEng">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">New Category - සිංහල &nbsp;&nbsp;</span>
        </div>
        <input type="text" class="form-control" id="catSin" >
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Description &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </div>
        <input type="text" class="form-control" id="catDes" >
    </div>


    <button type="submit" class="btn btn-primary" onclick=" showModal();">Create Category</button> </br></br>
  </div>
</div>


<table class="table  table-hover ">
  <thead class="thead-dark">
      <tr>
        <th>CategoryCode </th>
        <th>Category(En)</th>
        <th>Category(Sin)</th>
        <th>Description</th>
        <th>DateEntered</th>
      </tr>
  </thead>
    <tbody class = "tableBody" class = "tableBody">
      <?php
        while($row = $result->fetch_assoc()){
          echo '<tr><td>'.$row["CategoryCode"].'</td><td>'.$row["Category"].'</td><td>'.$row["CategorySinhala"].'</td><td>'.$row["description"].'</td><td>'.$row["DateEntered"].'</td></tr>';
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
          <h4 class="modal-title">Confirm adding a category</h4>
        </div>
        <!-- Modal body -->
        <div class="modal-body" id ="modelBody"></div>
        <!-- Modal footer -->
        <div class="modal-footer" id ="modelFooter">
        <button type="button" class="btn btn-primary" onclick="addCat();">Confirm</button>
        </div>
        
      </div>
    </div>
  </div>

</body>
</html>