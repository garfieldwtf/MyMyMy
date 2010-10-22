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


//This is for task detail in other page
?>

<div class="contentsummary">
    <ul>
        <li><span class="viewtitle"><?php __('Task'); ?>: </span><?php echo $task['task_name']; ?></li>
        <li>
            <span class="viewtitle"><?php __('Priority'); ?>: </span>
            <?php 
                if($task['priority']==1){
                    echo __('High',true);
                }elseif($task['priority']==2){
                    echo __('Medium',true);
                }elseif($task['priority']==3){
                    echo __('Low',true);
                }; 
            ?>
        </li>
        <li><span class="viewtitle"><?php  __('Start Date'); ?>: </span><?php echo $task['start_date']; ?></li>
        <li><span class="viewtitle"><?php __('End Date') ?>: </span><?php echo $task['end_date']; ?></li>
        <?php if (!empty($task['task_desc'])){?>
             <li><span class="viewtitle"><?php  __('Description');?>:</span></li>
            <li><?php echo $task['task_desc']; ?></li>
        <?php } ?>
    </ul>
</div>
