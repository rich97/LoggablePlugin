<?php
class LoggableHelper extends AppHelper {

    var $helpers = array('Javascript', 'Session');

    function loggable() {
        if ($this->Session->check('Loggable.code')) {
            $out = '<div id="loggable" style="display: none;">';
            $out .= $this->Javascript->codeBlock('var LogCode = "' . $this->Session->read('Loggable.code') .
                '";var LogUrl = "' .
                Router::url(array('plugin' => 'loggable', 'controller' => 'loggable', 'action' => 'logs'), true) . '";');
            $out .= $this->Javascript->link('/loggable/js/loggable.js');
            $out .= '</div>';
            return $this->output($out);
        } else {
            return $this->output('');
        }
    }

}
