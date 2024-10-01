<div class="panel panel-primary">
    <div class="panel-heading">
        <i class="fa fa-dot-circle-o"></i> View User
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <dl class="dl-horizontal dl-data dl-bordered">
                    <dt>Name:</dt>
                    <dd class="cammelcase">{{ data.Crud.name }}</dd>

                    <dt>Status:</dt>
                    <dd><b>{{ data.CrudStatus.name }}</b></dd>

                    <dt>Birthday: </dt>
                    <dd>{{ data.Crud.bday | date: 'mediumDate' }}</dd>

                    <dt>Age:</dt>
                    <dd>{{ data.Crud.age }}</dd>

                    <dt>Email:</dt>
                    <dd>{{ data.Crud.email }}</dd>

                    <dt>Character:</dt>
                    <dd>{{ data.Crud.character }}</dd>

                    <dt>Num. of Beneficiaries:</dt>
                    <dd>{{ totalBeneficiaries }}</dd>

                    <dt>Account Status</dt>
                    <dd>
                        <span
                            class="label label-{{ data.Crud.status == 'pending' ? 'warning' : (data.Crud.status == 'approved' ? 'success' : 'danger') }}">
                            {{ data.Crud.status | uppercase }}
                        </span>
                    </dd>

                    <!-- Button group approve disapprove -->
                    <dt>Actions:</dt>
                    <dd>
                        <div class="btn-group btn-group-sm">
                            <button ng-click="approve(data.Crud)" class="btn btn-success" title="APPROVE"
                                ng-disabled="data.Crud.status == 'approved'">
                                <i class="fa fa-check"></i> Approve
                            </button>
                            <button ng-click="disapprove(data.Crud)" class="btn btn-danger" title="DISAPPROVE"
                                ng-disabled="data.Crud.status == 'disapproved'">
                                <i class="fa fa-times"></i> Disapprove
                            </button>
                        </div>
                    </dd>
                </dl>
            </div>

            <div class="col-md-6">
                <!-- add print button and put to right side -->
                <div class="btn-group btn-group-lg pull-right">
                    <button class="btn btn-info" ng-disabled="data.Crud.status !== 'approved'"
                        ng-click="print(data.Crud)">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 mx-4">
                    <div class="btn-group btn-group-sm pull-right btn-min">
                        <a href="#/crud/edit/{{ data.Crud.id }}" class="btn btn-primary"
                            ng-disabled="data.Crud.status === 'pending'">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="javascript:void(0)" ng-click="remove(data.Crud)" class="btn btn-danger" title="DELETE"
                            ng-disabled="data.Crud.status === 'pending'">
                            <i class="fa fa-trash"></i> DELETE
                        </a>
                    </div>
                </div>
            </div>

            <!-- Hide this table if status is not 'approved' -->
            <div class="row" ng-if="data.Crud.status === 'approved'">
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Relationship</th>
                                <th>Birthday</th>
                                <th>Age</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="beneficiary in beneficiaries">
                                <td>{{ beneficiary.Beneficiary.name }}</td>
                                <td><b>{{ beneficiary.Beneficiary.relationship }}</b></td>
                                <td>
                                    {{ beneficiary.Beneficiary.bday | date: 'mediumDate' }}
                                </td>
                                <td>
                                    {{ beneficiary.Beneficiary.age }} year/s old
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
