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

$note = '<h2>'.__('Note',true).':</h2><br/>';
$note.= '%name - '.__("recipient's name",true).'<br/>';
$note.= '%slogan - '.__("agency's slogan",true).'<br/>';
$note.= '%Task.task_name - '.__("task's name",true).'<br/>';
$note.= '%your - '.__("pronoun for recipient's",true).'<br/>';
$note.= '%you - '.__("pronoun for recipient",true).'<br/>';
$note.= '%Implementor.as - '.__("recipient's current role",true).'<br/>';
$note.= '%oldImplementor.as - '.__("recipient's previous role",true).'<br/>';
$note.= '%Link.task:word - '.__("word is linked to task's page",true).'<br/>';
$note.= '%Comment.description - '.__("comment content",true).'<br/>';
$note.= '%Comment.user - '.__("user who left the comment",true).'<br/>';
$note.= '%Status.description - '.__("status content",true).'<br/>';
$note.= '%Status.user - '.__("user/group whose status was updated",true).'<br/>';
$note.= '%updater - '.__("user who updated the status",true).'<br/>';
$note.= '%Reminder.note - '.__("reminder note",true).'<br/>';
$note.= '%%Reminder.remind_date - '.__("date which was set to send reminder",true).'<br/>';
$note.= '%username - '.__("retrieved username",true).'<br/>';
$note.= '%newpassword - '.__("new password",true).'<br/>';
$note.= '%Link.newaccount:word - '.__("word is linked to login page",true).'<br/>';
echo $html->div('note',$note);  
?>
<br/>
<div class='view' align="center">
    <table width='90%'>
        <thead>
            <tr>
                <th><?php __('Title')?></th>
                <th><?php __('Available placeholders')?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Notification of Task Assignation</td>
                <td>%name, %slogan, %you, %Implementor.as, %Task.task_name, %Link.task:word</td>
            </tr>
            <tr>
                <td>Notification of Task Deassignation</td>
                <td>%name, %slogan, %your, %you, %Implementor.as, %Task.task_name</td>
            </tr>
            <tr>
                <td>Notification of Change of Role</td>
                <td>%name, %slogan, %your, %you, %Task.task_name, %oldImplementor.as, %Implementor.as, %Link.task:word</td>
            </tr>
            <tr>
                <td>Notification of Task Cancellation</td>
                <td>%name, %slogan, %Task.task_name</td>
            </tr>
        <tr>
            <td>Task Comment</td>
            <td>%name, %slogan, %Comment.user, %Task.task_name, %Comment.description, %Link.task:word</td>
        </tr>
        <tr>
            <td>Updating of Status</td>
            <td>%name, %slogan, %Updater, %Status.user, %Task.task_name, %Status.description, %Link.task:word</td>
        </tr>
        <tr>
            <td>Reminder</td>
            <td>%name, %slogan, %Task.task_name, %Reminder.note, %Reminder.remind_date, %Link.task:word</td>
        </tr>
        <tr>
            <td>New Password</td>
            <td>%name, %slogan, %newpassword</td>
        </tr>
        <tr>
            <td>Retrieve Username</td>
            <td>%name, %slogan, %username</td>
        </tr>
        <tr>
            <td>New Account</td>
            <td>%name, %slogan, %username, %newpassword, %Link.newaccount:word</td>
        </tr>
    </tbody>
</table>
</div>
<br/>
