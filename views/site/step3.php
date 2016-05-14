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
	<div class="body-content">
		<div class="summary-order-num">
			<span class="summary-order-num-label">
				Order Number: 
			</span>
			<span class="summary-order-num-code">
				<?php echo "xxxxxxx" ?>
			</span>
		</div>
		<div class="row summary-listing">
			<?php foreach ($dataProvider->models as $model): ?>
				<div class="summary-item-div">
					<div class="summary-item">
						<div class="summary-img-div">
							<?php echo "<img class='summary-img' src='".$model->images."'/>"; ?>
						</div>
						<div class="summary-product-details-div">
							<h4 class="summary-product-brand"><?php 
								$brand = json_decode($model->brand);
								echo $brand->name; 
							?></h4>
							<div class="summary-product-name"><?php echo $model->name; ?></div>
						</div>
					</div>
				</div>
				<div class="summary-details-div">
					<div class="summary-unit-price">
						<div class="summary-details-label">
							Unit Price
						</div>
						<div class="summary-details-value">
							<?php echo $model->symbol.' '.number_format((float)$model->selling_price, 2, ".", "") ?>
						</div>
					</div>
					<div class="summary-quantity">
						<div class="summary-details-label">
							Quantity
						</div>
						<div class="summary-details-value">
							<?php echo $quantity; ?>
						</div>
					</div>
					
					<hr class="black-line">
					
					<div class="summary-total">
						<div class="summary-details-label">
							Total Price
						</div>
						<div class="summary-details-value">
							<?php
								$totalPrice = $model->selling_price * $quantity;
								echo $model->symbol.' '.number_format((float)$totalPrice, 2, ".", "");
							?>
						</div>
					</div>
					<div class="summary-promocode">
						<div class="summary-details-label">
							Promotion Code
						</div>
						<div class="summary-details-value">
							<?php 
								$displayCode = "(none)";
								$discount = "0";
								if ($promoCode) {
									if ($promoCode == "OFF5PC" && $quantity >= 2) {
										$displayCode = $promoCode;
										$discount = $totalPrice * 0.05;
									} else if ($promoCode == "GIVEME15" && $totalPrice < 100.00) {
										$displayCode = $promoCode;
										$discount = 15; 
									}
								}
								
								echo $displayCode; 
							?>
						</div>
					</div>
					<div class="summary-discount">
						<div class="summary-details-label">
							Discount
						</div>
						<div class="summary-details-value">
							<?php
								$discountDisplay = "(none)";
								if ($discount) {
									$discountDisplay = "- ".$model->symbol.' '.number_format((float)$discount, 2, ".", "");
								}
								echo $discountDisplay;
							?>
						</div>
					</div>
					<div class="summary-shipment">
						<div class="summary-details-label">
							Delivery To
						</div>
						<div class="summary-details-value">
							<?php echo $shippingArea; ?>
						</div>
					</div>
					<div class="summary-shipping-fee">
						<div class="summary-details-label">
							Shipping Fee
						</div>
						<div class="summary-details-value">
							<?php
								$shippingFee = 0;
								if ($shippingArea == "Malaysia" && ($quantity < 2 || $totalPrice < 150)) {
									$shippingFee = 10;
								} else if ($shippingArea == "Singapore" && $totalPrice < 300) {
									$shippingFee = 20;
								} else if ($shippingArea == "Brunei" && $totalPrice < 300) {
									$shippingFee = 25;
								}
								
								echo $model->symbol.' '.number_format((float)$shippingFee, 2, ".", "");
							?>
						</div>
					</div>
					
					<hr class="black-line">
					
					<div class="summary-total-payment">
						<div class="summary-details-label">
							Payment Required
						</div>
						<div class="summary-details-value">
							<?php echo $model->symbol.' '.number_format((float)($totalPrice - $discount + $shippingFee), 2, ".", ""); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>