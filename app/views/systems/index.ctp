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
 
<!--
 e.innerHTML='<select id="language" name="data[language]"><option value="eng">English<\/option><option value="may">Malay<\/option><\/select>';
?> 
 -->
<script type="text/javascript">
function extrafield(a){
    e=document.getElementById('extra');
    if(a.value=='language'){
         e.innerHTML='<div class="input select"><label for="language">'+'<?php echo __('Language',true);?>'+'<\/label><select name="data[language]" id="language"><option value="eng">English<\/option><option value="may">Malay<\/option><\/select><\/div>';
    }else{
        e.innerHTML='';
    }
}

</script>

<h2><?php __('System Configuration')?></h2>
<div class="fixup">
    <fieldset>
        <legend><?php __('System Configuration')?></legend>
        <div class="fieldset-inside">
            <?php
                echo $form->create(array('action'=>'index'));
                echo $form->input('type',array('onchange'=>'extrafield(this);','type'=>'select','label'=>__('Actions',true),'options'=>array('--'=>'--'.__('Please select',true).'--','setting'=>__('Change System Settings',true),'logo'=>__('Change System Logo',true),'language'=>__('Change Language',true),'Database'=>__('Update database structure',true))));
                echo '<span id="extra"></span>';
                echo $form->button(__('Next',true),array('type'=>'submit','class'=>'button'));
                echo $form->end();
            ?>
        </div>
    </fieldset>
</div>






