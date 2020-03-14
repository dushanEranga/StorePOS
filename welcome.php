<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

<<<<<<< Updated upstream
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storePos";
=======
require_once 'database/dbConnect.php';

$sql = "SELECT Status FROM  day_end ORDER BY DayId DESC LIMIT 1";
$result = $conn->query($sql);
>>>>>>> Stashed changes

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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<<<<<<< Updated upstream
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/livequery/1.1.1/jquery.livequery.js"></script>
  <link href="css.css" rel="stylesheet" />
=======
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link href="./styles/css.css" rel="stylesheet" />
>>>>>>> Stashed changes
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
    padding: 25px 50px 75px 75px;
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

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">StorePOS</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Sales</a></li>
      <li><a href="#">Day End/Open</a></li>
      <li><a href="#">Purchase</a></li>
      <li><a href="#">Add Items</a></li>
      <li><a href="#">Add Category</a></li>
      <li><a href="#">Statistics</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Statistics <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Current Sales</a></li>
          <li><a href="#">Daily Sales</a></li>
          <li><a href="#">Monthly Sales</a></li>
          <li><a href="#">Sales By Item Wise</a></li>
          <li><a href="#">Sales By category Wise</a></li>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container-fluid">
    <div class="row">
      <div class="col-sm-9">
        
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

      <div class="col-sm-3" style="background-color:pink;">
        <div id="left_bar"> 
          <form action="#" id="cart_form" name="cart_form">
            <div class="cart-info"></div>
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

<script>

<<<<<<< Updated upstream
function showItems(str) {
=======
var globalGetJSONPath='@Url.ACtion("getItems.php","database)';
var Arrays=new Array();
var cartArray=new Array();
var newUnit;
    var newQuantity ;
    var newTot;

    function showItems(str) {
>>>>>>> Stashed changes
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
    xhttp.open("GET", "database/getItemsDb.php?q="+str, true);
    xhttp.send();
    bindButtonClick();  
    //clearconsole();
  
  }



<<<<<<< Updated upstream
	var Arrays=new Array();
=======
      $.ajax({
          url:"database/placeOrderDb.php",
          type:"post",
          data: 'order='+JSON.stringify(cartArray),
          success:function(data){
              console.log(data);    //prints "string"
              document.getElementById("orderModelBody").innerHTML = data;

              if (data.indexOf("Order ID is") > -1){
                document.getElementById("orderModelFooter").innerHTML = "<button type=\"button\" class=\"btn btn-success\" onclick=\"deleteCart();\">Close</button>";
              }
              
          },
          error: function() {
            console.log("failed");    //prints "string"
          }
      });
    }
    else {
      x.style.display = "block";
      $("#submitButton").click(function(){
        document.getElementById("toast-header").innerHTML = dayStatus==1?'Please open a Day':'Cart is Empty';
        document.getElementById("toast-body").innerHTML = dayStatus==1?'Please open a Day':'Cart is Empty';
        $('.toast').toast('show');
      }); 
    }
  }
