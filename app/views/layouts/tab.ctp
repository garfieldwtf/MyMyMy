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
                        echo $this->element('topcontent');
                        if ($session->check('Message.flash')) $session->flash();
                    ?>
                        
                    <div class="content">
                        <ul class="tabs">
                            <?php
                                if((in_array($this->params['controller'],array('users','group2s')) && !empty($curgroup))||$this->params['controller']=='memberships'){
                                    echo $curLink->li($html->link($curgroup['Group']['group_name'],array('controller'=>'tasks','action'=>'calendar',$curgroup['Group']['name'])),'calendar');
                                    echo $curLink->li($html->link(__('Members',true),array('controller'=>'memberships','action'=>'index',$curgroup['Group']['name'],'User')),'ser');
                                    echo $curLink->li($html->link(__('Groups',true),array('controller'=>'memberships','action'=>'index',$curgroup['Group']['name'],'Group2')),'roup2');
                                }elseif(in_array($this->params['controller'],array('grades','schemes'))){
                                    echo $curLink->li($html->link(__('Grades',true),array('controller'=>'grades')),'grades');
                                    echo $curLink->li($html->link(__('Job Schemes',true),array('controller'=>'schemes')),'schemes');
                                }elseif(in_array($this->params['controller'],array('users','group2s'))){
                                    echo $curLink->li($html->link(__('Users',true),array('controller'=>'users')),'users');
                                    echo $curLink->li($html->link(__('Groups',true),array('controller'=>'group2s')),'group2s');
                                }
                            ?>
                        </ul>
                        <div class="panes"><div class="gradeview"><?php  echo $content_for_layout;?></div ></div >
                    </div>              
                    <div id="footer">
                        <?php __('Powered by TaskManager')?>
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
