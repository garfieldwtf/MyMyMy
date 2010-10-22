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
<div class="schemes form">
<?php echo $form->create('Scheme',array('url'=>array('action'=>'add','controller'=>'schemes'))); ?>
    <fieldset>
        <legend><?php echo sprintf(__('Add %s',true),__('Scheme',true));?></legend>
        <div class="fieldset-inside">
        <?php
        echo $form->input('name',array('class'=>'required','error'=>array('isUnique'=>sprintf(__('This %s already exist' ,true),__('Scheme',true)),,'notEmpty'=>__('This field cannot be left blank',true))));
        ?>
        </div>
    </fieldset>
<?php echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button'));?>&nbsp;
<?php echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s List',true),__('Schemes',true))), array('controller' => 'schemes', 'action' => 'index')));?>
<?php echo $form->end();?>
</div>
