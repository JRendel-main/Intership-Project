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
                                <label>Age <i class="required">*</i></label>
                                <input type="number" class="form-control" ng-model="data.Crud.age"
                                    data-validation-engine="validate[required]">
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