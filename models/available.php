<?php
class LoggableAvailable extends LoggableAppModel {
    var $name = 'LoggableAvailable';
    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.LoggableLog',
            'foreignKey'    => 'available_id'
        )
    );

}
