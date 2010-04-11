<?php
class Url extends LoggableAppModel {

    var $name = 'Url';
    var $validate = array(
        'url' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'Log' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'url_id'
        )
    );

}
