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
<div class="settings form">
<h2><?php __('Change System Logo');?></h2>
<?php echo $form->create('Systems', array('action'=>'logo','type'=>'file'));?>
    <fieldset>
        <legend><?php __('Change System Logo');?></legend>
         <div class="fieldset-inside">
        <?php
        
        echo $form->label(__('Current logo', true)) . '<br />';
        echo $html->image($img_path);
        echo $html->div('', $form->input('Image.upload_logo', array('type'=>'file','label'=>__('Logo to upload',true))));
        
        __('Suitable logo size to upload is 155x80 px');
        ?>  
        
        </div>
    </fieldset>
    <br/>
<?php echo $form->button(__('Save',true), array('type'=>'submit','class'=>'button'));?>&nbsp;
<?php echo $form->button(__('Cancel',true), array('type'=>'button', 'onclick'=>'history.go(-1)','class'=>'button'));?>
<?php echo $form->end();?>
</div>
