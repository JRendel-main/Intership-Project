function calculateAge(bday) {
  let today = new Date();
  let birthDate = new Date(bday);

  let age = today.getFullYear() - birthDate.getFullYear();
  let m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }

  return age;
}


app.controller('CrudsController', function ($scope, Crud, Print) {
  $scope.selectedTab = 'all'; // Default tab
  $scope.filteredCruds = []; // Array for filtered data
  $scope.allCruds = []; // Store all records for advanced search

  $scope.selectedPrintType = 'all';

  $scope.advancedSearch = {
    name: '',
    dateFrom: '',
    dateTo: ''
  };

  // Initial load of data
  $scope.load = function (options) {
    options = options || {};
    Crud.query(options, function (e) {
      if (e.response.ok) {
        $scope.cruds = e.response.data;
        $scope.allCruds = angular.copy($scope.cruds); // Store for advanced search
        $scope.filterCruds(); // Call filter function
        $scope.paginator = e.response.paginator;
        $scope.pages = paginator($scope.paginator, 5);
      }
    });
  };

  // Function to select a tab and filter data
  $scope.selectTab = function (tab) {
    $scope.selectedTab = tab;
    $scope.filterCruds(); // Filter data based on selected tab
  };

  // Function to filter data based on selected tab
  $scope.filterCruds = function () {
    if ($scope.selectedTab === 'all') {
      $scope.filteredCruds = $scope.cruds;
    } else {
      $scope.filteredCruds = $scope.cruds.filter(function (crud) {
        return crud.status === $scope.selectedTab;
      });
    }
  };

  // Function for simple search
  $scope.search = function (search) {
    search = search || '';
    if (search.length > 0) {
      $scope.load({ search: search });
    } else {
      $scope.load();
    }
  };

  // Function for advanced search
  $scope.advancedSearchFunction = function () {
    let filteredCruds = $scope.allCruds;

    if ($scope.advancedSearch.name) {
      filteredCruds = filteredCruds.filter(data =>
        data.name.toLowerCase().includes($scope.advancedSearch.name.toLowerCase())
      );
    }

    if ($scope.advancedSearch.dateFrom) {
      filteredCruds = filteredCruds.filter(data =>
        new Date(data.date_created) >= new Date($scope.advancedSearch.dateFrom)
      );
    }

    if ($scope.advancedSearch.dateTo) {
      filteredCruds = filteredCruds.filter(data =>
        new Date(data.date_created) <= new Date($scope.advancedSearch.dateTo)
      );
    }

    $scope.filteredCruds = filteredCruds; // Update displayed data
  };

  // Reset search filters
  $scope.resetSearch = function () {
    $scope.advancedSearch = {
      name: '',
      dateFrom: '',
      dateTo: ''
    };
  };

  $scope.openPrintModal = function () {
    $('#printModal').modal('show');
  };

  $scope.print = function () {
    let dataToPrint = $scope.filteredCruds;

    // check if dataToPrint is empty
    

    Print.print(dataToPrint).then(response => {
      let file = new Blob([response.data], { type: 'application/pdf' });
      let fileURL = URL.createObjectURL(file);
      window.open(fileURL);
    }
    ).catch(error => {
      console.log(error);
      $.gritter.add({
        title: "Warning!",
        text: "An error occurred while generating the report"
      });
    });
  };


  // Function to remove a record
  $scope.remove = function (data) {
    bootbox.confirm("Are you sure you want to delete this record " + data.name + "?", function (result) {
      if (result) {
        Crud.delete({ id: data.id }, function (e) {
          if (e.response.ok) {
            $.gritter.add({
              title: "Successful!",
              text: e.response.msg
            });
            $scope.load(); // Reload after deletion
          } else {
            $.gritter.add({
              title: "Warning!",
              text: e.response.msg
            });
          }
        });
      }
    });
  };

  // Initial load
  $scope.load();
});

app.controller('CrudsAddController', function($scope, Crud, Select) {
  valid = $("#form").validationEngine('attach');

  Select.get({ code: 'crud_status'}, function(e) {
    $scope.status = e.data;
    console.log($scope.status)
  })

  $scope.$watch('data.Crud.bday', function (newVal, oldVal) {
    if(newVal) {
      $scope.data.Crud.age = calculateAge(newVal)
    }
  })

  $scope.save = function() {
    if (valid) {
      Crud.save($scope.data, function (e) {
        console.log(e)
        if (e.response.ok) {
          $.gritter.add({
            title: "Successful!",
            text: e.response.msg
          })
          window.location = "#/crud";
        } else {
          $.gritter.add({
            title: "Warning!",
            text: e.response.msg
          })

          console.log(e.msg)
        }
      })
    } else {
      $.gritter.add({
        title: "Warning!",
        text: "Please fill up the form correctly"
      })
    }
  }

});

