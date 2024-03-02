app.controller('SalaryTemplateCtrl', function ($scope, $http, BaseURL) {

    $scope.template_grade = "";
    $scope.basic_salary = 0;
    $scope.security = 0;
    
    $scope.calculate_security = function() {
        $scope.security = 0.05 * $scope.basic_salary;
    };

});