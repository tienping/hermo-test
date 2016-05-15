var HermoApp = angular.module('HermoApp', ['angular-carousel']);

HermoApp.controller('bannerController', ['$scope', '$http', function($scope, $http) {
	$scope.updateCarousel = function redGlassDisplay_updateCarousel(dataArr) {
		var bannerImageLength = 0;
		
		var bannerArr = dataArr;
		if (!bannerArr || !(bannerArr instanceof Array)) {
			console.warn("No data for banner");
		} else {
			$scope.bannerImages = bannerArr;
		}
		
		var bannerLoadingImage = document.querySelector("#banner-loading-image");
		if (bannerArr && bannerArr.length > 0) {
			bannerLoadingImage.style.display = "none";
		} else {
			bannerLoadingImage.style.display = "block";
		}
	}
	$scope.getCarouselItems = function redGlassDisplay_getCarouselItems() {
		$http.get("https://www.hermo.my/test/api.html?list=banner")
			.success(function (response) {
				if (response && response.items) {
					var dataArr = response.items;
					$scope.updateCarousel(dataArr);
				}
			})
			.error(function (response) {
			});
	}
	$scope.getCarouselItems();
}]);