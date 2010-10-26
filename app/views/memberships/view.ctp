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
 
<div class="memberships view">
    <?php echo $this->element($type.'detail',array(strtolower($type)=>$member));?>
        
    <?php
        if($type=='Group2'){
            echo '<br/>';
            __('Group member');
            echo '<ol>';
            foreach($member['User'] as $u){
                echo '<li>';
                echo $u['name'];
                echo '</li>';
            }
            echo '</ol>';
        }
    ?>
    <fieldset>
        <legend><?php __('Committees');?></legend>
        <div class="fieldset-inside">
            <?php 
            if (!empty($Group)){
            ?>
                <table width='90%'>
                    <thead>
                        <tr>
                            <th><?php __('Committee Involved') ?></th>
                            <th><?php __('Head') ?></th>
                            <?php if($type=='User'){?>
                                <th><?php __('Admin') ?></th>
                            <?php } ?>
                            </tr>
                    </thead>
                    <?php foreach ($Group as $g){ ?>
                        <?php if(!empty($g['Group']['name'])){ ?>
                            <tr>
                                <td><?php echo $g['Group']['name']; ?></td>
                                <td><?php if($g['Membership']['head']){echo '<center>'.$html->image('icons/yes.png').'</center>';} ?></td>
                                <?php if($type=='User'){?>
                                    <td><?php if($g['Membership']['admin']){echo '<center>'.$html->image('icons/yes.png').'</center>';}?></td>
                                <?php } ?>
                            </tr>
                        <?php }?>
                    <?php }?>
            </table>
            <?php }?>
        </div>
    </fieldset>
    
     <?php echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),__('List',true)), array('controller' => 'memberships', 'action' => 'index',$curgroup['Group']['name'],$type))); ?>

</div>



