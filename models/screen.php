<?php
class Screen extends LoggableAppModel {
    var $name = 'Screen';

    var $hasMany = array(
        'Log' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'screen_id'
        )
    );

}
