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
<div class="group2s view">
<h2><?php  __('Group');?></h2>
    <ul>
        <li><span class="viewtitle"><span class="viewtitle"><?php __('Name');?>:</span></span> <?php echo $group2['Group2']['name'];?></li>
        <li><span class="viewtitle"><?php __('Description');?>:</span> <?php echo $group2['Group2']['description']?></li>
    </ul>

    <fieldset>
        <legend><?php __('Group Members');?></legend>
            <div class="fieldset-inside">
                <?php 
                    if (empty($group2['User'])){
                        __('This group has not any member.');
                    }else{
                        echo '<ol>';
                            foreach ($group2['User'] as $u){ 
                                echo '<li>'.$u['name'].'</li>';
                            }
                        echo '</ol>';
                    }
                ?>
            </div>
    </fieldset>
</div>

