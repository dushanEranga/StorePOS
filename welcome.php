<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storePos";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

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

<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">StorePOS</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="nav-item"><a class="nav-link" href="#">Sales</a></li>
      <li class="nav-item"><a class="nav-link" class="nav-link" href="#">Day End/Open</a></li>
      <li class="nav-item"><a class="nav-link" class="nav-link" href="#">Purchase</a></li>
      <li class="nav-item"><a class="nav-link" class="nav-link" href="#">Add Items</a></li>
      <li class="nav-item"><a class="nav-link" class="nav-link" href="#">Add Category</a></li>
      <li class="nav-item"><a class="nav-link" class="nav-link" href="#">Statistics</a></li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          Statistics
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Current Sales</a>
          <a class="dropdown-item" href="#">Daily Sales</a>
          <a class="dropdown-item" href="#">Monthly Sales</a>
          <a class="dropdown-item" href="#">Sales By Item Wise</a>
          <a class="dropdown-item" href="#">Sales By category Wise</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    <li class="nav-item"><a class="nav-link" class="nav-link"  href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
    <li class="nav-item"><a class="nav-link" class="nav-link" href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
</nav>
  
<div class="container-fluid">
    <div class="row">
      <div class="col-sm-8">
        
        <div class="form-group">
          <label for="email">Item Search</label>
          <input type="text" class="form-control form-control-lg">
        </div>

        <div class="wrapper">
          <?php
              while($row = $result->fetch_assoc()){
                echo '<div class="box" onclick="showItems('.$row["CategoryCode"].')"'.'>'.$row["CategorySinhala"].'</div>';
              }
          ?>
        </div>

        <div id="divModel">
          <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Item List</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                    <div class="modal-body" id="modelContents">
                    <div id="wrapper2"></div>
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="deleteAll();" >Close</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>


      <div class="col-sm-4" >
        <div id="left_bar"> 
          <form action="#" id="cart_form" name="cart_form">
            <div class = "outer">
              <table class="table  table-hover ">
                <thead class="thead-dark">
                    <tr>
                      <th style = "width:10%">ID</th>
                      <th>Item</th>
                      <th>Unit Price</th>
                      <th>Quantity</th>
                      <th>Sub Total</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody class = "tableBody"></tbody>                
               </table>
            </div>
            <div class="cart-total">
                <b>Total Quantity:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> <span class ="totalQuantity">0</span></br>
                <b>Total Charges:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> Rs: <span class ="totalAmount">0</span>
                <input type="hidden" name="total-hidden-charges" id="total-hidden-charges" value="0" />
            </div>
              <button type="submit" id="Submit">CheckOut</button>
          </form>
        </div>
      </div>
      
    </div>
  </div>
</div>

<script>

function showItems(str) {
    var xhttp;  
    if (str == "") {
      document.getElementById("wrapper2").innerHTML = "";
      return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("wrapper2").innerHTML = this.responseText;
        console.log(this.responseText);
        $("#myModal").modal();
      }
    };
    xhttp.open("GET", "./getItems.php?q="+str, true);
    xhttp.send();
    bindButtonClick();  
    clearconsole();
  
  }



	var Arrays=new Array();
  var cartArray=new Array();
  

	function bindButtonClick(){

    $('div #modelContents').off().on('click','.box',function(){
		
		var thisID = $(this).attr('id');
		var itemname  = $(this).find('div .name').html();
		var itemprice =$(this).find('div .price').html();

		if( cartArray.find(x => x.id === thisID) )
		{
      var newQuantity = (cartArray.find(v => v.id == thisID).quantity)+1;
      cartArray.find(v => v.id == thisID).quantity = newQuantity;

			var price 	 = $('#each-'+thisID).children(".subTotal").html();
			var quantity = $('#each-'+thisID).children(".itemQuantity").html();

      var totalQuantity = $('.cart-total').children(".totalQuantity").html();
      totalQuantity = parseInt(totalQuantity)+1;
      $('.cart-total').children(".totalQuantity").html(totalQuantity);

			quantity = parseInt(quantity)+parseInt(1);
			
			var total = parseInt(itemprice)*parseInt(quantity);
			
			$('#each-'+thisID).children(".subTotal").html(total);
			$('#each-'+thisID).children(".itemQuantity").html(quantity);
			
      //cart total display
			var prev_charges = $('.cart-total').children(".totalAmount").html();
			prev_charges = parseInt(prev_charges)-parseInt(price);
			prev_charges = parseInt(prev_charges)+parseInt(total);
			$('.cart-total').children(".totalAmount").html(prev_charges);
			
			$('#total-hidden-charges').val(prev_charges);

      //Arrays.push(thisID);
      console.log("Item presents");
      console.log(Arrays);
      console.log(cartArray);
      bindButtonClick(); 
		}
		else
		{
			Arrays.push(thisID);
			cartArray.push({id: thisID, totalQuantity: 1});

      var totalQuantity = $('.cart-total').children(".totalQuantity").html();
      totalQuantity = parseInt(totalQuantity)+1;
      $('.cart-total').children(".totalQuantity").html(totalQuantity);

      //cart total
			var prev_charges = $('.cart-total').children(".totalAmount").html();
			prev_charges = parseInt(prev_charges)+parseInt(itemprice);
			$('.cart-total').children(".totalAmount").html(prev_charges);
			$('#total-hidden-charges').val(prev_charges);

			$('#left_bar .tableBody').append('<tr id = "each-'+thisID+'"><td class="itemID">'+thisID+'</td><td class ="itemName"">'+itemname+'</td><td class="unitPrice">'+itemprice+'</td><td class="itemQuantity">1</td><td class="subTotal">'+itemprice+'</td><td><img src="remove.png" class ="remove"/></td></tr>');

      console.log("Item doesn't present");
      console.log(Arrays);
      console.log(cartArray);
      bindButtonClick(); 
		}
		
	});	

  $('body').off().on('click','.remove',function(){
    console.log("Item removes");

		var deductTotal = $(this).closest("tr").find(".subTotal").html();
    var deductQuantity = $(this).closest("tr").find(".itemQuantity").html();
    var thisID = $(this).closest("tr").attr('id').replace('each-','');
		var prev_charges = $('.cart-total').children(".totalAmount").html();
    var totalQuantity = $('.cart-total').children(".totalQuantity").html();
		
		var pos = getpos(Arrays,thisID);
    Arrays.splice(pos,1,"0");
    cartArray.splice(cartArray.findIndex(item => item.id === thisID), 1);
		
		prev_charges = parseInt(prev_charges)-parseInt(deductTotal);
    $('.cart-total').children(".totalAmount").html(prev_charges);

    var totalQuantity = parseInt(totalQuantity)-parseInt(deductQuantity);
    $('.cart-total').children(".totalQuantity").html(totalQuantity);

		$('#total-hidden-charges').val(prev_charges);
		$(this).closest("tr").remove();
		
      console.log(Arrays);
      console.log(cartArray);
  });	
}
	
	$('#Submit').livequery('click', function() {
		
		var totalCharge = $('#total-hidden-charges').val();
		
		$('#left_bar').html('Total Charges: $'+totalCharge);
		
		return false;
		
	});	
  


function getpos(arr, obj) {
  for(var i=0; i<arr.length; i++) {
    if (arr[i] == obj) return i;
  }
}

function deleteAll(){
  document.getElementById("wrapper2").innerHTML = "";
      return;
}


</script>

</body>
</html>