>>>>>>> Stashed changes

	function bindButtonClick(){

    $('div #modelContents').off().on('click','.box',function(){
		
		var thisID = $(this).attr('id');
		var itemname  = $(this).find('div .name').html();
		var itemprice =$(this).find('div .price').html();
    
    console.log($(this).attr('id'));
    console.log($(this).find('div .name').html());
    console.log($(this).find('div .price').html());
    console.log(Arrays);

		if(include(Arrays,thisID))
		{
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
		}
		else
		{
			Arrays.push(thisID);
			
			var prev_charges = $('.cart-total span').html();
			prev_charges = parseInt(prev_charges)+parseInt(itemprice);
			
			$('.cart-total span').html(prev_charges);
			$('#total-hidden-charges').val(prev_charges);
<<<<<<< Updated upstream
			
			$('#left_bar .cart-info').append('<div class="shopp" id="each-'+thisID+'"><div class="label">'+itemname+'</div><div class="shopp-price"> $<em>'+itemprice+'</em></div><span class="shopp-quantity">1</span><img src="remove.png" class="remove" /><br class="all" /></div>');
			
			$('#cart').css({'-webkit-transform' : 'rotate(20deg)','-moz-transform' : 'rotate(20deg)' });
=======

      cartArray.push({id: thisID, quantity: 1, unitPrice: parseInt(itemprice),subTotal: parseInt(itemprice)});
      

			$('#left_bar .tableBody').append('<tr id = "each-'+thisID+'"><td class="itemID">'+thisID+'</td><td class ="itemName">'+itemname+'</td><td class="unitPrice">'+itemprice+'</td><td class="itemQuantity">1</td><td class="subTotal">'+itemprice+'</td><td><img src="images/remove.png" class ="remove"/></td></tr>');

      console.log("Item doesn't present");
>>>>>>> Stashed changes
      console.log(Arrays);
		}
		
	});	
<<<<<<< Updated upstream
	
	$('.remove').livequery('click', function() {
		
		var deduct = $(this).parent().children(".shopp-price").find('em').html();
		var prev_charges = $('.cart-total span').html();
		
		var thisID = $(this).parent().attr('id').replace('each-','');
=======

  $('#left_bar').off().on('click','.remove',function(){
    console.log("Item removes");

		var deductTotal = $(this).closest("tr").find(".subTotal").html();
    var deductQuantity = $(this).closest("tr").find(".itemQuantity").html();
    var thisID = $(this).closest("tr").attr('id').replace('each-','');
		var prev_charges = $('.cart-total').children(".totalAmount").html();
    var totalQuantity = $('.cart-total').children(".totalQuantity").html();
>>>>>>> Stashed changes
		
		var pos = getpos(Arrays,thisID);
		Arrays.splice(pos,1,"0");
		
		prev_charges = parseInt(prev_charges)-parseInt(deduct);
		$('.cart-total span').html(prev_charges);
		$('#total-hidden-charges').val(prev_charges);
		$(this).parent().remove();
		
<<<<<<< Updated upstream
	});	
	
	$('#Submit').livequery('click', function() {
		
		var totalCharge = $('#total-hidden-charges').val();
		
		$('#left_bar').html('Total Charges: $'+totalCharge);
		
		return false;
		
	});	
  }
=======
      console.log(Arrays);
      console.log(cartArray);
  });	

  $('body').off().on('click','.itemName',function(){
    var unitPrice = $(this).closest("tr").find(".unitPrice").html();
    var subTotal = $(this).closest("tr").find(".subTotal").html();
    var subQuantity = $(this).closest("tr").find(".itemQuantity").html();
    var thisID = $(this).closest("tr").attr('id').replace('each-','');

    document.getElementById("cartModelTitle").innerHTML =subQuantity;
    var cartUnitPrice = " <table class=\"table  table-hover \"><tr><td>Unit Price : <kbd>Rs:" + unitPrice + ".00</kbd> </td>";
    var cartUnitPriceDiscount = " <td>Discounted Unit Price :<input type=\"number\" value=" + unitPrice + " id=\"cartUnitPriceDiscount\" name=\"cartUnitPriceDiscount\" min=\"1\" onkeypress=\"return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))\"> </td></tr>"; 
    var cartQuantity = " <tr><td colspan=\"2\">Quantity :<input type=\"number\" value= " + subQuantity + " id=\"cartQuantity\" name=\"cartQuantity\" min=\"1\" onkeypress=\"return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))\">   </td></tr>";
    var cartSubTotal = " <tr><td>Sub total : <kbd>Rs:" + subTotal + ".00</kbd></td>";
    var cartSubTotalDiscount = "<td> Discounted sub total :<input type=\"number\" value= " + subTotal + " id=\"cartSubTotalDiscount\" name=\"cartSubTotalDiscount\" min=\"1\" onkeypress=\"return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))\">  </td></tr> </table>";
    
    document.getElementById("cartModelBody").innerHTML = cartUnitPrice + cartUnitPriceDiscount + cartQuantity + cartSubTotal + cartSubTotalDiscount;
    document.getElementById("cartModelFooter").innerHTML = "<button type=\"button\" class=\"btn btn-success\" id=\"cartModelButton\" onclick=\"updateCart( " + thisID + " );\" >Update</button>";

    $('#cartModel').modal('show');
  });	


  $('#cartModelBody').on('keyup','#cartUnitPriceDiscount,#cartQuantity',function(){
    newUnit = parseInt($("#cartUnitPriceDiscount").val());
    newQuantity = parseInt($("#cartQuantity").val());
    newTot = newUnit * newQuantity;
    $('#cartSubTotalDiscount').val(newTot);
  });
  
}


  function updateCart(thisId){

  cartArray.find(v => v.id == thisId).unitPrice = newUnit;
  cartArray.find(v => v.id == thisId).quantity = newQuantity;
  cartArray.find(v => v.id == thisId).subTotal = newTot;

  console.log(cartArray);

  

 var prev_charges = 0;
 var totalQuantity = 0;
  cartArray.forEach(function (order) {
    prev_charges += order.subTotal;
    totalQuantity += order.quantity
});

  $('.cart-total').children(".totalAmount").html(prev_charges);
  $('.cart-total').children(".totalQuantity").html(totalQuantity);

  $('#each-'+thisId).closest("tr").find(".unitPrice").html(newUnit);
  $('#each-'+thisId).closest("tr").find(".subTotal").html(newTot);
  $('#each-'+thisId).closest("tr").find(".itemQuantity").html(newQuantity);

  /*var prev_charges = $('.cart-total').children(".totalAmount").html();
	prev_charges = parseInt(prev_charges)-parseInt(price);
	prev_charges = parseInt(prev_charges)+parseInt(total);
	$('.cart-total').children(".totalAmount").html(prev_charges);*/

  $('#cartModel').modal('hide');
  
}
>>>>>>> Stashed changes

function include(arr, obj) {
  for(var i=0; i<arr.length; i++) {
    if (arr[i] == obj) return true;
  }
}
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
