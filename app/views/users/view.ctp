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
<div class="users view">
    <h2><?php  echo __('User',true);?></h2>
    <?php echo $this->element('Userdetail',array('user'=>$user));?>

<fieldset>
        <legend><?php __('Committees');?></legend>
        <div class="fieldset-inside">
            <?php if (empty($user['Group'])){
                __('This user has not been registered with any committee.');
            }else{?>
                <table width='90%'>
                    <thead><tr>
                        <th><?php __('Committee Involved') ?></th>
                        <th><?php __('Head') ?></th>
                        <th><?php __('Admin') ?></th>
                    </tr></thead>
                    <?php foreach ($user['Group'] as $g){ ?>
                        <?php if(!empty($g['Group']['name'])){ ?>
                            <tr>
                                <td><?php echo $g['Group']['name']; ?></td>
                                <td><?php if($g['Membership']['head']){echo '<center>'.$html->image('icons/yes.png').'</center>';} ?></td>
                                <td><?php if($g['Membership']['admin']){echo '<center>'.$html->image('icons/yes.png').'</center>';}?></td>
                            </tr>
                        <?php }?>
                    <?php }?>
            </table>
            <?php }?>
        </div>
    </fieldset>
</div>
