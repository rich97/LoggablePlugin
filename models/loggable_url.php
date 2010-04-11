<?php
class LoggableUrl extends LoggableAppModel {

    var $name = 'LoggableUrl';
    var $validate = array(
        'url' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.LoggableLog',
            'foreignKey'    => 'url_id'
        )
    );

}