app.controller('CrudsViewController', function ($scope, $routeParams, Crud, Beneficiary, Print) {
  $scope.id = $routeParams.id;

  $scope.approve = function () {
    // Update status to approved
    Crud.update({ id: $scope.id }, { status: 'approved' }, function (e) {
      if (e.response.ok) {
        $.gritter.add({
          title: "Successful!",
          text: e.response.msg
        });
        $scope.load();
      } else {
        $.gritter.add({
          title: "Warning!",
          text: e.response.msg
        });
      }
    });
  };

  $scope.disapprove = function () {
    // Update status to disapproved
    Crud.update({ id: $scope.id }, { status: 'disapproved' }, function (e) {
      if (e.response.ok) {
        $.gritter.add({
          title: "Successful!",
          text: e.response.msg
        });
        $scope.load();
      } else {
        $.gritter.add({
          title: "Warning!",
          text: e.response.msg
        });
      }
    });
  };

  $scope.countBeneficiaries = function () {
    Beneficiary.query({ userId: $scope.id }, function (e) {
      let beneficiaries = e.response.data;
      $scope.beneficiaries = beneficiaries;
      $scope.totalBeneficiaries = beneficiaries.length;
    });
  };

  $scope.countBeneficiaries();

  $scope.load = function () {
    Crud.get({ id: $scope.id }, function (e) {
      let data = e.response.data;

      let age = new Date().getFullYear() - new Date(data.Crud.bday).getFullYear();
      data.age = age;

      $scope.data = data;
    });
  };

  $scope.load();

  $scope.remove = function (data) {
    bootbox.confirm("Are you sure you want to delete this record " + data.name + "?", function (result) {
      Crud.remove({ id: data.id }, function (e) {
        if (e.response.ok) {
          $.gritter.add({
            title: "Successful!",
            text: e.response.msg
          });
          window.location = "#/crud";
        } else {
          $.gritter.add({
            title: "Warning!",
            text: e.response.msg
          });
        }
      });
    });
  };

  // Function to print user and beneficiary data
  $scope.print = function () {
    let userData = {
      Crud: $scope.data.Crud,
      beneficiaries: $scope.beneficiaries
    };

    Print.print(userData).then(response => {
      let file = new Blob([response.data], { type: 'application/pdf' });
      let fileURL = URL.createObjectURL(file);
      window.open(fileURL); // Display the PDF in a new tab
    }).catch(error => {
      console.log(error);
      $.gritter.add({
        title: "Warning!",
        text: "An error occurred while generating the report"
      });
    });
  };
});


app.controller('CrudsEditController', function($scope, $routeParams, Crud, Select, Beneficiary) {
  $scope.id = $routeParams.id;

  $scope.loadBeneficiaries = function() {
    Beneficiary.query({ userId: $scope.id }, function(e) {
      $scope.beneficiaries = e.response.data;
    })
  }

  $scope.loadBeneficiaries();

  $scope.addBeneficiary = function() {
    $scope.beneficiary = {};
    $('#add-beneficiary-modal').modal('show');

    $scope.beneficiary.userId = $scope.data.Crud.id;

    // calculate age
    $scope.$watch('beneficiary.bday', function (newVal, oldVal) {
      if (newVal) {
        $scope.beneficiary.age = calculateAge(newVal)
      }
    })
  }

  $scope.saveBeneficiary = function() {
    Beneficiary.save($scope.beneficiary, function(e) {
      if (e.response.ok) {
        $.gritter.add({
          title: "Successful!",
          text: e.response.msg
        })

        $scope.loadBeneficiaries();
      } else {
        $.gritter.add({
          title: "Warning!",
          text: e.response.msg
        })
      }
    })
    $('#add-beneficiary-modal').modal('hide');
  }

  $scope.removeBeneficiary = function(data) {
    bootbox.confirm("Are you sure you want to delete this record " + data.name + "?", function(result) {
      Beneficiary.delete({ id: data.id }, function(e) {
        if (e.response.ok) {
          $.gritter.add({
            title: "Successful!",
            text: e.response.msg
          })

          $scope.loadBeneficiaries();
        } else {
          $.gritter.add({
            title: "Warning!",
            text: e.response.msg
          })
        }
      })
    });
  }

  $scope.$watch('data.Crud.bday', function (newVal, oldVal) {
    if (newVal) {
      $scope.data.Crud.age = calculateAge(newVal)
    }
  })

  Select.get({ code: 'crud_status' }, function (e) {
    $scope.status = e.data;
    console.log($scope.status)
  })

  $scope.load = function() {
    Crud.get({ id: $scope.id }, function(e) {
      $scope.data = e.response.data;
    })
  }

  $scope.save = function() {
    Crud.update({ id: $scope.id }, $scope.data, function(e) {
      if (e.response.ok) {
        $.gritter.add({
          title: "Successful!",
          text: e.response.msg
        })
        $scope.load();
      } else {
        $.gritter.add({
          title: "Warning!",
          text: e.response.msg
        })
      }
    })
  }
  $scope.load();

  
});
