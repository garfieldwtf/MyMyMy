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
<ul>
    <li><span class="viewtitle"><span class="viewtitle"><?php __('Name');?>:</span></span> <?php echo $user['Title']['long_name'];?> <?php echo $user['User']['name'];?></li>
    <li><span class="viewtitle"><?php __('Post');?>:</span> <?php echo $user['User']['job_title'];?></li>
    <li><span class="viewtitle"><?php __('Section/Division'); ?>:</span> <?php echo $user['User']['bahagian']; ?></li>
    <li><span class="viewtitle"><?php __('Grade'); ?>:</span> <?php echo $user['Grade']['grade']; ?></li>
    <li><span class="viewtitle"><?php __('E-mail');?>:</span> <a href="mailto:<?php echo $user['User']['email'];?>"><?php echo $user['User']['email'];?></a></li>
    <li><span class="viewtitle"><?php __('Address'); ?>:</span> <?php echo "<br/>".nl2br($user['User']['address']); ?></li>
    <li><span class="viewtitle"><?php __('Telephone'); ?>:</span> <?php echo $user['User']['telephone']; ?></li>
    <li><span class="viewtitle"><?php __('Mobile'); ?>:</span> <?php echo $user['User']['mobile']; ?></li>
    <li><span class="viewtitle"><?php __('Fax'); ?>:</span> <?php echo $user['User']['fax']; ?></li>
</ul>
