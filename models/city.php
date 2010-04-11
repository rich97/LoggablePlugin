<?php
class LoggableCity extends LoggableAppModel {
    var $name = 'LoggableCity';

    var $validate = array(
        'city' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'LoggableLog' => array(
            'className' => 'Loggable.LoggableLog',
            'foreignKey' => 'city_id'
        )
    );

}
