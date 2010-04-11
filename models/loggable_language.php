<?php
class LoggableLanguage extends LoggableAppModel {
    var $name = 'LoggableLanguage';

    var $validate = array(
        'language' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.LoggableLog',
            'foreignKey'    => 'language_id'
        )
    );

}
