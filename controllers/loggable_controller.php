<?php
class LoggableController extends LoggableAppController {

    var $name = 'Loggable';
    var $components = array('Cookie');
    var $uses = array('Loggable.LoggableLog');

    function logs() {
        foreach ($this->passedArgs as $key=>$val) {
            if (substr($key, 0, 2) === '64') {
                $this->passedArgs[substr($key, 2)] = base64_decode($val);
                unset($this->passedArgs[$key]);
            }
        }
        if (!isset($this->passedArgs['code']) || empty($this->passedArgs['code'])) {
            die();
        }
        $pass = array_merge(
            array(
                'lang' => null,
                'width' => null,
                'height' => null,
                'avwidth' => null,
                'avheight' => null,
                'colour' => null
            ), $this->passedArgs
        );
        $log = $this->LoggableLog->find('first', array(
            'conditions' => array(
                'code' => $pass['code'],
                'page_no' => $this->Session->read('Loggable.page'),
                'ip' => env('REMOTE_ADDR'),
                'created >' => date('Y-m-d H:i:s', strtotime('-1 min'))
            ),
            'fields' => 'id',
            'recursive' => -1
        ));
        if ($log !== false) {
            $this->LoggableLog->save(array(
                'LoggableLog' => array(
                    'id' => $log['LoggableLog']['id'],
                    'javascript' => 1,
                    'code' => '',
                    'language_id' => $this->LoggableLog->LoggableLanguage->uniqueId(array('language' => $pass['lang'])),
                    'screen_id' => $this->LoggableLog->LoggableScreen->uniqueId(array('width' => $pass['width'], 'height' => $pass['height'])),
                    'available_id' => $this->LoggableLog->LoggableAvailable->uniqueId(array('width' => $pass['avwidth'], 'height' => $pass['avheight'])),
                    'colour' => $pass['colour']
                )
            ));
        }
        die();
    }
}
