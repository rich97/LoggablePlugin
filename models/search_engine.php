<?php
class SearchEngine extends LoggableAppModel {
    var $name = 'SearchEngine';

    var $hasMany = array(
        'Referrer' => array(
            'className'     => 'Loggable.Referrer',
            'foreignKey'    => 'search_engine_id'
        )
    );

    function uniqueId($referrer) {
        $search = $this->getSearchEngine($referrer);
        if ($search === array()) {
            return array(
                'search_engine_id' => 0,
                'keywords' => null
            );
        }
        return array(
            'search_engine_id' => parent::uniqueId(array(
                'search_engine' => $search['search_engine']
            )),
            'keywords' => $search['keywords']
        );
    }

    function getSearchEngine($referrer) {
        $searchEngines = array(
            'Google Image' => array(
                'match' => 'images.google',
                'query' => array(
                    'p',
                    'q'
                )
            ),
            'Google' => array(
                'match' => 'google',
                'query' => array(
                    'p',
                    'q'
                )
            ),
            'Bing' => array(
                'match' => 'bing',
                'query' => 'q'
            ),
            'Voila' => array(
                'match' => 'voila',
                'query' => 'kw'
            ),
            'Yahoo' => array(
                'match' => 'yahoo',
                'query' => 'p'
            ),
            'Lycos' => array(
                'match' => 'lycos',
                'query' => 'query'
            ),
            'Alexa' => array(
                'match' => 'alexa',
                'query' => 'q'
            ),
            'All The Web' => array(
                'match' => 'alltheweb',
                'query' => array(
                    'query',
                    'q'
                )
            ),
            'Altavista' => array(
                'match' => 'altavista',
                'query' => 'q'
            ),
            'DMOZ' => array(
                'match' => 'dmoz',
                'query' => 'search'
            ),
            'Netscape' => array(
                'match' => 'netscape',
                'query' => 'search'
            ),
            'Terra' => array(
                'match' => 'search.terra',
                'query' => 'query'
            ),
            'Search' => array(
                'match' => 'search',
                'query' => 'q'
            ),
            'AOL' => array(
                'match' => 'search.aol',
                'query' => 'query'
            ),
            'Excite' => array(
                'match' => 'excite',
                'query' => 'search'
            ),
            'Ask' => array(
                'match' => 'ask',
                'query' => 'q'
            ),
            'Yandex' => array(
                'match' => 'yandex',
                'query' => 'text'
            ),
            'Baidu' => array(
                'match' => 'baidu',
                'query' => 'wd'
            )
        );
        foreach ($searchEngines as $return => $engine) {
            if (is_string($engine['query'])) {
                $query = $engine['query'];
            } else {
                $query = implode('|', $engine['query']);
            }
            if (preg_match('#^http://(www\.)?' . preg_quote($engine['match']) .
                '\..*(\?|&)(' . $query . ')=(.*?)(&|$)#i', $referrer, $match)) {
                return array('search_engine' => $return, 'keywords' => $match[4]);
            }
        }
        return array();
    }

}
