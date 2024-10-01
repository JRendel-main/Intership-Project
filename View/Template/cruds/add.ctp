<div>
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-dot-circle-o"></i> NEW USER </div>
        <div class="panel-body">
            <div class="col-md-12">
                <form id="form">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fullname <i class="required">*</i></label>
                                <input type="text" class="form-control" ng-model="data.Crud.name"
                                    data-validation-engine="validate[required]">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Valid Email Address <i class="required">*</i></label>
                                <input type="email" class="form-control" ng-model="data.Crud.email"
                                    data-validation-engine="validate[required,custom[email]]">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group"> 
                                <label>Age</label>
                                <input type="number" class="form-control" ng-model="data.Crud.age" ng-min="0" readonly data-validation-engine="validate[required]">
                                <div ng-show="data.Crud.age < 0" class="text-danger">Age cannot be negative.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Birthday</label>
                                <input type="date" class="form-control" ng-model="data.Crud.bday" data-validation-engine="validate[required]">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" ng-options="opt.id as opt.value for opt in status" ng-model="data.Crud.crudStatusId">
                                    <option value="" disabled>Select Status</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Character <i class="required">*</i></label>
                                <textarea class="form-control" ng-model="data.Crud.character"
                                    data-validation-engine="validate[required]"></textarea>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                    </div>
                <hr>
                <div class="row">
                    <div class="col-md-3 pull-right">
                        <button class="btn btn-primary btn-sm btn-block" ng-click="save()">Register</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>