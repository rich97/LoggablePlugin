<?php
class LogHelper extends AppHelper {

    var $helpers = array('Javascript', 'Session', 'Html');

    function logging() {
        if ($this->Session->check('Loggable.code')) {
            $out = '<div id="loggable" style="display: none;">';
            $out .= $this->Javascript->codeBlock('var LogCode = "' . $this->Session->read('Log.code') .
                '";var LogUrl = "' .
                $this->Html->url(array('plugin' => 'loggable', 'controller' => 'logs', 'action' => 'js')) . '";');
            $out .= $this->Javascript->link('/loggable/js/logging.js');
            $out .= '</div>';
            return $this->output($out);
        } else {
            return $this->output('');
        }
    }

}
