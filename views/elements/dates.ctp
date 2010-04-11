<?php
echo $form->create(null, array('action' => $this->action, 'id' => 'DateForm'));
echo $form->input('Date.startDate', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => $session->read('Log.startDate'), 'minYear' => (date('Y') - 10), 'maxYear' => date('Y'), 'empty' => false, 'label' => 'Start Date'));
echo $form->input('Date.endDate', array('type' => 'date', 'dateFormat' => 'DMY', 'selected' => $session->read('Log.endDate'), 'minYear' => (date('Y') - 10), 'maxYear' => date('Y'), 'empty' => false, 'label' => 'End Date'));
echo $ajax->submit('Change Dates', array('url' => array('action' => $this->action), 'update' => 'content'));
?>
