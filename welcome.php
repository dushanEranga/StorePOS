<?php

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
              <div class="modal-dialog modal-lg modal-dialog-centered" id ="modelDialog1">
                <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Item List</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                    <div class="modal-body" id="modelContent1">
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
                    <tbody class = "tableBody" class = "tableBody"> </tbody>   
                                
               </table>
               <div class="toast mt-3">
                      <div class="toast-header">
                        Cart is Empty
                      </div>
                      <div class="toast-body">
                        Please add some items.
                      </div>
                    </div> 
            </div>
            <div class="cart-total">
                <b>Total Quantity:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> <span class ="totalQuantity">0</span></br>
                <b>Total Charges:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> Rs: <span class ="totalAmount">0</span>
                <input type="hidden" name="total-hidden-charges" id="total-hidden-charges" value="0" />
                
                <button type="submit" onclick ="saveOrder();" class="btn btn-primary"  id="submitButton">CheckOut</button>
            </div>
              
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Order saving model -->
<div class="modal fade" id="orderModel">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Placing the order...</h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id ="orderModelBody">
        <div class="spinner-border text-muted"></div>  Please wait Order is saving...
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer" id ="orderModelFooter">
          
        </div>
        
      </div>
    </div>
  </div>

  

<script>

var Arrays=new Array();
var cartArray=new Array();

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

  function saveOrder() {

    if(Array.isArray(cartArray) && cartArray.length){
      $('#orderModel').modal({backdrop: 'static', keyboard: false});


      //add totalAmount and TotalQuantity to save in db
      var totalQuantity = $('.cart-total').children(".totalQuantity").html();
      var prev_charges = $('.cart-total').children(".totalAmount").html();
      cartArray.push({totalQuantity: totalQuantity, totalAmount: prev_charges});
      console.log(cartArray);

      myJSON = JSON.stringify(cartArray);
      console.log(myJSON);

      $.ajax({
          url:"placeOrder.php",
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
      $("#submitButton").click(function(){
        $('.toast').toast('show');
      }); 
    }
  }

	function bindButtonClick(){
    

    $('div #modelContent1').off().on('click','.box',function(){
		
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
			
      cartArray.find(v => v.id == thisID).subTotal = total;


			$('#total-hidden-charges').val(prev_charges);

      console.log("Item presents");
      console.log(Arrays);
      console.log(cartArray);
      bindButtonClick(); 
		}
		else
		{
			Arrays.push(thisID);
			
      var totalQuantity = $('.cart-total').children(".totalQuantity").html();
      totalQuantity = parseInt(totalQuantity)+1;
      $('.cart-total').children(".totalQuantity").html(totalQuantity);

      //cart total
			var prev_charges = $('.cart-total').children(".totalAmount").html();
			prev_charges = parseInt(prev_charges)+parseInt(itemprice);
			$('.cart-total').children(".totalAmount").html(prev_charges);
			$('#total-hidden-charges').val(prev_charges);

      cartArray.push({id: thisID, quantity: 1, subTotal: parseInt(itemprice)});

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

function deleteCart(){
  console.log(Arrays);
  cartArray = [];
  Arrays = [];
  console.log(cartArray);
  console.log(Arrays);
  $('#orderModel').modal('hide');
  $('#left_bar .tableBody').html("");
  $('.cart-total').children(".totalAmount").html("0");
  $('.cart-total').children(".totalQuantity").html("0");
  return;
}


</script>

</body>
</html>
