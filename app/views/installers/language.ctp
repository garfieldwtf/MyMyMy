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
<h2>Language</h2>

<div>
    <?php echo $form->create(array('action'=>'language'));?>
    <fieldset>
        <legend>Language</legend>
        <div class="fieldset-inside">
        Please choose the language. Task Manager will be set up to use the language below by default.
        <?php echo $form->input('language',array('type'=>'select','options'=>array('eng'=>'English','may'=>'Malay'))); ?>
        <br /></div>
    </fieldset>
    <?php
        echo $form->button('Back', array('type'=>'button', 'onclick'=>'parent.location="database"'));
        echo "&nbsp;";
        if ($languageset)
            echo $form->button('Next',array('type'=>'button','onclick'=>'parent.location="syssettings"','class'=>'button'));
        else 
            echo $form->button('Submit',array('type'=>'submit','class'=>'button'));
        echo $form->end();
    ?>
</div>
