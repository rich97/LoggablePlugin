<?php
class LoggableReferrer extends LoggableAppModel {

    var $name = 'LoggableReferrer';
    var $validate = array(
        'referrer' => array(
            'rule' => 'isUnique'
        )
    );

    var $belongsTo = array(
        'LoggableSearchEngine' => array(
            'className' => 'Loggable.LoggableSearchEngine',
            'foreignKey' => 'search_engine_id'
        )
    );
    var $hasMany = array(
        'LoggableLog' => array(
            'className' => 'Loggable.LoggableLog',
            'foreignKey' => 'referrer_id'
        ),
        'LoggableKeywordOrder' => array(
            'className' => 'Loggable.LoggableKeywordOrder',
            'foreignKey' => 'referrer_id'
        )
    );

    function beforeSave() {
        if (!isset($this->LoggableSearchEngine)) {
            $this->getAssociated();
        }
        if (isset($this->data['LoggableReferrer']['referrer'])) {
            $tmp = $this->LoggableSearchEngine->uniqueId($this->data['LoggableReferrer']['referrer']);
            $this->data['LoggableReferrer']['search_engine_id'] = $tmp['search_engine_id'];
            $this->keywords = $tmp['keywords'];
        }
        return true;
    }

    function afterSave($created) {
        if ($created && $this->keywords !== null) {
            if (!isset($this->LoggableKeywordOrder->LoggableKeyword)) {
                $this->getAssociated();
                $this->LoggableKeywordOrder->getAssociated();
            }
            $this->LoggableKeywordOrder->sortKeywords($this->keywords, $this->id);
        }
        return true;
    }

    function uniqueId($array) {
        if (env('HTTP_HOST') === parse_url($array['referrer'], PHP_URL_HOST)) {
            return 0;
        } else {
            return parent::uniqueId($array);
        }
    }

}
