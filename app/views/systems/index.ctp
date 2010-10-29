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
 
<script type="text/javascript">
    function extrafield(){
        a=document.getElementById('SystemType');

        if(a!=null){
         
            e=document.getElementById('extra');
            if(a.value=='language'){
                e.innerHTML=
                '<div class="input select">'
                    +'<label for="language">'
                        +'<?php echo __('Language',true);?>'
                    +'<\/label>'
                    +'<select name="data[language]" id="language">'
                        +'<option value="eng">English<\/option>'
                        +'<option value="may">Malay<\/option>'
                    +'<\/select>'
                +'<\/div>'
                +'<div class="input checkbox">'
                    +'<input type="hidden" name="data[replace]" id="replace_" value="0" \/>'
                    +'<input type="checkbox" name="data[replace]" checked="checked" value="1" id="replace" \/>'
                    +'<label>'+'<?php echo __('Replace the existing data',true);?>'+'<\/label>'
                +'<\/div>'
                +'<div class="input checkbox">'
                        +'<input type="hidden" name="data[retrieve]" id="retrieve_" value="0" \/>'
                        +'<input type="checkbox" name="data[retrieve]" checked="checked" value="1" id="retrieve" \/>'
                        +'<label>'+'<?php echo __('Retrieve all template',true);?>'+'<\/label>'
                    +'<\/div>';
            }else if(a.value=='Data'){
                e.innerHTML=
                '<div class="input select">'
                    +'<label for="table">'+'<?php echo __('Type',true);?>'+'<\/label>'
                    +'<select name="data[table]" id="table" onchange="extradata(this.value);">'
                        +'<option value="all">'+'<?php __("All") ?>'+'<\/option>'
                        +'<option value="Grade">'+'<?php __("Grades") ?>'+'<\/option>'
                        +'<option value="Scheme">'+'<?php __("Schemes") ?>'+'<\/option>'
                        +'<option value="Title">'+'<?php __("Titles") ?>'+'<\/option>'
                        +'<option value="Template">'+'<?php __("Email Templates") ?>'+'<\/option>'
                        +'<option value="Role">'+'<?php __("Roles") ?>'+'<\/option>'
                    +'<\/select>'
                +'<\/div>'
                +'<span id="dataextra">'
                    +'<div class="input checkbox">'
                        +'<input type="hidden" name="data[replace]" id="replace_" value="0" \/>'
                        +'<input type="checkbox" name="data[replace]" checked="checked" value="1" id="replace" \/>'
                        +'<label>'+'<?php echo __('Replace the existing data',true);?>'+'<\/label>'
                    +'<\/div>'
                    +'<div class="input checkbox">'
                        +'<input type="hidden" name="data[retrieve]" id="retrieve_" value="0" \/>'
                        +'<input type="checkbox" name="data[retrieve]" checked="checked" value="1" id="retrieve" \/>'
                        +'<label>'+'<?php echo __('Retrieve all template',true);?>'+'<\/label>'
                    +'<\/div>'
                +'<\/span>';
            }else{
                e.innerHTML='';
            }
        }
    }
    
    function extradata(d){
        ex=document.getElementById('dataextra');
        r='';
        if(d!='Grade' && d!='Scheme'){
            r='<div class="input checkbox">'
                +'<input type="hidden" name="data[replace]" id="replace_" value="0" \/>'
                +'<input type="checkbox" name="data[replace]" checked="checked" value="1" id="replace" \/>'
                +'<label>'+'<?php echo __('Replace the existing data',true);?>'+'<\/label>'
            +'<\/div>';
        }
        if(d=='Template'){
            r+='<div class="input checkbox">'
                +'<input type="hidden" name="data[retrieve]" id="retrieve_" value="0" \/>'
                +'<input type="checkbox" name="data[retrieve]" checked="checked" value="1" id="retrieve" \/>'
                +'<label>'+'<?php echo __('Retrieve all template',true);?>'+'<\/label>'
            +'<\/div>';
        }
        ex.innerHTML=r;
    }


    window.setTimeout('extrafield()', 50);

</script>

<h2><?php __('System Configuration')?></h2>
<div class="fixup">
    <fieldset>
        <legend><?php __('System Configuration')?></legend>
        <div class="fieldset-inside">
            <?php
                echo $form->create('System',array('action'=>'index'));
                echo $form->input('type',array('onchange'=>'extrafield();','type'=>'select','label'=>__('Actions',true),'options'=>array('--'=>'--'.__('Please select',true).'--','setting'=>__('Change System Settings',true),'logo'=>__('Change System Logo',true),'language'=>__('Change Language',true),'Database'=>__('Update database structure',true),'Data'=>__('Restore data',true))));
                echo '<span id="extra"></span>';
                echo $form->button(__('Next',true),array('type'=>'submit','class'=>'button'));
                echo $form->end();
            ?>
        </div>
    </fieldset>
</div>






