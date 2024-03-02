/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller('LeaveCtrl', function ($scope, $http, BaseURL) {

    $scope.editMode = false;

    $scope.editleave = {};
    $scope.addleave = {};

    $scope.getTemplate = function (leave) {
        if (leave.leave_id === $scope.editleave.leave_id)
            return 'edit_l';
        else
            return 'normal_l';
    };

    $scope.fetch = function () {
        $http.get(BaseURL + 'settings/get_leaves').success(function (data) {
            $scope.leaves = data;
//            console.log($scope.leaves);
        });
    };

    $scope.edit = function (leave) {
        $scope.editleave = angular.copy(leave);
    };

    $scope.save_changes = function (editleave) {
        $http.post(BaseURL + 'settings/edit_leave', editleave)
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

    $scope.save = function (addleave) {
        $http.post(BaseURL + 'settings/save_leave', addleave)
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

    $scope.delete = function (deleteleave) {
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
                $http.post(BaseURL + 'settings/delete_leave', deleteleave)
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
        $scope.editleave = {};
        $scope.addleave = {};
    };


});

