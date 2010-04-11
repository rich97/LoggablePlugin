<?php
class Country extends LoggableAppModel {
    var $name = 'Country';

    var $hasMany = array(
        'Log' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'country_id'
        )
    );

}
