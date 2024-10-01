 app.factory("Crud", function($resource) {
  return $resource( api + "cruds/:id", { id: '@id', search: '@search' }, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' },
    search: { method: 'GET' },
    save: { method: 'POST' },
    delete: { method: 'DELETE' },
    get: { method: 'GET' },
  });
});

app.factory("Beneficiary", function($resource) {
  return $resource( api + "beneficiaries/:id", { id: '@id', search: '@search' }, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' },
    search: { method: 'GET' },
    save: { method: 'POST' },
    delete: { method: 'DELETE' }
  });
});

app.service('Print', function ($http) {
  this.print = function (data) {
    return $http.post('print/print', data, { responseType: 'arraybuffer' });
  };
});
