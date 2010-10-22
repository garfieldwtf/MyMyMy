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
<div class="tasks view2">
    <h2><?php  __('Task');?></h2>
    <?php 
    $task_id=isset($this->data['Task']['id'])?$this->data['Task']['id']:null;
    if(!empty($task_id)){ 
    ?>
        <div class ="menubackground">
            <?php //menubar
                echo $this->element('taskbar',array('task_id'=>$task_id));
                echo $form->button(__('Skip',true),array('class'=>'rightbutton','onclick'=>'parent.location=\'../../imp/'.$curgroup['Group']['name'].'/task_id:'.$task_id.'\''));
            ?>
        </div>
        <br/>
    <?php } ?>
    <br/>
    <?php echo $form->create('Task',array('url'=>'/tasks/basic/'.$curgroup['Group']['name'].'/task_id:'.$task_id));?>
	<fieldset>
        <legend><?php __('Register Task');?></legend>
        <?php
        //required
        echo $form->input('task_name',array('error'=>array('notEmpty'=>__('This field cannot be left blank',true))));
        echo $form->hidden('group_id',array('value'=>$curgroup['Group']['id']));
        echo $form->input('priority',array('type'=>'select','options'=>array('1'=>__('High',true),'2'=>__('Medium',true),'3'=>__('Low',true)),'class'=>'required','error'=>array('notEmpty'=>__('This field cannot be left blank',true)),'empty'=>__('Please select',true)));
		echo $datePicker->picker('start_date',array('showstime'=>true,'class'=>'required','value'=>!isset($task_id)?date('Y-m-d H:i'):date('Y-m-d H:i',strtotime($this->data['Task']['start_date'])),'error'=>array('notEmpty'=>__('This field cannot be left blank',true))));
		echo $datePicker->picker('end_date',array('showstime'=>true,'class'=>'required','value'=>!isset($task_id)?date('Y-m-d H:i'):date('Y-m-d H:i',strtotime($this->data['Task']['end_date'])),'error'=>array('notEmpty'=>__('This field cannot be left blank',true))));
        ?>
    </fieldset>
<?php echo $form->button(__('Save',true),array('type'=>'submit','class'=>'button'));?>
<?php if(!empty($task_id)){ echo $form->button(__('Skip',true),array('onclick'=>'parent.location=\'../../imp/'.$curgroup['Group']['name'].'/task_id:'.$task_id.'\'','class'=>'button')); }?>
<?php echo "&nbsp;";?>
<?php echo $form->end();?>
</div>

