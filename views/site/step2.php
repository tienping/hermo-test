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
								$brand = json_decode($model->brand);
								echo $brand->name; 
							?></h4>
							<div class="checkout-name"><?php echo $model->name; ?></div>
							<div class="checkout-selling-price"><?php echo $model->symbol.' '.$model->selling_price; ?></div>
							<div class="checkout-retail-price"><?php echo $model->symbol.' '.$model->retail_price; ?></div>
							<hr class="black-line">
							<div class="checkout-total-price-div">
								<span class="checkout-total-price-label">
									Total Price
								</span>
								<span class="checkout-total-price-amount">
									<?php 
										echo $model->symbol.' '.($model->selling_price * $quantity);
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
						Ship to area
					</span>
					<span class="shipment-destination">
						<input type="text">
					</span>
				</div>
				<div class="promocode-details-div">
					<span class="promocode-label">
						Promotion code
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
			</div>
		</div>
	</div>
</div>