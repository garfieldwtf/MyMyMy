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

if($this->action != 'forgotpass' && $this->action != 'forgotuser') { ?>
    <table cellpadding="0" cellspacing="0" class="adminview" border="0">
        <tr>
            <td rowspan="7">
                <div class="verticaltext">
                    <ul id="vertical">
                        <li>
                            <div class='vertical'><?php __('C o n t r o l &nbsp;&nbsp; P a n e l')?></div>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $html->link($html->image('icons/user48.png', array('title'=>__('Manage',true).' '.sprintf(__('%s And %s',true),__('Users',true),__('Groups',true)))),array('action' => 'index', 'controller'=> 'users'),null,null,false); ?>
                <br/>
                <?php echo $html->link(__('Users', true), array('action' => 'index', 'controller'=> 'users')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $html->link($html->image('icons/group48.png', array('title'=>sprintf(__('Add %s',true),__('Committee',true)))),array('action' => 'add', 'controller'=> 'groups'),null,null,false); ?>
                <br/>
                <?php echo $html->link(__('Committees', true), array('action' => 'add', 'controller'=> 'groups')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $html->link($html->image('icons/security48.png', array('title'=>__('Manage',true).' '.sprintf(__('%s And %s',true),__('Grades',true),__('Schemes',true)))),array('action' => 'index', 'controller'=> 'grades'),null,null,false); ?>
                <br/>
                <?php echo $html->link(__('Grades', true), array('action' => 'index', 'controller'=> 'grades')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $html->link($html->image('icons/titles48.png', array('title'=>__('Manage',true).' '.__('Title',true))),array('action' => 'index', 'controller'=> 'titles'),null,null,false); ?>
                <br/>
                <?php echo $html->link(__('Titles', true), array('action' => 'index', 'controller'=> 'titles')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $html->link($html->image('icons/mail48.png', array('title'=>__('Manage',true).' '.__('Email Templates',true))),array('action' => 'index', 'controller'=> 'templates'),null,null,false); ?>
                <br/>
                <?php echo $html->link(__('Email Templates', true), array('action' => 'index', 'controller'=> 'templates')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $html->link($html->image('icons/settings.png', array('title'=>__('Manage',true).' '.__('Systems',true))),array('action' => 'index', 'controller'=> 'systems'),null,null,false); ?>
                <br/>
                <?php echo $html->link(__('Systems', true), array('action' => 'index', 'controller'=> 'systems')); ?>
            </td>
        </tr>
    </table>
<?php } ;?>
