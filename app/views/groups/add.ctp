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

<div class="groups form">
<?php 
$group_name=!empty($curgroup)?$curgroup['Group']['name']:'';
echo $form->create('Group',array('url'=>'/groups/add/'.$group_name));
?>
	<fieldset>
 		<legend><?php echo sprintf(__('Add %s',true), empty($curgroup)?__('Committee',true):__('Sub Committee',true));?></legend>
	<?php
		echo $form->input('group_name',array('label'=>__('Name',true),'class'=>'required','error'=>array(
            'isUnique'=>sprintf(__('This %s already exist' ,true),__('Name',true)),
            'notEmpty'=> __('This field cannot be left blank',true),
            'character'=>__('Number',true).', '.__('Alphabet',true).', '.__('Space',true).' '.__('And',true).' '.__('Underscore',true).' '.__('Only',true)
        )));
		echo $form->input('description');
        if($group_name!=''){
            echo $form->input('import',array('type'=>'checkbox','label'=>__('Copy all member into new sub committee',true)));
        }
	?>
	</fieldset>
    <?php 
        echo "&nbsp;";
        echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button'));
        echo "&nbsp;";
        echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),__('Mainpage',true)), array('controller' => 'groups', 'action' => 'mainpage')));
        echo $form->end();
    ?>
</div>

