<?php
class Available extends LoggableAppModel {
    var $name = 'Available';

    var $hasMany = array(
        'Log' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'available_id'
        )
    );

}
