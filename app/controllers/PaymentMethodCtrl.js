/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller('PaymentMethodCtrl', function ($scope, $http, BaseURL) {

    $scope.editMode = false;

    $scope.editmethod = {};
    $scope.addmethod = {};

    $scope.getTemplate = function (method) {
        if (method.method_id === $scope.editmethod.method_id)
            return 'edit';
        else
            return 'normal';
    };

    $scope.fetch = function () {
        $http.get(BaseURL + 'settings/get_payment_methods').success(function (data) {
            $scope.methods = data;
//            console.log($scope.methods);
        });
    };

    $scope.edit = function (method) {
        $scope.editmethod = angular.copy(method);
    };

    $scope.save_changes = function (editmethod) {
        $http.post(BaseURL + 'settings/edit_payment_method', editmethod)
                .success(function (data) {
                    console.log(data);
                    if (data.error) {
                        $scope.message = data.message;
                    }
                    else {
                        $scope.fetch();
                        $scope.reset();
                        $scope.message = data.message;
                        swal("Updated", $scope.message, "success");
                    }
                });
    };

    $scope.save = function (addmethod) {
        $http.post(BaseURL + 'settings/save_payment_method', addmethod)
                .success(function (data) {
                    if (data.error) {
                        $scope.message = data.message;
                        console.log($scope.message);
                    }
                    else {
                        $scope.fetch();
                        $scope.reset();
                        $scope.message = data.message;
                        swal("Inserted", $scope.message, "success");
                    }
                });
    };

    $scope.delete = function (deletemethod) {
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
                $http.post(BaseURL + 'settings/delete_payment_method', deletemethod)
                        .success(function (data) {
                            console.log(data);
                            if (data.error) {
                                $scope.message = data.message;
                            }
                            else {
                                $scope.fetch();
                                $scope.reset();
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
        $scope.editmethod = {};
        $scope.addmethod = {};
    };


});

