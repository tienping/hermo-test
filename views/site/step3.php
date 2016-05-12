<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\Url;

$this->title = 'Step 3';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

	<div class="">
		<p class="lead">Simple Shopping App - Step 3</p>
	</div>
	<!--
	<div class="body-content">
		<div class="row checkout-listing">
			<?php foreach ($dataProvider->models as $model): ?>
				<div class="checkout-item-div">
					<div class="checkout-item">
						<div class="checkout-img-div">
							<?php echo "<img class='checkout-img' src='".$model->images."'/>"; ?>
						</div>
						<div class="checkout-product-details-div">
							<h4 class="checkout-brand"><?php 
								$brand = json_decode($model->brand);
								echo $brand->name; 
							?></h4>
							<div class="checkout-name"><?php echo $model->name; ?></div>
							<div class="checkout-selling-price">
								<?php echo $model->symbol.' '.number_format((float)$model->selling_price, 2, ".", "")." X ".$quantity; ?>
							</div>
							<div class="checkout-retail-price"><?php echo $model->symbol.' '.number_format((float)$model->retail_price, 2, ".", ""); ?></div>
							<div class="checkout-shipping-fee-div">
								<span class="checkout-shipping-fee-label">
									Shipping Fee:
								</span>
								<span class="checkout-shipping-fee-amount pending">(Pending ship area)</span>
							</div>
							
							<hr class="black-line">
							
							<div class="checkout-total-price-div">
								<span class="checkout-total-price-label">
									Total Price:
								</span>
								<span class="checkout-total-price-amount">
									<?php 
										echo $model->symbol.' '.number_format((float)($model->selling_price * $quantity), 2, '.', '');
									?>
								</span>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			
			<div class="checkout-details-div">
				<div class="shipment-details-div">
					<span class="shipment-label">
						Ship to area:
					</span>
					<span class="shipment-destination">
						<select class="shipment-destination-select">
							<options>
								<option>Country</option>
								<option>Malaysia</option>
								<option>Singapore</option>
								<option>Brunei</option>
								<option>Others</option>
							</options>
						</select>
					</span>
				</div>
				<script>
					var shippingSelect = document.querySelector(".shipment-destination-select");
					var shippingFeeAmount = document.querySelector(".checkout-shipping-fee-amount");
					
					if (shippingSelect && shippingFeeAmount) {
						var changingShippingArea = function() {
							var shippingDestOpt = shippingSelect.options[shippingSelect.selectedIndex];
							if (shippingDestOpt && shippingDestOpt.value) {
								var shippingDestValue = shippingDestOpt.value;
								var quantity = <?php echo $quantity ?>;
								var totalPrice = <?php echo number_format((float)($model->selling_price * $quantity), 2, '.', '') ?>;
								
								switch(shippingDestOpt.value) {
									case "Country":
										shippingFeeAmount.innerHTML = "(Pending ship area)";
										alert("Please choose a destination.");
										break;
									case "Malaysia":
										shippingFeeAmount.innerHTML = (quantity >= 2 || totalPrice >= 150) ? "FREE" : "RM 10";
										break;
									case "Singapore":
										shippingFeeAmount.innerHTML = (totalPrice >= 300) ? "FREE" : "RM 20";
										break;
									case "Brunei":
										shippingFeeAmount.innerHTML = (totalPrice >= 300) ? "FREE" : "RM 25";
										break;
									default:
										shippingFeeAmount.innerHTML = "(Pending ship area)";
										alert("Only support delivery to Malaysia, Singapore and Brunei at the momemt.");
										break;
								}
								
								// TODO: add handling to total price, tired now.. continue next time
							}
						};
						
						shippingSelect.onchange = changingShippingArea;
					} else {
						console.warn("shippingSelect not found...");
					}
				</script>
				<div class="promocode-details-div">
					<span class="promocode-label">
						Promotion code:
					</span>
					<span class="promocode-string">
						<input type="text">
					</span>
				</div>
				<hr class="black-line">
				<div class="checkout-action">
					<div class="checkout-purchase" id="<?php echo $model->id ?>">
						<a class="btn btn-default">
							Confirm Checkout
						</a>
					</div>
				</div>
				<script>
					var validPromoCode = false;
					var checkoutPurchaseDiv = document.querySelector(".checkout-purchase");
					var shippingFeeAmount = document.querySelector(".checkout-shipping-fee-amount");
					var promocodeString = document.querySelector(".promocode-string input");
					var shippingSelect = document.querySelector(".shipment-destination-select");
					var shippingDestOpt = shippingSelect.options[shippingSelect.selectedIndex];
					
					if (checkoutPurchaseDiv) {
						if (!shippingFeeAmount) {
							console.warn("shippingFeeAmount field not found");
						} else if (!promocodeString) {
							console.warn("promotioncodeString field not found");
						} else {
							var purchasing = function() {
								var purchaseBtn = this;
								
								// window.location.search = "?r=site/step3&id=" + productId + "&quantity=" + quantitySelected;
								if (shippingFeeAmount.innerHTML == "(Pending ship area)") {
									alert("Please select ship to area");
								} else {
									if (promocodeString && promocodeString.value) {
										// TODO: do promocode validation in backend so that user cant see the promocode available?
										var promocodeStringValue = promocodeString.value;
										var totalPrice = <?php echo number_format((float)($model->selling_price * $quantity), 2, '.', '') ?>;
										var errorPromoCode = "";
										
										if (promocodeStringValue == "OFF5PC" && <?php echo $quantity; ?> < 2) {
											errorPromoCode = "OFF5PC only applicable with minimun purchase of  2 quantities of the product";
										} else if (promocodeStringValue == "GIVEME15" && totalPrice < 100.00) {
											errorPromoCode = "OFF5PC only applicable with minimun purchase of  2 quantities of the product";
										} else if (promocodeStringValue == "OFF5PC" || promocodeStringValue == "GIVEME15") {
											window.location.search = "?r=site/step3&id=" + <?php echo $id ?> 
											+ "&quantity=" + <?php echo $quantity ?> 
											+ "&shippingArea=" + shippingDestOpt
											+ "&promoCode=" + promocodeStringValue;
										}
										
										if (errorPromoCode) {
											alert(errorPromoCode);
										}
									}
								}
							};
							checkoutPurchaseDiv.addEventListener('click', purchasing, false);
						}
					} else {
						console.warn("checkoutPurchaseDiv not found...");
					}
				</script>
			</div>
		</div>
	</div>
	-->
</div>