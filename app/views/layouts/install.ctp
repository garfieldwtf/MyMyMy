<?php
/* SVN FILE: $Id: default.ctp 6311 2008-01-02 06:33:52Z phpnut $ */
/**
*
* PHP versions 4 and 5
*
* CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
* Copyright 2005-2008, Cake Software Foundation, Inc.
*                                1785 E. Sahara Avenue, Suite 490-204
*                                Las Vegas, Nevada 89104
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @filesource
* @copyright        Copyright 2005-2008, Cake Software Foundation, Inc.
* @link                http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
* @package            cake
* @subpackage        cake.cake.libs.view.templates.layouts
* @since            CakePHP(tm) v 0.10.0.1076
* @version            $Revision: 6311 $
* @modifiedby        $LastChangedBy: phpnut $
* @lastmodified    $Date: 2008-01-02 14:33:52 +0800 (Wed, 02 Jan 2008) $
* @license            http://www.opensource.org/licenses/mit-license.php The MIT License
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Task Manager |
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $html->charset();
        echo $html->meta('icon');
        echo $html->css('tm');
        echo $scripts_for_layout;
        ?>
        <!--[if IE]>
            <?php echo $html->css('ie'); ?>
        <![endif]-->
    </head>

    <body>
        <div id="container">
            <table border="0" cellpadding="0" cellspacing="0" class="maintable">
            <tr>
                <td class="left">&nbsp;</td>
                <td class="middle" width="100%">
                    <div id="header">
                        <?php //echo $html->image($img_path, array('class'=>'floatright')); ?>
                    </div>
                    
                    <div id="top">
                    
                    </div>

                    <div id="content">
                        <div id="middle">
                            <h1>TaskManager Installer</h1>
                            <?php echo $this->element('install_steps',array('step'=>$this->params['action']))?>
                            <br/>
                            <?php if ($session->check('Message.flash')) $session->flash(); ?>
                            <?php echo $content_for_layout; ?>
                        </div>
                    </div>

                    <div id="footer">
                        <?php __('Powered by TaskManager')?>
                        &nbsp;
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
