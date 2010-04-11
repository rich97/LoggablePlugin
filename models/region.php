<?php
class LoggableRegion extends LoggableAppModel {
    var $name = 'LoggableRegion';

    var $validate = array(
        'region' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.LoggableLog',
            'foreignKey'    => 'region_id'
        )
    );

}
