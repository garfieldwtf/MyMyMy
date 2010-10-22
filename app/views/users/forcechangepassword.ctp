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

echo $javascript->link('passchk.js',false);
?>
<h2><?php __("Change Password")?></h2>
<?php echo $form->create(array('action'=>"forcechangepassword"));?>
    <fieldset>
        <legend><?php __('Change Password');?></legend>
        <div class="fieldset-inside">
            <p class="instructions">
                <?php __("Please reset your password.")?> 
                <?php __("Password can not be the same as your username.")?>
            </p>

            <div class="input text">
                <label for="newpassword"><?php __('New Password');?></label>
                <?php echo $form->password('newpassword',array('class'=>'required')); ?> 
            </div>
            <span id="passchk_result"></span>
    
            <div class="input text">
                <label for="confirmpassword"><?php __('Confirm Password');?></label>
                <?php echo $form->password('confirmpassword', array('class'=>'required')); ?> 
            </div>
        </div>
    </fieldset>
    <?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
    <?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>


