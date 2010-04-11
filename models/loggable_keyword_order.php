<?php
class LoggableKeywordOrder extends LoggableAppModel {
    var $name = 'LoggableKeywordOrder';

    var $belongsTo = array(
        'LoggableKeyword' => array(
            'className'     => 'Loggable.LoggableKeyword',
            'foreignKey'    => 'keyword_id'
        ),
        'LoggableReferrer' => array(
            'className'     => 'Loggable.LoggableReferrer',
            'foreignKey'    => 'referrer_id'
        )
    );

    function sortKeywords($keywords, $id) {
        $keywords = str_replace("+", " ", $keywords);
        $keywords = urldecode($keywords);
        $keywords = explode(" ", $keywords);
        foreach ($keywords as $key => $keyword) {
            $this->create();
            $this->save(array(
                'LoggableKeywordOrder' => array(
                    'referrer_id' => $id,
                    'keyword_id' => $this->LoggableKeyword->uniqueId(array('keyword' => $keyword)),
                    'order' => ($key + 1)
                )
            ));
        }
    }

}
