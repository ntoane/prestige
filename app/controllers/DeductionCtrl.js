/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller('DeductionCtrl', function ($scope, $http, BaseURL) {

    $scope.editMode = false;


    $scope.editdeduction = {};
    $scope.adddeduction = {};
    $scope.pay_month = $("#pmonth").val();
    $scope.emp_id = $("#emp_id").val();
//    console.log($scope.pay_month);

    $scope.getTemplate = function (deduction) {
        if (deduction.deduction_id === $scope.editdeduction.deduction_id)
            return 'edit_2';
        else
            return 'normal_2';
    };

    $scope.fetch = function () {
        $scope.adddeduction.pay_month = $scope.pay_month;
        $scope.adddeduction.emp_id = $scope.emp_id;
        $http.post(BaseURL + 'payroll/get_salary_deductions', {"emp_id": $scope.emp_id, "pay_month": $scope.pay_month}).success(function (data) {
            $scope.deductions = data;
//            console.log($scope.deductions);
        });
    };

    $scope.edit = function (deduction) {
        $scope.editdeduction = angular.copy(deduction);
    };

    $scope.save_changes = function (editdeduction) {
        $http.post(BaseURL + 'payroll/edit_salary_deduction', editdeduction)
                .success(function (data) {
//                    console.log(data);
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

    $scope.save = function (adddeduction) {
        $http.post(BaseURL + 'payroll/save_salary_deduction', adddeduction)
                .success(function (data) {
                    if (data.error) {
                        $scope.message = data.message;
//                        console.log($scope.message);
                    }
                    else {
                        $scope.reset();
                        $scope.fetch();
                        $scope.message = data.message;
                        swal("Inserted", $scope.message, "success");
                    }
                });
    };

    $scope.delete = function (deletededuction) {
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
                $http.post(BaseURL + 'payroll/delete_salary_deduction', deletededuction)
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
        $scope.editdeduction = {};
        $scope.adddeduction = {};
    };


});

