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
<div class="templates form">
<?php 
if(!empty($group_name)){
    echo $form->create('Template',array('url'=>'/templates/edit/'.$id.'/'.$group_name));
}else{
    echo $form->create('Template');
}?>
	<fieldset>
 		<legend><?php echo sprintf(__('Edit %s',true),__('Template',true));?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('title');
        echo $this->element('tinymce',array('preset'=>'basic'));
		echo $form->input('description');
		echo $form->input('template');
	?>
	</fieldset>
 <?php 
        echo "&nbsp;";
        echo $form->button(__('Save', true),array('type'=>'submit'));
        echo "&nbsp;";
        echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));
        echo $form->end();
    ?>

</div>
