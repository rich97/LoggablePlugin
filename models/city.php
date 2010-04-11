<?php
class City extends LoggableAppModel {
    var $name = 'City';

    var $validate = array(
        'city' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'Log' => array(
            'className' => 'Loggable.Log',
            'foreignKey' => 'city_id'
        )
    );

}
