<?php
class Language extends LoggableAppModel {
    var $name = 'Language';

    var $validate = array(
        'language' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'Log' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'language_id'
        )
    );

}
