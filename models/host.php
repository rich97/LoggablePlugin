<?php
class Host extends LoggableAppModel {
    var $name = 'Host';

    var $validate = array(
        'host' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'Log' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'host_id'
        )
    );

}
