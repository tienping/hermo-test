<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\Url;

$this->title = 'Step 1';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index" ng-app="HermoApp">

    <div class="">
        <p class="lead">Simple Shopping App - Step 1</p>
    </div>
	
	<div class="banner" ng-controller="bannerController">
		<div class="banner-container" ng-init="getCarouselItems()">
			<img id="banner-loading-image" src="images/loading-horizontal.gif">
			<ul rn-carousel="" rn-carousel-auto-slide="5" rn-carousel-transition="slide" rn-carousel-duration="500" rn-swipe-disabled="false" rn-carousel-index="carouselIndex" class="banner-image">
				<li ng-repeat="bannerImage in bannerImages">
					<img ng-src="{{ bannerImage.image }}">
				</li>
			</ul>
			<div rn-carousel-indicators ng-if="bannerImages.length > 1" slides="bannerImages" rn-carousel-index="carouselIndex"></div>
		</div>
	</div>
	
	<div class="sort-by-div">
		<span class="sort-by-label">
			Sort By: 
		</span>
		<span class="sort-by-select-span">
			<select class="sort-by-select">
				<option>Select</option>
				<option field="name" order="ASC">Product Name [A to Z]</option>
				<option field="name" order="DESC">Product Name [Z to A]</option>
				<option field="selling_price" order="ASC">Selling Price [Low to High]</option>
				<option field="selling_price" order="DESC">Selling Price [High to Low]</option>
				<option field="discount_rate" order="ASC">Discount Rate [Low to High]</option>
				<option field="discount_rate" order="DESC">Discount Rate [High to Low]</option>
			</select>
		</span>
		<script>
			var sortingSelect = document.querySelector(".sort-by-select");
			sortingSelect.selectedIndex = 0;
			var sortingAction = function sortingAction() {
				var selectedSorting = sortingSelect.options[sortingSelect.selectedIndex];
				var selectedField = selectedSorting.getAttribute("field");
				var selectedOrder = selectedSorting.getAttribute("order");
				
				if (selectedField && selectedOrder) {
					window.location.search = "?r=site/step1"
						+ "&field=" + selectedField
						+ "&order=" + selectedOrder;
				}
			};
			sortingSelect.onchange = sortingAction;
		</script>
	</div>
	
    <div class="body-content">
		<div class="row product-listing">
			<?php foreach ($dataProvider->models as $model): ?>
				<div class="col-lg-4 product-item-div">
					<div class="product-item">
						<div class="discount-tag">
							<?php echo $model->discount_rate ?>%
						</div>
						<div class="product-img-div"><?php echo "<img class='product-img' src='".$model->images."'/>"; ?></div>
						<div class="product-brand"><?php 
							echo $model->brand; 
						?></div>
						<h4 class="product-name"><?php echo $model->name; ?></h4>
						<div class="product-selling-price"><?php echo $model->symbol.' '.number_format((float)$model->selling_price, 2, ".", ""); ?></div>
						<div class="product-retail-price"><?php echo $model->symbol.' '.number_format((float)$model->retail_price, 2, ".", ""); ?></div>
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
				if (productPurchaseDivs && productPurchaseDivs.length > 0) {
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
				} else {
					console.warn("productPurchaseDivs not found...");
				}
			</script>
		</div>
    </div>
</div>