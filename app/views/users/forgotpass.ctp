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
<h2><?php __('Forgot your password?')?></h2>
<?php echo $form->create('User',array('action'=>'forgotpass'));?>
<fieldset>
    <legend><?php __('Password reset');?></legend>
    <div class="fieldset-inside">
    <span class="note"><?php __("Please fill in your email address to reset your password")?></span>
    <?php
    echo $form->input('email', array('label'=>__('Email',true),'size'=>'40','maxlength'=>'255'));
    ?>
    </div>
</fieldset>
    <?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
    <?php //echo $form->button(__('Cancel', true),array('type'=>'submit','controller'=>'user','action'=>'login'),array('class'=>'button'));?>
    <?php echo $html->link(__('Cancel',true),array('controller'=>'user','action'=>'login'),array('class'=>'button'));?>
    <?php //echo $form->button('Cancel', array('onclick' => 'window.close(); return false;')); ?>

    <?php echo $form->end();?>
</div>
