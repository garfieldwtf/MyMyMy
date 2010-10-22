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
        <td id="popup_title"> <?php __('Export iCal') ?></td>
    </tr>
    <tr>
        <td id="popup_content">
           <?php
                __('Please use the following address to access this calendar from other applications. You can copy and paste this into any calendar product that supports the iCal format.');
                echo '<br/>';
                $ical_link = Configure::read('server_url').$html->url(array('controller'=>'users','action'=>'cal',$curuser['User']['id']));
                echo $html->link($ical_link,array('controller'=>'users','action'=>'cal',$curuser['User']['id']));
            ?>
            
            <div id="popup_panel">
                <?php
                    echo $form->button(__('Cancel', true), array('type'=>'button', 'class'=>'close button'));
                ?>
            </div>
            
        </td>
    </tr>
</table>
