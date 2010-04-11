<?php
class UserAgent extends LoggableAppModel {

    var $name = 'UserAgent';
    var $validate = array(
        'user_agent' => array(
            'rule' => 'isUnique'
        )
    );

    var $belongsTo = array(
        'OperatingSystem' => array(
            'className' => 'Loggable.OperatingSystem',
            'foreignKey' => 'operating_system_id'
        ),
        'Browser' => array(
            'className' => 'Loggable.Browser',
            'foreignKey' => 'browser_id'
        ),
        'Spider' => array(
            'className' => 'Loggable.Spider',
            'foreignKey' => 'spider_id'
        )
    );

    var $hasMany = array(
        'Log' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'user_agent_id'
        )
    );

    function beforeSave() {
        if (!isset($this->OperatingSystem) || !isset($this->Browser) || !isset($this->Spider)) {
            $this->getAssociated();
        }
        if (isset($this->data['UserAgent']['user_agent'])) {
            $this->data['UserAgent']['operating_system_id'] = $this->OperatingSystem->uniqueId($this->data['UserAgent']['user_agent']);
            $this->data['UserAgent']['browser_id'] = $this->Browser->uniqueId($this->data['UserAgent']['user_agent']);
            $this->data['UserAgent']['spider_id'] = $this->Spider->uniqueId($this->data['UserAgent']['user_agent']);
        }
        return true;
    }

}
