<?php
class Continent extends LoggableAppModel {
    var $name = 'Continent';

    var $validate = array(
        'continent' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'Log' => array(
            'className' => 'Loggable.Log',
            'foreignKey' => 'continent_id'
        )
    );

}
