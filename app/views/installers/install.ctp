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
 
<h2>License</h2>
<div class="license">
    <fieldset class="license">
         <legend>Software License Agreement</legend>
         <div>
            <?php echo nl2br($license); ?>
        </div>
    </fieldset>
    <?php
        echo $form->create(array('action'=>'install'));
        echo $form->input('agree',array('label'=>'Agree and Install','type'=>'checkbox'));
        echo $form->button('Next',array('type'=>'submit','class'=>'button'));
        echo $form->end();
    ?>
</div>





