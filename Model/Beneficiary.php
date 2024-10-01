<?php 

class Beneficiary extends AppModel {
    public $actsAs = ['Containable'];

    public $belongsTo = ['crud' => ['foreignKey' => 'id']];
}