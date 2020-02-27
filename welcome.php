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

<style>
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}


  .wrapper,.wrapper2 {
    display: grid;
    grid-template-rows: 100px 100px;
    grid-template-columns: 100px 100px 100px;
    grid-gap: 10px;
    background-color: inherit;
    color: #444;
    grid-template-columns: auto auto auto auto ;
    padding: 25px 20px 20px 20px;
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
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body" id="modelContents">
                    <div  id="wrapper2"></div>
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
                  <tbody>
                    <tr>
                      <td id="ItemId">123</td>
                      <td id ="itemName"">john@example. com</td>
                      <td id="unitPrice">1234</td>
                      <td id="itemQuantity">John</td>
                      <td id="subTotal">Doe</td>
                      <td><img src="remove.png"/></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                      <td>123</td>
                      <td>john@example. com</td>
                      <td>1234</td>
                      <td>John</td>
                      <td>Doe</td>
                      <td><img src="remove.png"/></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                      <td>123</td>
                      <td>john@example. com</td>
                      <td>1234</td>
                      <td>John</td>
                      <td>Doe</td>
                      <td><img src="remove.png"/></td>
                    </tr>
                </tbody>
                
                
                
                
                <thead class="thead-light">
                  <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th>20</th>
                    <th>5000</th>
                    <th></th>
                  </tr>
                </thead>
                </table>
                </div>
            <div class="cart-total">
              <b>Total Charges:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> $<span>0</span>
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

			var price 	 = $('#each-'+thisID).children(".shopp-price").find('em').html();
			var quantity = $('#each-'+thisID).children(".shopp-quantity").html();
			quantity = parseInt(quantity)+parseInt(1);
			
			var total = parseInt(itemprice)*parseInt(quantity);
			
			$('#each-'+thisID).children(".shopp-price").find('em').html(total);
			$('#each-'+thisID).children(".shopp-quantity").html(quantity);
			
			var prev_charges = $('.cart-total span').html();
			prev_charges = parseInt(prev_charges)-parseInt(price);
			
			prev_charges = parseInt(prev_charges)+parseInt(total);
			$('.cart-total span').html(prev_charges);
			
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
			cartArray.push({id: thisID, quantity: 1});

      
			var prev_charges = $('.cart-total span').html();
			prev_charges = parseInt(prev_charges)+parseInt(itemprice);
			
			$('.cart-total span').html(prev_charges);
			$('#total-hidden-charges').val(prev_charges);
			
      $('#left_bar .cart-info').append('<div class="shopp" id="each-'+thisID+'"><div class="label">'+itemname+'</div><div class="shopp-price"> $<em>'+itemprice+'</em></div><span class="shopp-quantity"><div class="def-number-input number-input safari_only"><button onclick="this.parentNode.querySelector("input[type=number]").stepDown()" class="minus"></button><input class="quantity" min="0" name="quantity" value="1" type="number"><button onclick="this.parentNode.querySelector("input[type=number]").stepUp()" class="plus"></button></div></span><img src="remove.png" class="remove" /><br class="all" /></div>');
			
			$('#cart').css({'-webkit-transform' : 'rotate(20deg)','-moz-transform' : 'rotate(20deg)' });

      console.log("Item doesn't present");
      console.log(Arrays);
      console.log(cartArray);
      bindButtonClick(); 
		}
		
	});	
  $('body').off().on('click','.remove',function(){
    console.log("Item removes");
		var deduct = $(this).parent().children(".shopp-price").find('em').html();
		var prev_charges = $('.cart-total span').html();
		
		var thisID = $(this).parent().attr('id').replace('each-','');
		
		var pos = getpos(Arrays,thisID);
    Arrays.splice(pos,1,"0");
    
    cartArray.splice(cartArray.findIndex(item => item.id === thisID), 1);
		
		prev_charges = parseInt(prev_charges)-parseInt(deduct);
		$('.cart-total span').html(prev_charges);
		$('#total-hidden-charges').val(prev_charges);
		$(this).parent().remove();
		
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
