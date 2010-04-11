<?php
class LoggableCookie extends LoggableAppModel {
    var $name = 'LoggableCookie';

    var $validate = array(
        'cookie' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.LoggableLog',
            'foreignKey'    => 'cookie_id'
        )
    );

}
