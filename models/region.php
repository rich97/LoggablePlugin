<?php
class Region extends LoggableAppModel {
    var $name = 'Region';

    var $validate = array(
        'region' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'Log' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'region_id'
        )
    );

}
