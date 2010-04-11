<?php
class LoggableContinent extends LoggableAppModel {
    var $name = 'LoggableContinent';

    var $validate = array(
        'continent' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'LoggableLog' => array(
            'className' => 'Loggable.LoggableLog',
            'foreignKey' => 'continent_id'
        )
    );

}
