<?php
class LoggableCountry extends LoggableAppModel {
    var $name = 'LoggableCountry';

    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.LoggableLog',
            'foreignKey'    => 'country_id'
        )
    );

}
