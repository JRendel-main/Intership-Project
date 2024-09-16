 app.factory("Crud", function($resource) {
  return $resource( api + "cruds/:id", { id: '@id', search: '@search' }, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' },
    search: { method: 'GET' },
    save: { method: 'POST' },
    delete: { method: 'DELETE' }
  });
});

