<?php
require('database.php');
// $res variable can be used to detect and describe error

if(isset($_POST['submit']) || !empty($_POST['submit'])) {
	$ordertype = $_POST["ordertype"];
	$uid = $_SESSION['customer'];

	$res = mysqli_query($db, "SELECT id,cid,quantity FROM cart WHERE uid = 1");
	while($row = mysqli_fetch_assoc($res)) {
		// $cartid[] = $row['id'];
		$comid[] = $row['cid'];
		$quantity[] = $row['quantity'];
	}

	foreach ($cartid as $key => $c) {
		$res = mysqli_query($db, "INSERT into orders(uid,comid,quantity,ordertype,status) values($uid, $comid[$key], $quantity[$key]),'Pickup','Not Confirmed'");
	}

	$res = mysqli_query($db, "SELECT id,cid,quantity FROM cart WHERE uid = 1");
	$res = mysqli_query($db, "UPDATE cart SET quantity=$q where id={$ci[$key]} and uid = 1");
}

if(isset($_GET['remove']) || !empty($_GET['remove'])) {
	$res = mysqli_query($db, "DELETE FROM orders where id={$_GET['remove']} and uid = 1");
	echo "Affected rows: " . mysqli_affected_rows($db);
	if(mysqli_affected_rows($db)==1) {
		header('location:customer-orders.php?remstatus=success');
	}
	else {
		header('location:customer-orders.php?remstatus=failure');
	}
}

require('header.php');
?>

<!-- Title Page -->
<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/heading-pages-01.jpg);">
	<h2 class="l-text2 t-center">
		Orders
	</h2>
</section>

<!-- Cart -->
<section class="cart bgwhite p-t-70 p-b-100">
	<div class="container">
		<?php
		if(isset($_GET['status']) and !empty($_GET['status'])) {
			$s = $_GET['status'];
			if($s != "success" and $s != "failure")
				$s = "warning";
		}
		if(isset($s))
		{
			?>
			<div class="alert <?php echo $s; ?>">
				<span class="closebtn">&times;</span> 
				<strong><?php echo ucfirst($s); ?>!</strong>
				<?php
				switch($s) {
					case "success"	: echo "Order placed successfully !!";
					break;
					case "failure" 	: echo "Failed to place order !!";
					break;
					default 		: echo "Baka, Order status not to be played with !!";
				}
				?>
			</div>
			<?php
		}
		mysqli_query($db,"SET @count:=0");
		$res = mysqli_query($db, "SELECT cr.id as cartid,(@count:=@count+1) AS sn, uid, c.name as commodity, avail, v.name as vendor, cus.lat as lat, cus.lon as lon, quantity, price,(quantity*price) as total FROM customers as cus, cart as cr,commodities as c,vendors as v WHERE uid=1 and cr.cid=c.id and c.vid=v.id and cus.id=uid") or die (mysqli_error($db));

		if (mysqli_num_rows($res) <= 0) {
			?>
			<h2 class="center">Sack is empty ! <br/><a href="index.php" alt="AgMarket Home Page" style="text-decoration: none;">Browse and Add commodities in the sack !!</a></h2>
			<?php
		}
		else {
			?>
			<div class="row">
				<form method="POST" action="" class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<!-- Cart item -->
					<div class="container-table-cart pos-relative">
						<div class="wrap-table-shopping-cart bgwhite">
							<table class="table-shopping-cart" style="overflow: hidden;">
								<tr class="table-head">
									<th class="column-1 notranslate">S.N.</th>
									<th class="column-2">Commodity Name</th>
									<th class="column-3">Vendor Name</th>
									<th class="column-4">Rate (₹ per KG/Entity)</th>
									<th class="column-5">Quantity (KG/Entity)</th>
									<th class="column-6">Price</th>
									<th class="column-7"></th>
								</tr>
								<?php
								$gtotal = 0;
								$lat = 0;
								$lon = 0;
								while($row = mysqli_fetch_assoc($res)) {
									$total = 0;
									$i = $row["sn"];
									$j = $i - 1;
									?>
									<tr class="table-row">
										<td class="column-1"><?php echo $i; ?></td>
										<td class="column-2"><?php // Pachi Photo Rakhne eta ?><?php echo $row["commodity"]; ?></td>
										<td class="column-3 notranslate"><?php echo $row["vendor"]; ?></td>
										<td class="column-4 notranslate">
											<strong class="price" id="<?php echo $j.'-price'; ?>">
												<?php echo $row["price"]; ?>
											</strong>
										</td>
										<td class="column-5 notranslate">
											<input type="text" name="cartid[]" value="<?php echo $row["cartid"]; ?>" hidden="hidden" />
											<i class="minus fa fa-minus-square" style="font-size:36px;"></i>
											<input type="number" name="quantity[]" class="quantity size8 m-text18 t-center num-product" min="1" max="<?php echo $row["avail"]; ?>" value="<?php echo $row["quantity"]; ?>" />
											<i class="plus fa fa-plus-square" style="font-size:36px;"></i>
										</td>
										<td class="column-6 notranslate">
											<strong class="total" id="<?php echo $j.'-total'; ?>">
												<?php
												$total = $row["total"];
												$gtotal += $total;
												echo $total;
												?>
											</strong>
										</td>
										<td class="column-7">
											<a href="cart.php?remove=<?php echo $row['cartid']; ?>">
												<i class="fa fa-trash-o" style="font-size:36px"></i>
											</a>
										</td>
									</tr>
									<?php
									$lat = $row["lat"];
									$lon = $row["lon"];
								}
								?>
							</table>
						</div>
						<div class="row" style="margin:0 auto;">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<h4 class="float-right">
									Sub-total : ₹ <span class="notranslate" id="totalPrice"><?php echo $gtotal; ?></span>
								</h4>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<!-- Button -->
								<input type="submit" name="submit" class="float-left flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" value="Update Cart" />
							</div>
						</div>
					</div>
				</form>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<!-- Total -->
					<form method="POST" action="checkout.php">
						<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-r-0 m-l-auto p-lr-15-sm">
							<h5 class="m-text20 p-b-24">
								Cart Totals
							</h5>

							<!--  -->
							<div class="flex-w flex-sb-m p-b-12">
								<span class="s-text18 w-size19 w-full-sm">
									Total:
								</span>

								<span class="m-text21 w-size20 w-full-sm">
									₹ <?php echo $gtotal; ?>
								</span>
								<p class="s-text8 p-b-10">
									Exclusive of the delivery cost, if choosen for delivery.
								</p>
							</div>
							<div class="rs2-select2 rs3-select2 rs4-select2 bo4 of-hidden w-size21 m-b-12">
								<select class="selection-2" name="country" required="required">
									<option selected="true" disabled="disabled">Order Type</option>
									<option>Delivery</option>
									<option>Pick-up</option>
								</select>
							</div>
							<!--  -->
							<div class="bo10 flex-w flex-sb p-t-15 p-b-20">
								<span class="s-text18 w-full-sm">
									Your Location:
								</span>
								<div class="flex-w flex-sb p-t-15 p-b-20">
									<div id="map"> Map with your location should display here </div>
								</div>
							</div>

							<!-- Total  -->
							<div class="flex-w flex-sb-m p-t-26 p-b-30">
								<span class="m-text22 w-size19 w-full-sm">
									Total:
								</span>
								<span class="m-text21 w-size20 w-full-sm">
									₹ <?php echo $gtotal; ?>
								</span>
							</div>
							<div class="size15 trans-0-4">
								<!-- Button -->
								<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
									Proceed to Checkout
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>		
		</div>
	</section>

	<?php require('footer.php'); ?>
	<!-- Container Selection -->
	<div id="dropDownSelect1"></div>
	<div id="dropDownSelect2"></div>

	<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/bootstrap/js/popper.js"></script>
	<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/select2/select2.min.js"></script>
	<script type="text/javascript">
		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect2')
		});
	</script>
	<!--=============================================================================================== -->
	<script>
