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
<table width="100%">
    <tr>
        <td id="popup_title"> <?php __("Unlock member's account") ?></td>
    </tr>
    <tr>
        <td id="popup_content">
            <?php 
                echo $form->create('User',array('url'=>array('controller'=>'users','action'=>'unlock',$id,$group,$type)));
                echo $form->input('reset',array('type'=>'checkbox','label'=>__('Reset Password?',true)));
            ?>
            <div id="popup_panel">
                <?php
                    echo $form->button(__('Save', true),array('type'=>'submit','id'=>'ok'));
                    echo "&nbsp;";
                    echo $form->button(__('Cancel', true), array('type'=>'button', 'class'=>'close'));
                ?>
            </div>
            <?php echo $form->end();?>
        </td>
    </tr>
</table>
