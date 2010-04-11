<?php
class LoggableKeyword extends LoggableAppModel {
    var $name = 'LoggableKeyword';

    var $validate = array(
        'keyword' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'LoggableKeywordOrder' => array(
            'className'     => 'Loggable.LoggableKeywordOrder',
            'foreignKey'    => 'Keyword_id'
        )
    );

}
