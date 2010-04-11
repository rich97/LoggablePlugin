<?php $paginator->options(array('update' => 'content')); echo $paginator->counter(), '&nbsp;', $paginator->prev(), '&nbsp;' , $paginator->next() , '&nbsp;' , $paginator->sort('Time', 'Log.created') , '&nbsp;' , $paginator->sort('Host', 'Host.host') , '&nbsp;' , $paginator->sort('Url', 'Url.url') , '&nbsp;' , $paginator->sort('IP', 'Log.ip'), '&nbsp;' , $ajax->link('Clear', array('plugin' => 'log', 'controller' => 'logs', 'action' => 'recent'), array('update' => 'content')); ?>
<?php foreach ($views as $key => $view) { ?>
<div style="text-align: center;">
<table style="width: 100%">
    <thead>
        <tr>
            <th>Time</th>
            <th>Url</th>
            <th>Page number</th>
            <th>IP</th>
<?php if ($view['Log']['page_no'] === '1') { ?>
            <th>Type</th>
<?php } ?>
<?php if ($view['Log']['user_id']) { ?>
            <th>Type</th>
<?php } ?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $view['Log']['created']; ?></td>
            <td><?php echo $view['Host']['host'] . $view['Url']['url']; ?></td>
            <td><?php echo $view['Log']['page_no']; ?></td>
            <td><?php echo $view['Log']['ip']; ?></td>
<?php if ($view['Log']['page_no'] === '1') { ?>
            <td><?php
if ($view['Log']['returning']) {
    echo 'Returning';
} else {
    echo 'New';
}
?></td>
<?php } ?>
<?php if ($view['Log']['user_id']) { ?>
            <td>Username</td>
<?php } ?>
            <td onclick="document.getElementById('view<?php echo $key; ?>').toggle();">More info</td>
        </tr>
    </tbody>
</table>
<div id="view<?php echo $key; ?>" style="display: none;">
<table style="width: 100%">
    <thead>
        <tr>
            <th>Javascript</th>
            <th>Referrer</th>
            <th>Useragent</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php
if ($view['Log']['javascript']) {
    echo $ajax->link('Yes', array('plugin' => 'log', 'controller' => 'logs', 'action' => 'recent', 'javascript', 1), array('update' => 'content'));
} else {
    echo $ajax->link('No', array('plugin' => 'log', 'controller' => 'logs', 'action' => 'recent', 'javascript', 0), array('update' => 'content'));
}
?></td>
            <td><?php echo $view['Referrer']['referrer']; ?></td>
            <td><?php echo $view['UserAgent']['user_agent']; ?></td>
        </tr>
    </tbody>
</table>
<table style="width: 100%">
    <thead>
        <tr>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Continent</th>
            <th>Country</th>
            <th>City</th>
            <th>Region</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $view['Log']['latitude']; ?></td>
            <td><?php echo $view['Log']['longitude']; ?></td>
            <td><?php echo $view['Continent']['continent']; ?></td>
            <td><?php echo $view['Country']['country']; ?></td>
            <td><?php echo $view['City']['city']; ?></td>
            <td><?php echo $view['Region']['region']; ?></td>
        </tr>
    </tbody>
</table>
<?php if ($view['Log']['javascript']) { ?>
<table style="width: 100%">
    <thead>
        <tr>
            <th>Browser</th>
            <th>Operating System</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $view['Browser']['browser']; ?>: <?php  echo $view['Browser']['version']; ?></td>
            <td><?php echo $view['OperatingSystem']['operating_system']; ?>: <?php  echo $view['OperatingSystem']['version']; ?></td>
        </tr>
    </tbody>
</table>
<?php } ?>
</div>
</div>
<?php } ?>
