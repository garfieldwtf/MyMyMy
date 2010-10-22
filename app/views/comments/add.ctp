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

<div class="comments form">
    <?php echo $this->element('taskdetail',array('task'=>$task['Task'])); ?>
    
    <?php echo $form->create('Comment',array('url'=>'/comments/add/'.$curgroup['Group']['name'].'/'.$model.'/'.$id.'/task_id:'.$this->params['named']['task_id']));?>
	<fieldset>
 		<legend><?php echo sprintf(__('Add %s',true),__('Comment',true));;?></legend>
	<?php
		echo $form->hidden('model',array('value'=>$model));
		echo $form->hidden('foreign_key',array('value'=>$id));
		echo $form->input('description',array('label'=>false));
		echo $form->hidden('user_id',array('value'=>$curuser['User']['id']));
        echo $form->input('group2_id',array('label'=>__('By',true),'type'=>'select','options'=>$impl));
        
	?>
	</fieldset>
    <?php 
        echo "&nbsp;";
        echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button'));
        echo "&nbsp;";
        echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s View',true),__('Task',true))), array('controller' => 'tasks', 'action' => 'view',$curgroup['Group']['name'],'task_id'=>$id)));
        echo $form->end();
    ?>
</div>
