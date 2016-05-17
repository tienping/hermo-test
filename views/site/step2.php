<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\Url;

$this->title = 'Step 2';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

	<div class="">
		<p class="lead">Simple Shopping App - Step 2</p>
	</div>

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
								echo $model->brand; 
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
					shippingSelect.selectedIndex = 0; // re-initiate to handle browser back button
					var shippingFeeAmount = document.querySelector(".checkout-shipping-fee-amount");
					var totalPriceAmount = document.querySelector(".checkout-total-price-amount");
					
					if (shippingSelect && shippingFeeAmount) {
						var changingShippingArea = function() {
							var shippingDestOpt = shippingSelect.options[shippingSelect.selectedIndex];
							if (shippingDestOpt && shippingDestOpt.value) {
								var shippingDestValue = shippingDestOpt.value;
								var quantity = <?php echo $quantity ?>;
								var totalPriceBeforeShipmentFee = <?php echo number_format((float)($model->selling_price * $quantity), 2, '.', '') ?>;
								var shipmentFee = "";
								switch(shippingDestOpt.value) {
									case "Country":
										shippingFeeAmount.innerHTML = "(Pending ship area)";
										alert("Please choose a destination.");
										break;
									case "Malaysia":
										shipmentFee = (quantity >= 2 || totalPriceBeforeShipmentFee >= 150) ? 0 : 10;
										break;
									case "Singapore":
										shipmentFee = (totalPriceBeforeShipmentFee >= 300) ? 0 : 20;
										break;
									case "Brunei":
										shipmentFee = (totalPriceBeforeShipmentFee >= 300) ? 0 : 25;
										break;
									default:
										shippingFeeAmount.innerHTML = "(Pending ship area)";
										alert("Only support delivery to Malaysia, Singapore and Brunei at the momemt.");
										break;
								}
								
								var totalPrice = "";
								if (shipmentFee) {
									shippingFeeAmount.innerHTML = "<?php echo $model->symbol ?> " + shipmentFee.toFixed(2);
									totalPrice = eval(totalPriceBeforeShipmentFee + shipmentFee).toFixed(2);
								} else if (shipmentFee === 0) {
									shippingFeeAmount.innerHTML = "Free Shipping";
									totalPrice = totalPriceBeforeShipmentFee;
								}
								
								if (totalPriceAmount) {
									totalPriceAmount.innerHTML = "<?php echo $model->symbol ?> " + eval(totalPrice || totalPriceBeforeShipmentFee).toFixed(2);
								} else {
									console.warn("shippingFeeAmount field not found");
								}
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
					
					if (checkoutPurchaseDiv) {
						if (!shippingFeeAmount) {
							console.warn("shippingFeeAmount field not found");
						} else if (!promocodeString) {
							console.warn("promotioncodeString field not found");
						} else {
							var purchasing = function() {
								var purchaseBtn = this;
								
								var shippingSelect = document.querySelector(".shipment-destination-select");
								var shippingDestOpt = shippingSelect.options[shippingSelect.selectedIndex];
								var shippingDestOptValue = shippingDestOpt.value;
								
								if (shippingFeeAmount.innerHTML == "(Pending ship area)") {
									alert("Please select ship to area");
								} else {
									if (shippingDestOptValue == "Country") {
										alert("Invalid shipping area, please re-enter.");
									} else {
										var nextStepUrl = "";
										if (promocodeString && promocodeString.value) {
											// TODO: do promocode validation in backend so that user cant see the promocode available?
											var promocodeStringValue = promocodeString.value;
											var totalPrice = <?php echo number_format((float)($model->selling_price * $quantity), 2, '.', '') ?>;
											var errorPromoCode = "";
											
											if (promocodeStringValue == "OFF5PC" && <?php echo $quantity; ?> < 2) {
												errorPromoCode = "OFF5PC only applicable with minimun purchase of  2 quantities of the product";
											} else if (promocodeStringValue == "GIVEME15" && totalPrice < 100.00) {
												errorPromoCode = "GIVEME15 only applicable with minimun purchase of  2 quantities of the product";
											} else if (promocodeStringValue == "OFF5PC" || promocodeStringValue == "GIVEME15") {
												nextStepUrl = "?r=site/step3&id=" + <?php echo $id ?> 
												+ "&quantity=" + <?php echo $quantity ?> 
												+ "&shippingArea=" + shippingDestOptValue
												+ "&promoCode=" + promocodeStringValue;
											} else {
												errorPromoCode = "Invalid promo code";
											}
											
											if (errorPromoCode) {
												alert(errorPromoCode);
												promocodeString.select();
											}
										} else {
											nextStepUrl = "?r=site/step3&id=" + <?php echo $id ?> 
												+ "&quantity=" + <?php echo $quantity ?> 
												+ "&shippingArea=" + shippingDestOptValue;
										}
										
										if (nextStepUrl) {
											window.location.search = nextStepUrl;
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
</div>