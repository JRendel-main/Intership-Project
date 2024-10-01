<?php 

class Crud extends AppModel {
    public $actsAs = ['Containable'];

    public $belongsTo = ['CrudStatus' => ['foreignKey' => 'crudStatusId']];
}