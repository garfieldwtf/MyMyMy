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
<h2>Database Configuration</h2>

<div class="settings">
    <?php echo $form->create(array('action'=>'database')); ?>
    <fieldset>
        <legend>MySQL Configuration</legend>
        <div class="fieldset-inside">
            <?php
                echo $form->input('host',array('value'=>!empty($host)? $host:'localhost'));
                echo $form->input('login',array('value'=>!empty($login)? $login:'','label'=>'MySQL Username'));
                echo $form->input('password',array('value'=>!empty($password)? $password:'','type'=>'password','label'=>'MySQL Password'));
                echo $form->input('database',array('value'=>!empty($database)? $database:'tm_db','label'=>'Database Name'));
                echo $form->input('prefix',array('label'=>'Table Prefix'));
            ?>
        </div>
    </fieldset>
    <p>&nbsp;</p>
    <?php echo $form->button('Back', array('type'=>'button', 'onclick'=>'parent.location="dircheck"','class'=>'button'));?>&nbsp;
    <?php if (!empty($connected)):?>
        <?php echo $form->button('Next',array('type'=>'button','onclick'=>'parent.location="language"','class'=>'button')); ?>
    <?php else:?>
        <?php echo $form->button('Submit',array('type'=>'submit'));?>
    <?php endif;?>
    <?php echo $form->end();?>
</div>


