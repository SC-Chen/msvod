/**
 * Created by Administrator on 2016/12/7 0007.
 */
angular.module('ionicApp', ['ionic'])
    .controller('SlideController', function ($scope) {
        $scope.index = 0;
        $scope.myActiveSlide = 1;
        //分享
        $scope.shareVAR = true;
        $scope.toggle = function() {
            $scope.shareVAR = !$scope.shareVAR;
        }
        //搜索
        $scope.mySearch = false;
        $scope.toggle_so = function() {
            $scope.mySearch = !$scope.mySearch;
        }
    })
