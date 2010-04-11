<?php
class LoggableHost extends LoggableAppModel {
    var $name = 'LoggableHost';

    var $validate = array(
        'host' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.LoggableLog',
            'foreignKey'    => 'host_id'
        )
    );

}
