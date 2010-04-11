<?php
class LoggableAppModel extends AppModel{

    var $actsAs = array('Containable');

    function uniqueId($cond = array(), $return = 0) {
        if ($cond === array()) {
            return $return;
        } else {
            foreach ($cond as $value) {
                if ($value === null) {
                    return $return;
                }
            }
        }
        $find = $this->find('first', array('conditions' => $cond, 'fields' => 'id', 'recursive' => -1));
        if ($find !== false) {
            return $find[$this->alias]['id'];
        } else {
            $this->create();
            $this->save(array($this->alias => $cond));
            return $this->id;
        }
    }
}
