<?php
class LoggableUserAgent extends LoggableAppModel {

    var $name = 'LoggableUserAgent';
    var $validate = array(
        'user_agent' => array(
            'rule' => 'isUnique'
        )
    );

    var $belongsTo = array(
        'LoggableOperatingSystem' => array(
            'className' => 'Loggable.OperatingSystem',
            'foreignKey' => 'operating_system_id'
        ),
        'LoggableBrowser' => array(
            'className' => 'Loggable.Browser',
            'foreignKey' => 'browser_id'
        ),
        'LoggableSpider' => array(
            'className' => 'Loggable.Spider',
            'foreignKey' => 'spider_id'
        )
    );

    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.Log',
            'foreignKey'    => 'user_agent_id'
        )
    );

    function beforeSave() {
        if (!isset($this->OperatingSystem) || !isset($this->Browser) || !isset($this->Spider)) {
            $this->getAssociated();
        }
        if (isset($this->data['LoggableUserAgent']['user_agent'])) {
            $this->data['LoggableUserAgent']['operating_system_id'] = $this->OperatingSystem->uniqueId($this->data['LoggableUserAgent']['user_agent']);
            $this->data['LoggableUserAgent']['browser_id'] = $this->Browser->uniqueId($this->data['LoggableUserAgent']['user_agent']);
            $this->data['LoggableUserAgent']['spider_id'] = $this->Spider->uniqueId($this->data['LoggableUserAgent']['user_agent']);
        }
        return true;
    }

}
