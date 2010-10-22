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
<div class="schema view">
<?php 
    if($type=='User'){
        echo $curLink->add($html->link(sprintf(__('New %s', true),__('User', true)), array('controller'=>'users','action' => 'add',$curgroup['Group']['name'])));
    }else{
        echo $curLink->add($html->link(sprintf(__('New %s', true),__('Group', true)), array('controller'=>'group2s','action' => 'add',$curgroup['Group']['name'])));
    } ?>
<?php echo $form->create('Membership',array('url'=>'/memberships/add/'.$curgroup['Group']['name'].'/'.$type.'/'.$this->data['Membership']['id']));?>
	<fieldset>
 		
	<?php
        if($type=='Group2'){
            echo "<legend>".sprintf(__('Add Existing %s', true),__('Group', true))."</legend>";
            echo $form->input('foreign_key',array('options'=>$users,'label'=>__('Group',true)));
            echo $form->input('head');
        }else{
            echo "<legend>".sprintf(__('Add Existing %s', true),__('User', true))."</legend>";
            echo $form->input('foreign_key',array('options'=>$users,'label'=>__('User',true)));
            echo $form->input('head');
            echo $form->input('admin');
        }
	?>
	</fieldset>
    <?php 
        echo "&nbsp;";
        echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button'));
        echo "&nbsp;";
        echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('List', true))), array('controller' => 'memberships', 'action' => 'index',$curgroup['Group']['name'],$type)));
        echo $form->end();
    ?>
</div>
