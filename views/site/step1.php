<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\Url;

$this->title = 'Step 1';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="">
        <p class="lead">Simple Shopping App - Step 1</p>
    </div>

    <div class="body-content">
		<div class="row product-listing">
			<?php foreach ($dataProvider->models as $model): ?>
				<div class="col-lg-4 product-item-div">
					<div class="product-item">
						<!--<div class="product-img-div"><?php echo "<img class='product-img' src='".$model->images."'/>"; ?></div>-->
						<div class="product-brand"><?php 
							$brand = json_decode($model->brand);
							echo $brand->name; 
						?></div>
						<h4 class="product-name"><?php echo $model->name; ?></h4>
						<div class="product-selling-price"><?php echo $model->symbol.' '.$model->selling_price; ?></div>
						<div class="product-retail-price"><?php echo $model->symbol.' '.$model->retail_price; ?></div>
						<div class="product-action">
							<div class="product-quantity-div">
								<select class="product-quantity-select">
									<options>
										<option>QTY</option>
										<?php
											for ($i = 1; $i <= 10; $i++) {
												echo "<option>".$i."</option>";
											}
										?>
									</options>
								</select>
								<?php 
									/*echo Select2::widget([
										'model' => $model,
										'attribute' => 'state_2',
										'data' => [1,2,3,4],
										'options' => ['placeholder' => 'QTY'],
										'pluginOptions' => [
											'allowClear' => false
										],
									]);*/
								?>
							</div>
							<div class="product-purchase" id="<?php echo $model->id ?>">
								<a class="btn btn-default">
									Buy Now
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			<script>
				var productPurchaseDivs = document.getElementsByClassName("product-purchase");

				var purchasing = function() {
					var purchaseBtn = this;
					var actionDiv = purchaseBtn.parentNode;
					var quantitySelect = actionDiv.querySelector(".product-quantity-select");
					var productId = purchaseBtn.id;
					
					var quantitySelected = quantitySelect.options[quantitySelect.selectedIndex].value;
					if (quantitySelected == "QTY") {
						quantitySelected = 1;
					}
					
					window.location.search = "?r=site/step2&id=" + productId + "&quantity=" + quantitySelected;
				};

				for (var i = 0; i < productPurchaseDivs.length; i++) {
					productPurchaseDivs[i].addEventListener('click', purchasing, false);
				}
			</script>
		</div>
    </div>
</div>