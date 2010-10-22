<?php
/* Task Manager is a web-based system for effective management of task delegation,
 * assignment and follow-up monitoring.
 * Copyright (C) 2010 Government Of Malaysia
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @author: Teow Jit Huan
 */
?>

<p class='contentmenu'>
    <?php echo $html->link(__("Reload settings",true),array('controller'=>'systems','action'=>'setting'),array('class'=>'button rightbutton')); ?> 
</p>
<div class="settings form">
<h2><?php echo sprintf(__('Edit %s',true),__('Global Settings',true));?></h2>
<?php echo $form->create('Systems', array('action'=>'setting'));?>
   
    <?php
        
        // for translation
        __('Agency Address',true);
        __('Agency Name',true);
        __('Agency Slogan',true);
        __('Email Method',true);
        __('SMTP Host',true);
        __('SMTP Port',true);
        __('SMTP Username',true);
        __('SMTP Password',true);
        __('Sendmail Path',true);
        __('Locked Period',true);
        
        echo $this->element('globalsetting');
        
    ?>

<?php echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)','class'=>'button'));?>
<?php echo $form->end();?>
</div>
