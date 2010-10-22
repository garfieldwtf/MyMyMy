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
 <div class="users form">
<?php echo $html->link(__('Change Password', true),array('controller'=>'users','action'=>'changepassword'),array('class'=>'button rightbutton'))?>
<h2><?php __('Edit Profile');?>: <?php echo $curuser['User']['username']?></h2>


<?php echo $form->create('User',array('action'=>'profile'));?>
<fieldset>
<legend><?php __('Edit Profile');?></legend>
<div class="fieldset-inside">
<span class="note"><?php __('Changes here will take effect after you login next time.')?></span>
<?php
    echo $form->input('id');      
    echo $form->input('title_id',array('type' => 'select', 'empty' => '--'.__('Please select',true).'--'));
    echo $form->input('name', array('size'=>'40','class'=>'required','error'=>array(
        'notEmpty'=>__('This field cannot be left blank',true),
    )));
    echo $form->input('job_title', array('size'=>'40', 'label'=>__('Post',true)));
    echo $form->input('bahagian', array('size'=>'40','label'=>__('Section/Division',true)));
    
    //grade
    echo "<table><tr><td>";
    echo $form->label(__('Grade',true));
    echo "</td><td>";
    echo $form->input('scheme_id',array('class'=>'grade','label'=>false,'empty'=>'--'.__('Please select',true).'--'));
    echo "</td><td>";
    echo $form->input('grade_id',array('class'=>'grade','label'=>false,'empty'=>'--'.__('Please select',true).'--'));
    echo "</td></tr></table>";
    
    echo $form->input('email',array(
        'class'=>'required',
        'error'=>array(
            'format'=>__('Invalid email format',true),
            'email Unique'=>sprintf(__('This %s already exist' ,true),__('Email',true)),
        )
    ));
    echo $form->input('address', array('rows'=>'4','cols'=>'6'));
    echo $form->input('telephone', array('error'=>array(
        'format'=>__('Please supply valid telephone number eg: 03-6667777',true),
        )));
    echo $form->input('fax', array('error'=>array(
        'format'=>__('Please supply valid fax number eg: 03-6667777',true),
        )));
    echo $form->input('mobile', array('error'=>array(
        'format'=>__('Please supply valid mobile number eg: 012-3456789',true),
        )));
?>
</div>
</fieldset>
<?php echo $form->button(__('Save', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
