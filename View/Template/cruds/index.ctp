<div class="panel panel-primary">
    <div class="panel-heading">
        <i class="fa fa-dot-circle-o"></i> CRUDS
    </div>
    <div class="panel-body">
        <div class="row mb-3">
            <!-- Add New Button -->
            <div class="col-md-6">
                <a href="#/crud/add" class="btn btn-success btn-block">
                    <i class="fa fa-plus"></i> Add New
                </a>
            </div>
            <!-- Print Button (will trigger modal) -->
            <div class="col-md-6">
                <button class="btn btn-primary btn-block" ng-click="print()">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" class="form-control" ng-model="searchTxt" ng-change="search(searchTxt)"
                        placeholder="Search..." aria-label="Search">
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>

        <!-- Advanced Search Filters -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="dateFrom">Date From:</label>
                <input type="date" class="form-control" ng-model="advancedSearch.dateFrom">
            </div>
            <div class="col-md-6">
                <label for="dateTo">Date To:</label>
                <input type="date" class="form-control" ng-model="advancedSearch.dateTo">
            </div>
            <div class="col-md-12 mt-2">
                <button class="btn btn-info" ng-click="advancedSearchFunction()">Search</button>
            </div>
        </div>

        <!-- Tabs for filtering data -->
        <ul class="nav nav-tabs mb-3">
            <li ng-class="{ active: selectedTab === 'all' }">
                <a href="javascript:void(0)" ng-click="selectTab('all')">All</a>
            </li>
            <li ng-class="{ active: selectedTab === 'pending' }">
                <a href="javascript:void(0)" ng-click="selectTab('pending')">Pending</a>
            </li>
            <li ng-class="{ active: selectedTab === 'approved' }">
                <a href="javascript:void(0)" ng-click="selectTab('approved')">Approved</a>
            </li>
            <li ng-class="{ active: selectedTab === 'disapproved' }">
                <a href="javascript:void(0)" ng-click="selectTab('disapproved')">Disapproved</a>
            </li>
        </ul>

        <!-- Data Table -->
        <div class="col-md-12">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fullname</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="data in filteredCruds">
                        <td>{{ data.id }}</td>
                        <td>{{ data.name }}</td>
                        <td>
                            <span class="label label-{{ data.status == 'pending' ? 'warning' : (data.status == 'approved' ? 'success' : 'danger') }}">
                                {{ data.status | uppercase }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-xs">
                                <a href="#/crud/view/{{ data.id }}" class="btn btn-success" title="VIEW">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="#/crud/edit/{{ data.id }}" class="btn btn-primary" title="EDIT">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <ul class="pagination pull-right">
            <li class="pagination-page">
                <a href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt })">
                    &laquo;&laquo;
                </a>
            </li>
            <li class="prevPage" ng-class="{'disabled': !paginator.prevPage}">
                <a href="javascript:void(0)" ng-click="load({ page: paginator.page - 1, search: searchTxt })">
                    &laquo;
                </a>
            </li>
            <li ng-repeat="page in pages" ng-class="{'active': paginator.page == page.number}">
                <a href="javascript:void(0)" ng-click="load({ page: page.number, search: searchTxt })">{{ page.number }}</a>
            </li>
            <li class="nextPage" ng-class="{'disabled': !paginator.nextPage}">
                <a href="javascript:void(0)" ng-click="load({ page: paginator.page + 1, search: searchTxt })">
                    &raquo;
                </a>
            </li>
            <li class="pagination-page">
                <a href="javascript:void(0)" ng-click="load({ page: paginator.pageCount, search: searchTxt })">
                    &raquo;&raquo;
                </a>
            </li>
        </ul>
    </div>
</div>

