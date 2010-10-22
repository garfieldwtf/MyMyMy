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
<h2>Directory &amp; File Permission</h2>

<div>
    <fieldset>
        <legend>Directory &amp; File Permission</legend>
        <div class='fieldset-inside'>
        <span class="bold">Directories below are not writable!</span> Please correct the permission so that Task Manager can work properly. 
        <p></p>
        <?php foreach($areNotWriteable as $dir){ ?>
            <ul>
                <li style="color:red"><?php echo $dir; ?></li>
            </ul>
            <br />
        <?php } ?>
        <br />
        <?php echo"Note: in case of tmp/ directory all the subdirectories need to be writeable as well"; ?>
        <br />
        <p>&nbsp;</p>
        
        <span class="bold">Directories below are writable.</span>
        <?php foreach($areWritable as $dir){ ?>
            <ul>
                <li style="color:green"><?php echo $dir; ?></li>
            </ul>
            <br />
        <?php } ?>
        </div>
    </fieldset>
    <?php
        echo $form->create(array('action'=>'dircheck'));
        echo $form->button('Cancel', array('type'=>'button', 'onclick'=>'history.go(-1)','class'=>'button'));
        echo '&nbsp;';
        if (count($areNotWriteable))
            echo $form->button('Try again',array('type'=>'submit'));
        else 
            echo $form->button('Next',array('type'=>'button','onclick'=>'parent.location="database"'));
        echo $form->end();
    ?>
</div>
