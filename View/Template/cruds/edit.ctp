<div>
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-dot-circle-o"></i> EDIT USER </div>
        <div class="panel-body">
            <div class="col-md-12">
                <form id="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fullname <i class="required"></i></label>
                                <input type="text" class="form-control" ng-model="data.Crud.name"
                                    data-validation-engine="validate[required]">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <i class="required"></i></label>
                                <input type="email" class="form-control" ng-model="data.Crud.email"
                                    data-validation-engine="validate[required,custom[email]]">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" ng-options="opt.id as opt.value for opt in status" ng-model="data.Crud.crudStatusId">
                                    <option value="" disabled>Select Status</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" ng-model="data.Crud.status">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="disapproved">Disapproved</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Age <i class="required"></i></label>
                                <input type="number" class="form-control" ng-model="data.Crud.age" readonly
                                    data-validation-engine="validate[required]">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Birthday</label>
                                <input type="date" class="form-control" ng-model="data.Crud.bday">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Character <i class="required">*</i></label>
                                <textarea class="form-control" ng-model="data.Crud.character"
                                    data-validation-engine="validate[required]"></textarea>
                            </div>
                        </div>

                        <div class="row">
                    <div class="col-md-3 pull-right">
                        <button class="btn btn-info btn-sm btn-block" ng-click="save()">UPDATE</button>
                    </div>
                </div>

                        <div class="clearfix"></div>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Relationship</th>
                                            <th>Birthday</th>
                                            <th>Age</th>
                                            <th>Action</th>
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
                                                {{ beneficiary.Beneficiary.age }}
                                            <td>
                                                <button class="btn btn-danger btn-sm" ng-click="removeBeneficiary(beneficiary.Beneficiary)">Remove</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-success btn-sm" ng-click="addBeneficiary()">Add Beneficiary</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-beneficiary-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Beneficiary</h4>
            </div>
            <div class="modal-body">
                <form id="beneficiary" ng-submit="saveBeneficiary()">
                    <input type="hidden" ng-model="beneficiary.userId">
                    <div class="form-group">
                        <label>Fullname <i class="required">*</i></label>
                        <input type="text" class="form-control" ng-model="beneficiary.name" data-validation-engine="validate[required]">
                    </div> 
                    <div class="form-group">
                        <label>Age <i class="required">*</i></label>
                        <input type="number" class="form-control" ng-model="beneficiary.age" data-validation-engine="validate[required]" disabled>
                    </div>
                    <div class="form-group">
                        <label>Birthday</label>
                        <input type="date" class="form-control" ng-model="beneficiary.bday">
                    </div>
                    <div class="form-group">
                        <label>Relationship <i class="required">*</i></label>
                        <input type="text" class="form-control" ng-model="beneficiary.relationship" data-validation-engine="validate[required]">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Add</button>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>
