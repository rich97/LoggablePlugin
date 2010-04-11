<?php
class Keyword extends LoggableAppModel {
    var $name = 'Keyword';

    var $validate = array(
        'keyword' => array(
            'rule' => 'isUnique'
        )
    );

    var $hasMany = array(
        'KeywordOrder' => array(
            'className'     => 'Loggable.KeywordOrder',
            'foreignKey'    => 'Keyword_id'
        )
    );

}
