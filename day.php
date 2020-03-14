<?php
// Initialize the session
include 'database/dbConnect.php';

$sql = "SELECT * FROM  day_end ORDER BY DayId DESC LIMIT 1";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    $currentstartDay = strtotime($row["OpenDate"]);
    $currentStatus = $row["Status"];
}

$result->close();
$conn->next_result();

$sql = "SELECT * FROM  day_end";
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

console.log("<?php echo $currentStatus ?>");
$(function(){
  $("#nav-placeholder").load("navBar.html");
});


function showModal(expression) {
  switch(expression) {
    case 1:
      if ($("#float").val() > 0) {
        document.getElementById("modelBody").innerHTML = "<h2>Your closing balance is <kbd>" +$("#float").val()+ ".00</kbd> Rupees.</h2>";
        $('#confirmModel').modal('show');
      }
      break;
    case 2:
      document.getElementById("modelBody").innerHTML = "<h2>Your opening balance is <kbd>" +$("#float").val()+ ".00</kbd> Rupees.</h2>";
        $('#confirmModel').modal('show');
      break;
  }
}

function closeNrelaod(){
  location.reload();
}

function openCloseDay() {
  $('#confirmModel').data('bs.modal')._config.backdrop = 'static'; 

  $.ajax({
    url:"database/closeOpenDayDb.php",
    type:"post",
    data: {'float': $("#float").val(), 'Status': <?php echo $currentStatus ?>},
    success:function(data){
        document.getElementById("modelBody").innerHTML = data;
        if (data.indexOf("sales") > -1){
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

<div class="panel panel-default">
  <div class="panel-body">
    <?php  
      if(!$currentStatus){
        echo ('<h2> Current day :  '.date("Y/m/d",$currentstartDay).'</h2></br></br>');
        echo ('
                <label for="quantity">Closing Float</label>
                <input type="number" id="float" name="float" min="1" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                <button type="submit" class="btn btn-primary" onclick=" showModal(1);">Close Day</button> 
              </br></br>'
            );
      }else {
        echo ('<h2> Please open a new day <h2></br>');
        echo ('
                <label for="quantity">Open Float</label>
                <input type="number" id="float" name="float" min="1" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                <button type="submit" class="btn btn-primary" onclick=" showModal(2);">Open Day</button> 
              </br></br>'
            );
      }
    
    ?>
  </div>
</div>


<table class="table  table-hover ">
  <thead class="thead-dark">
      <tr>
        <th>DayId </th>
        <th>Open Date</th>
        <th>Close Date</th>
        <th>Start Float</th>
        <th>End Float</th>
        <th>Item Count</th>
        <th>Status</th>
      </tr>
  </thead>
    <tbody class = "tableBody" class = "tableBody">
      <?php
        while($row = $result->fetch_assoc()){
          echo '<tr><td>'.$row["DayId"].'</td><td>'.$row["OpenDate"].'</td><td>'.$row["CloseDate"].'</td><td>'.$row["StartFloat"].'</td><td>'.$row["EndFloat"].'</td><td>'.$row["ItemCount"].'</td><td>'.$row["Status"].'</td></tr>';
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
          <h4 class="modal-title">Confirm day closing.</h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id ="modelBody">
          
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer" id ="modelFooter">
        <button type="button" class="btn btn-primary" onclick="openCloseDay();">Confirm</button>
        </div>
        
      </div>
    </div>
  </div>



</body>
</html>