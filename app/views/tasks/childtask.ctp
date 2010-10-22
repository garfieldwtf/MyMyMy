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
    <h2><?php  __('Go to child task');?></h2>

    <?php echo $form->create('Task',array('url'=>'/tasks/childtask/'.$curgroup['Group']['name'].'/'.$task_id));?>
	<fieldset>
        <legend><?php __('Go to child task');?></legend>
        <?php
            echo $form->input('id',array('label'=>__('Please choose the desired committee',true),'options'=>$agroup));
        ?>
    </fieldset>
<?php echo $form->button(__('Go',true),array('type'=>'submit','class'=>'button'));?>
<?php echo "&nbsp;";?>
<?php echo $form->end();?>
</div>

