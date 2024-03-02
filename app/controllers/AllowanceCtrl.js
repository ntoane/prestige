/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller('AllowanceCtrl', function ($scope, $http, BaseURL) {

    $scope.editMode = false;


    $scope.editallowance = {};
    $scope.addallowance = {};
    $scope.pay_month = $("#pmonth").val();
    $scope.emp_id = $("#emp_id").val();
//    console.log($scope.pay_month);

    $scope.getTemplate = function (allowance) {
        if (allowance.allowance_id === $scope.editallowance.allowance_id)
            return 'edit_l';
        else
            return 'normal_l';
    };

    $scope.fetch = function () {
        $scope.addallowance.pay_month = $scope.pay_month;
        $scope.addallowance.emp_id = $scope.emp_id;
        $http.post(BaseURL + 'payroll/get_salary_allowances', {"emp_id": $scope.emp_id, "pay_month": $scope.pay_month}).success(function (data) {
            $scope.allowances = data;
//            console.log($scope.allowances);
        });
    };

    $scope.edit = function (allowance) {
        $scope.editallowance = angular.copy(allowance);
    };

    $scope.save_changes = function (editallowance) {
        $http.post(BaseURL + 'payroll/edit_salary_allowance', editallowance)
                .success(function (data) {
                    console.log(data);
                    if (data.error) {
                        $scope.message = data.message;
                    }
                    else {
                        $scope.reset();
                        $scope.fetch();
                        $scope.message = data.message;
                        swal("Updated", $scope.message, "success");
                    }
                });
    };

    $scope.save = function (addallowance) {
        $http.post(BaseURL + 'payroll/save_salary_allowance', addallowance)
                .success(function (data) {
                    if (data.error) {
                        $scope.message = data.message;
                        console.log($scope.message);
                    }
                    else {
                        $scope.reset();
                        $scope.fetch();
                        $scope.message = data.message;
                        swal("Inserted", $scope.message, "success");
                        
                    }
                });
    };

    $scope.delete = function (deleteallowance) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete!",
            cancelButtonText: "No, Cancel!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $http.post(BaseURL + 'payroll/delete_salary_allowance', deleteallowance)
                        .success(function (data) {
                            console.log(data);
                            if (data.error) {
                                $scope.message = data.message;
                            }
                            else {
                                $scope.reset();
                                $scope.fetch();
                                $scope.message = data.message;
                                swal("Deleted!", $scope.message, "success");
                            }
                        });
            } else {
                swal("Cancelled", "You cancelled, nothing deleted", "error");
            }
        });
    };

    $scope.reset = function () {
        $scope.editallowance = {};
        $scope.addallowance = {};
    };


});

