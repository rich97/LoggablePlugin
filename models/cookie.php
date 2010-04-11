<?php
class Cookie extends LoggableAppModel {
    var $name = 'Cookie';

    var $validate = array(
        'cookie' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'Log' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'cookie_id'
        )
    );

}
