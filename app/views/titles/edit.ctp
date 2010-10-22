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
<div class="titles form">
<?php echo $form->create('Title');?>
	<fieldset>
 		<legend><?php echo sprintf(__('Edit %s',true),__('Title',true));?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('long_name',array('class'=>'required','label'=>__('Name',true),'error'=>array('notEmpty'=>__('This field cannot be left blank',true))));
	?>
	</fieldset>
 <?php 
        echo "&nbsp;";
        echo $form->button(__('Save', true),array('type'=>'submit'));
        echo "&nbsp;";
        echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s List',true),__('Titles',true))), array('controller' => 'titles', 'action' => 'index')));
        echo $form->end();
    ?>

</div>
