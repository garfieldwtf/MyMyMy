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
<h2 class="hijau">Task Manager has been installed successfully.</h2>

For security please change the permissions of <span class="bold">app/config/</span> directory to be unwritable.
<?php
/*
For mailing function to work, please set up the cron/task scheduler. 

<p>&nbsp;</p>
<span class="bold">Example how to set up cron/task scheduler on Ubuntu.</span> For other distro, please change accordingly.
<p>&nbsp;</p>
To send out email every 15 min everyday<br/>
* / 15 * * * * /var/www/tm/cake/console/cake -app /var/www/tm/app cron emails > /dev/null 2>&1
<p>&nbsp;</p>
To send out reminders to specific on their related tasks at 7am everyday<br/>
0 7 * * * /var/www/mtm/cake/console/cake -app /var/www/tm/app cron reminders > /dev/null 2>&1 <br/>
*/
?>
<div>
<?php echo $form->create(array('action'=>'success'));?>
    <fieldset>
        <legend>Registration</legend>
        <div class="fieldset-inside">
            Thank you for choosing Task Manager. 
            <p>&nbsp;</p>
            Please take a moment to fill in the form below for registration.
            <br/>
            <?php
                echo $form->input('purpose',array('label'=>"The installation's purpose",'type'=>'select','options'=>array('review'=>'Review','production'=>'Production')));
                echo "<br/>";
                echo "<span class='note'>Choose review if you're installing this Task Manager for review. Choose Production if it's for production.</span>";
                echo $form->input('intent',array('type'=>'select','label'=>'Do you have plan to deploy Task Manager in your agency?','options'=>array('--'=>'--please choose--','Yes'=>'Yes','No'=>'No','In consideration'=>'In consideration')));
                echo "<br/>";
                echo "<span class='note'>Please select and fill in the below fields if you're installing for review.</span>";
                echo $form->input('contactme',array('type'=>'select','label'=>'Do you wish for OSCC to contact you?','options'=>array('--'=>'--please choose--','Yes'=>'Yes','No'=>'No')));
                echo $form->input('name',array('size'=>'40','label'=>'Name'));
                echo $form->input('email',array('size'=>'40','label'=>'Email'));
                echo $form->input('phone',array('size'=>'40','label'=>'Phone'));

            ?>
        </div>
    </fieldset>
    <p>&nbsp;</p>
    <?php echo $form->button('Back', array('type'=>'button', 'onclick'=>'parent.location="syssettings"','class'=>'button'));?>&nbsp;
    <?php echo $form->button('Register and go to Task Manager now',array('type'=>'submit','class'=>'button'));?>
    <?php echo $form->end();?>
</div>


