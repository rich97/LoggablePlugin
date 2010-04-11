<?php
class Referrer extends LoggableAppModel {

    var $name = 'Referrer';
    var $validate = array(
        'referrer' => array(
            'rule' => 'isUnique'
        )
    );

    var $belongsTo = array(
        'SearchEngine' => array(
            'className' => 'Loggable.SearchEngine',
            'foreignKey' => 'search_engine_id'
        )
    );
    var $hasMany = array(
        'Log' => array(
            'className' => 'Loggable.Log',
            'foreignKey' => 'referrer_id'
        ),
        'KeywordOrder' => array(
            'className' => 'Loggable.KeywordOrder',
            'foreignKey' => 'referrer_id'
        )
    );

    function beforeSave() {
        if (!isset($this->SearchEngine)) {
            $this->getAssociated();
        }
        if (isset($this->data['Referrer']['referrer'])) {
            $tmp = $this->SearchEngine->uniqueId($this->data['Referrer']['referrer']);
            $this->data['Referrer']['search_engine_id'] = $tmp['search_engine_id'];
            $this->keywords = $tmp['keywords'];
        }
        return true;
    }

    function afterSave($created) {
        if ($created && $this->keywords !== null) {
            if (!isset($this->KeywordOrder->Keyword)) {
                $this->getAssociated();
                $this->KeywordOrder->getAssociated();
            }
            $this->KeywordOrder->sortKeywords($this->keywords, $this->id);
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
