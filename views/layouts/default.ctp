<?php
echo $html->docType();
?>
<html>
    <head>
<?php
echo "        " , $html->css(array('/loggable/css/general', '/loggable/css/reset')) , "\r\n";
echo "        " , $javascript->link('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js') , "\r\n";
echo "        " , $javascript->link('/loggable/js/scripts') , "\r\n";
echo $scripts_for_layout;
?>
    </head>
    <body>
        <div id="header" style="width: 100%; height: 150px; display: block;">
            <div id="headerimg" style="height: 140px; position: relative; float:left;">
                <?php echo $html->link($html->image('/log/img/header.png'), 'http://thatcode.com', array('escape' => false)); ?>
            </div>
            <div id="headertext" style="position: relative; margin-left: 450px"><h1 style="margin-left: auto; margin-right: auto; font-size: 50px; color: #008fb1; font-family: Georgia, serif; font-weight: normal;">Site Statistics for CakePHP applications</h1></div>
            <div style="clear: both;"></div>
            <div id="headerfooter" style="width: 100%; bottom: 0; height: 10px; background: #0086AC"></div>
        </div>
        <div id="wrapper" style="position: relative; overflow: hidden; width: 100%; min-width: 750px;">
            <div id="sidebar" style="position: relative; overflow: hidden; float:left; width: 20%; min-width: 150px;">
                <div id="navigation" style="width: 100%; margin: 5px;">
                    <ul>
                        <li><?php echo $html->link('Main Site Home', '/'); ?></li>
                        <li><?php echo $html->link('Logging Home', array('plugin' => 'loggable', 'controller' => 'logs', 'action' => 'index'), array('update' => 'content')); ?></li>
                        <li><?php echo $html->link('Recent Page Views', array('plugin' => 'loggable', 'controller' => 'logs', 'action' => 'recent'), array('update' => 'content')); ?></li>
                    </ul>
                </div>
                <div id="dates" style="margin: 5px"><?php echo $this->element('dates'); ?></div>
                <div id="thanks" style="margin: 5px"><?php echo $this->element('thanks'); ?></div>
            </div>
            <div id="content" style="position: relative; overflow: hidden; float: left; width: 80%; min-width: 600px;">
                <?php
                echo $content_for_layout;
                ?>
            </div>
        </div>
<?php echo $this->element('sql_dump'); ?>
    </body>
</html>
