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
    <div class ="menubackground">
        <?php //menubar
            $task_id=isset($this->data['Task']['id'])?$this->data['Task']['id']:null;
            echo $this->element('taskbar',array('task_id'=>$task_id));
            echo $form->button(__('Skip',true),array('class'=>'rightbutton','onclick'=>'parent.location=\'../../view/'.$curgroup['Group']['name'].'/task_id:'.$task_id.'\''));
        ?>
    </div>
    <br/>
    <br/>
    <center>
        <?php echo $form->create('Task',array('url'=>'/tasks/additional/'.$curgroup['Group']['name'].'/task_id:'.$task_id,'type'=>'file'));?>
        <fieldset>
            <?php
                echo $form->input('task_desc',array('label'=>__('Description',true)));
                echo $multiFile->input('task',array('label'=>__('Task File',true)));
                echo $form->input('ref_no',array('label'=>__('Reference Number',true)));
                echo $multiItem->input('meeting',array('option'=>$meetings,'add'=>true,'selected'=>$meeting_sel));
                echo $multiItem->input('client',array('option'=>$clients,'add'=>true,'selected'=>$client_sel));
                echo $multiItem->input('category',array('option'=>$categories,'add'=>true,'selected'=>$category_sel));
                echo $multiItem->input('project',array('option'=>$projects,'add'=>true,'selected'=>$project_sel));
            ?>
        </fieldset>
        <?php echo $form->button(__('Save',true),array('type'=>'submit'));?>
        <?php echo $form->button(__('Skip',true),array('onclick'=>'parent.location=\'../../view/'.$curgroup['Group']['name'].'/task_id:'.$task_id.'\'')); ?>
        <?php echo $form->end();?>
    </center>
</div>

