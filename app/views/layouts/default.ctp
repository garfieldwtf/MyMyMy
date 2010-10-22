<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Task Manager 2.0 :: <?php echo $title_for_layout?></title>
<?php echo $html->charset('UTF-8')?>
<meta name="description" content="Website description" />
<meta name="keywords" content="keyword1,keyword2,keyword2,keyword4" />
<?php 
    echo $html->css('cake.forms', 'stylesheet', array("media"=>"all" ));
     //if(strpos($_SERVER['HTTP_USER_AGENT'],'IE')){
        //$IE=1;
    //}
    echo $html->css('tm');

    if($this->params['action']!='login' && $this->params['action'] != 'forgotpass' && $this->params['action'] != 'forgotuser') { 
        echo $html->charset("UTF-8");
        echo $javascript->link('scriptaculous/lib/prototype');
        echo $javascript->link('scriptaculous/src/scriptaculous');
        echo $javascript->link('jquery-1.4.2.min');
    }
    echo $scripts_for_layout;
?>                    
</head>
<body>
    <div id="container">
        <table cellpadding="0" cellspacing="0" class="maintable">
            <tr>
                <td class="left">&nbsp;</td>                
                <td class="middle" width="100%">
                    <div id="header">
                        <?php echo $html->image($img_path, array('class'=>'floatright')); ?>
                        <p>&nbsp;</p>
                        <h1>
                            <?php echo $html->link(Configure::read('agency_name'),array("controller"=>"groups","action"=>"mainpage")) ?>
                        </h1>
                    </div>
                    <?php 
                    if($this->params['action']!='login'){
                        if(!in_array($this->params['action'],array('forgotpass','forgotuser','fixup','browser'))  ) { 
                            echo $this->element('topcontent');
                        }
                        if ($session->check('Message.flash')) $session->flash();
                        if(!empty($curgroup) && $this->params['controller']=='tasks'){
                            echo $this->element('menubar');
                        }
 	                    echo $this->element('maincontent');
                        echo $content_for_layout;	
                        echo $this->element('endcontent');   
                    }else {
                        if ($session->check('Message.flash')) $session->flash();
                        echo $content_for_layout;
                    }
                    ?>                  
                    <div id="footer">
                        <?php __('Powered by TaskManager')?>
                        <br/>
                        <?php __('Recomended using firefox3.5, Chrome6.0 and above.')?>
                    </div>
                </td>
                <td class="right">&nbsp;</td>
            </tr>
            <tr>
                <td class="bottomleft">&nbsp;</td>
                <td class="bottom">
                    <div class="bright">&nbsp;</div>
                    <div class="bleft">&nbsp;</div>
                </td>
                <td class="bottomright">&nbsp;</td>
            </tr>
        </table>
    </div>
</body>
</html>
