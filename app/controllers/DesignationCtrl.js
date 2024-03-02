/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller('DesignationCtrl', function ($scope, $http, BaseURL) {

    $scope.editMode = false;

    $scope.editdesignation = {};
    $scope.adddesignation = {};

    $scope.getTemplate = function (designation) {
        if (designation.designation_id === $scope.editdesignation.designation_id)
            return 'edit';
        else
            return 'normal';
    };

    $scope.fetch = function (id) {
        $http.get(BaseURL + 'branches/get_designations/'+id).success(function (data) {
            $scope.designations = data;
            console.log($scope.designations);
        });
    };

    $scope.edit = function (designation) {
        $scope.editdesignation = angular.copy(designation);
    };

    $scope.save_changes = function (editdesignation) {
        $http.post(BaseURL + 'branches/edit_designation', editdesignation)
                .success(function (data) {
                    console.log(data);
                    if (data.error) {
                        $scope.message = data.message;
                    }
                    else {
                        $scope.fetch(editdesignation.branch_id);
                        $scope.reset();
                        $scope.message = data.message;
                        swal("Updated", $scope.message, "success");
                    }
                });
    };

    $scope.save = function (adddesignation, id) {
        adddesignation.branch_id = id;
        $http.post(BaseURL + 'branches/save_designation', adddesignation)
                .success(function (data) {
                    if (data.error) {
                        $scope.message = data.message;
                        console.log($scope.message);
                    }
                    else {
                        $scope.fetch(adddesignation.branch_id);
                        $scope.reset();
                        $scope.message = data.message;
                        swal("Inserted", $scope.message, "success");
                    }
                });
    };

    $scope.delete = function (deletedesignation) {
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
                $http.post(BaseURL + 'branches/delete_designation', deletedesignation)
                        .success(function (data) {
                            console.log(data);
                            if (data.error) {
                                $scope.message = data.message;
                            }
                            else {
                                $scope.fetch(deletedesignation.branch_id);
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
        $scope.editdesignation = {};
        $scope.adddesignation = {};
    };


});

