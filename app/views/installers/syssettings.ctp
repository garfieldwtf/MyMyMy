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
<h2>Global Settings</h2>

<div class="settings form">
    Please fill in details below. All settings can be changed later.
    <?php echo $form->create(array('action'=>'syssettings')); ?>
    <fieldset>
        <legend>Administrator details</legend>
        <div class="fieldset-inside">
            <?php
                echo $form->input('name', array('size'=>'40','class'=>'required','value'=>'Administrator'));
                echo $form->input('username',array(
                    'value'=>'admin',
                    'class'=>'required'
                ));
                echo $form->input('password',array(
                    'class'=>'required',
                    'type'=>'password',
                    'value'=>'',
                ));
                echo '<span id="passchk_result"></span>';
                echo $form->input('password_confirm',array(
                    'class'=>'required',
                    'type'=>'password',
                    'label'=>__('Confirm password',true),
                ));
                echo $form->hidden('superuser',array('value'=>1));     
                echo $form->hidden('dontsend',array('value'=>1));     
                echo $form->input('email',array('size'=>'40','class'=>'required'));
            ?>
        </div>
    </fieldset>
    <?php echo $this->element('globalsetting');?>
    <p>&nbsp;</p>
    <?php
        if (count($syssettingset))
            echo $form->button('Submit',array('type'=>'submit','class'=>'button'));
        else 
            echo $form->button('Next',array('type'=>'button','onclick'=>'parent.location="success"','class'=>'button'));
        echo $form->end();
    ?>
</div>


