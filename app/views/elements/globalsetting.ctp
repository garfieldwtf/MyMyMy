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
    function emaildetail(){
        choice=document.getElementById('email_method').value;
        e=document.getElementById('field');
        if(choice=='native'){
            e.innerHTML='';
        }else if(choice=='smtp'){
            e.innerHTML=
                '<div class="input text"><label for="SystemsSmtpHost">'+'<?php echo __('SMTP Host',true);?>'+'<\/label><input name="data[Systems][smtp_host]" type="text" value="localhost" size="40" class="required" id="SystemsSmtpHost" \/><\/div>'
                +'<span class=\'note\'> e.g. smtp.domain.gov.my<\/span>'
                +'<div class="input text"><label for="SystemsSmtpPort">'+'<?php echo __('SMTP Port',true);?>'+'<\/label><input name="data[Systems][smtp_port]" type="text" value="25" class="required" id="SystemsSmtpPort" \/><\/div>'                
                +'<div class="input text"><label for="SystemsSmtpUsername">'+'<?php echo __('SMTP Username',true);?>'+'<\/label><input name="data[Systems][smtp_username]" type="text" value="" id="SystemsSmtpUsername" \/><\/div>'                
                +'<div class="input text"><label for="SystemsSmtpPassword">'+'<?php echo __('SMTP Password',true);?>'+'<\/label><input name="data[Systems][smtp_password]" type="text" value="" id="SystemsSmtpPassword" \/><\/div>';
        }else if(choice=='sendmail'){
            e.innerHTML=
                '<div class="input text"><label for="SystemsSendmail">'+'<?php echo __('Sendmail Path',true);?>'+'<\/label><input name="data[Systems][sendmail]" type="text" value="\/usr\/sbin\/sendmail" class="required" id="SystemsSendmail" \/><\/div>';
        }
    }
    
    window.setTimeout('emaildetail()', 50);
</script>

<fieldset>
    <legend><?php __('Agency Details')?></legend>
    <div class="fieldset-inside">
        <?php
            echo $form->input('agency_name',array('value'=>$agency_name,'size'=>'40'));
            echo $form->input('agency_address',array('value'=>$agency_address,'size'=>'40'));
            echo $form->input('agency_slogan',array('value'=>$agency_slogan,'size'=>'40'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend><?php __('Email Settings');?></legend>
    <div class="fieldset-inside">
        <?php
            echo $form->input('email_method',array('id'=>'email_method','onchange'=>'emaildetail();','type'=>'select','options'=>array('native'=>'PHP Mailer','smtp'=>'SMTP','sendmail'=>'Sendmail'),'value'=>$email_method));
            echo $form->input('email_from_name',array('value'=>!empty($email_from_name)? $email_from_name:'Task Manager Admin','class'=>'required','label'=>__('Email Sender',true),'size'=>'40'));
            echo $form->input('email_from',array('value'=>$email_from,'label'=>__('Email(From)',true),'size'=>'40','class'=>'required'));
        ?>
        <span class='note'> e.g. name@domain.com</span>
        <span id='field'></span>
    </div>
</fieldset>
<fieldset>
    <legend><?php __('Global settings');?></legend>
    <div class="fieldset-inside">
        <?php
            echo $form->input('locked_period',array('value'=>'60'));
            echo "<span class='note'>".__('Number of minutes the member will be locked after false login for 6 times',true)."</span>";
        ?>
    </div>
</fieldset>
