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
 
echo $javascript->link('passchk.js');
?>
<h2><?php __('Change password')?></h2>

<?php echo $form->create(array('action'=>"changepassword"));?>
<fieldset>
<legend><?php __('Change password');?></legend>
<div class="fieldset-inside">
    <div class="input text">
    <label for="oldpassword"><?php __('Old Password');?></label>
    <?php echo $form->password('oldpassword'); ?> 
    </div>

    <div class="input text">
    <label for="newpassword"><?php __('New Password');?></label>
    <?php echo $form->password('newpassword', array('class'=>'required')); ?>  
    </div>
    <span id="passchk_result"></span>
    <div class="input text">
    <label for="confirmpassword"><?php __('Confirm Password');?></label>
    <?php echo $form->password('confirmpassword', array('class'=>'required')); ?> 
    </div>
</div>
</fieldset>
<br/>
<?php echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button','class'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
