<?php
class LoggableAppController extends AppController {

    var $helpers = array('Ajax');
    var $components = array('RequestHandler', 'Session', 'Security');

    function beforeFilter() {
        if (isset($this->Loggable)) {
            $this->Loggable->enabled = false;
        }
        parent::beforeFilter();
        $this->Security->enabled = false;
        if ($this->params['controller'] !== 'logable' || $this->action !== 'logs') {
            if (!$this->Session->check('Loggable.startDate')) {
                $this->Session->write('Loggable.startDate', time() - (DAY * 30));
            }
            if (!$this->Session->check('Loggable.endDate')) {
                $this->Session->write('Loggable.endDate', time());
            }
            if (isset($this->data['Date'])) {
                $startDate = array_merge(array('day' => null, 'month' => null, 'year' => null), $this->data['Date']['startDate']);
                $endDate = array_merge(array('day' => null, 'month' => null, 'year' => null), $this->data['Date']['endDate']);
                unset($this->data['Date']);
                $endDate = (mktime(0, 0, 0, $endDate['month'], $endDate['day'], $endDate['year']) + DAY);
                if ($endDate > time()) {
                    $endDate = time();
                }
                $startDate = mktime(0, 0, 0, $startDate['month'], $startDate['day'], $startDate['year']);
                if ($startDate > $endDate) {
                    $startDate = $endDate;
                }
                $this->Session->write('Loggable.startDate', $startDate);
                $this->Session->write('Loggable.endDate', $endDate);
            }
            $this->conditions = array(
                'startDate' => date('Y-m-d H:i:s', $this->Session->read('Loggable.startDate')),
                'endDate' => date('Y-m-d H:i:s', $this->Session->read('Loggable.endDate'))
            );
        }
        if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
        }
    }

}
