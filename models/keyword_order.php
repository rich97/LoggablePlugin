<?php
class KeywordOrder extends LoggableAppModel {
    var $name = 'KeywordOrder';

    var $belongsTo = array(
        'Keyword' => array(
            'className'     => 'Loggable.Keyword',
            'foreignKey'    => 'keyword_id'
        ),
        'Referrer' => array(
            'className'     => 'Loggable.Referrer',
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
                'KeywordOrder' => array(
                    'referrer_id' => $id,
                    'keyword_id' => $this->Keyword->uniqueId(array('keyword' => $keyword)),
                    'order' => ($key + 1)
                )
            ));
        }
    }

}
