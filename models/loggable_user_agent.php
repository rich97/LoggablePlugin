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
            'className' => 'Loggable.LoggableOperatingSystem',
            'foreignKey' => 'operating_system_id'
        ),
        'LoggableBrowser' => array(
            'className' => 'Loggable.LoggableBrowser',
            'foreignKey' => 'browser_id'
        ),
        'LoggableSpider' => array(
            'className' => 'Loggable.LoggableSpider',
            'foreignKey' => 'spider_id'
        )
    );

    var $hasMany = array(
        'LoggableLog' => array(
            'className'     => 'Loggable.LoggableLog',
            'foreignKey'    => 'user_agent_id'
        )
    );

    function beforeSave() {
        if (!isset($this->LoggableOperatingSystem) || !isset($this->Browser) || !isset($this->Spider)) {
            $this->getAssociated();
        }
        if (isset($this->data['LoggableUserAgent']['user_agent'])) {
            $this->data['LoggableUserAgent']['operating_system_id'] = $this->LoggableOperatingSystem->uniqueId($this->data['LoggableUserAgent']['user_agent']);
            $this->data['LoggableUserAgent']['browser_id'] = $this->LoggableBrowser->uniqueId($this->data['LoggableUserAgent']['user_agent']);
            $this->data['LoggableUserAgent']['spider_id'] = $this->LoggableSpider->uniqueId($this->data['LoggableUserAgent']['user_agent']);
        }
        return true;
    }

}