// we used jQuery 'keyup' to trigger the computation as the user type
$('.quantity').keyup(function () {
setTimeout(function() {   //calls click event after a certain time
	cartUpdate();
}, 1000);
});
$('.minus').click(function(){
	var q = parseInt($(this).next().val())-1;
	$(this).next().val(q);
	cartUpdate(-1,this);
});
$('.plus').click(function(){
	var q = parseInt($(this).prev().val())+1;
	$(this).prev().val(q);
	cartUpdate(1,this);
});

var cartUpdate = function(pos,x) {
/*
	var q = ''; 
	var max = '';
	if(pos == -1) {
		q = parseInt($(x).next().val());
		if(q < 1) {
			$(x).next().val('1');
			agalert("AgMarket - Min Alert","Minumum quantity for commodity provided by selected vendor is 1","red");
		}
	}
	if(pos == 1){
		q = parseInt($(x).prev().val());
		max = parseInt($(x).prev().attr("max"));
		if(q > max) {
			$(x).prev().val(max);
			agalert("AgMarket - Max Alert","Maximum quantity for commodity provided by selected vendor is " + max,"red");
		}
	}
	*/

// initialize the sum (total price) to zero
var total = 0;
var sum = 0;
var max = 0;
// we use jQuery each() to loop through all the textbox with 'price' class
// and compute the sum for each loop
$('.quantity').each(function(index) {
	max = parseInt($(this).attr("max"));
	quantity=$(this).val();

	if(quantity>max) {
		quantity = max;
		$(this).val(quantity);
		agalert("AgMarket - Max Alert","Maximum quantity for the commodity provided by selected vendor is " + max,"red");
	}
	if(quantity<1) {
		quantity = 1;
		$(this).val(quantity);
		agalert("AgMarket - Min Alert","Minumum quantity for the commodity provided by selected vendor is 1","red");
	}

	sum = Number($("#"+index+"-price").html())*Number(quantity);
	$("#"+index+"-total").html(sum.toString());
}); 

$('.total').each(function(index) {
	total += Number($(this).html());
// set the computed value to 'totalPrice' textbox
$('#totalPrice').html(total.toString());
}, 100);
}
</script> 
<!--===============================================================================================-->
<script src="js/main.js"></script>
<!-- Loading Google API -->
<script type="text/javascript">
	var map;
	function initMap() {
		var latlng = new google.maps.LatLng(<?php echo $lat . "," . $lon; ?>);
		map = new google.maps.Map(document.getElementById('map'), {
			center: latlng,
			zoom: 10,
			clickableIcons: false,
			disableDefaultUI: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var marker = new google.maps.Marker({
			position: latlng,
			map: map,
			title: 'Set lat/lon values for this property',
			draggable: false
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmt9muKRq8oFoSiZQw-B0hcG-aBrvUNPo&callback=initMap"
async defer></script>
<?php
}
?>
</body>
</html>