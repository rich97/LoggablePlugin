<?php
class LoggableScreen extends LoggableAppModel {
    var $name = 'LoggableScreen';

    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.LoggableLog',
            'foreignKey'    => 'screen_id'
        )
    );

}
