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
<div class="reminders form">
<?php echo $this->element('taskdetail',array('task'=>$task['Task'])); ?>
<?php echo $form->create('Reminder',array('url'=>'/reminders/add/'.$curgroup['Group']['name'].'/task_id:'.$task_id));?>
	<fieldset>
 		<legend><?php echo sprintf(__('Add %s',true),__('Reminder',true));?></legend>
	<?php
		echo $form->hidden('task_id',array('value'=>$task_id));
		echo $form->hidden('user_id',array('value'=>$curuser['User']['id']));
		echo $form->input('note',array('value'=>isset($old)?$old['note']:null));
		echo $datePicker->picker('remind_date',array('showstime'=>true,'class'=>'required','value'=>isset($old)?$old['remind_date']:null,'error'=>__('This field cannot be left blank',true)));
        echo $form->select('before',array('1','2','3','4','5'),array('label'=>__('Send before'),'value'=>isset($old)?$old['before']:null)).__('day',true);
        echo $form->input('repeated',array('label'=>__(' Repeat everyday',true),'checked'=>!empty($old['repeated'])?1:0));
        echo '<br/>';
		echo $form->input('active',array('label'=>__(' Activate the notification',true),'checked'=>(isset($old['active']) && empty($old['active']))?false:1));
	?>
	</fieldset>
    <?php 
        echo "&nbsp;";
        echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button'));
        echo "&nbsp;";
        echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s View',true),__('Task',true))), array('controller' => 'tasks', 'action' => 'view',$curgroup['Group']['name'],'task_id'=>$task_id)));
        echo $form->end();
    ?>
</div>

