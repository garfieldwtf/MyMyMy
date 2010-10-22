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
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<center>
<div id="login">
<h2><?php __('Login'); ?></h2>
	<?php echo $form->create('User', array('action' => 'login','class'=>'login')); ?>
	<?php echo $form->input('username',array('class'=>'username','label'=>__('Username',true),'value'=>$session->read('login_username'))); ?>
	<?php echo $form->input('password',array('class'=>'pass','label'=>__('Password',true))); ?>
    <?php if($displaycaptcha):?>
    <div class="input text" align="center">
    <?php __('You have exceeded more than allowed login attempts.Please fill in the numbers and alphabets you see below.')?>
    <br/>
	<?php echo "<img src='".$html->url(array('action'=>'captcha'))."'>";?>
    </div>
    <?php echo $form->input('captcha',array('label'=>__('Code',true))); ?>
    <?php endif; ?>
	<?php echo $form->submit(__('Login',true), array('class'=>'button')); ?>
	<?php echo $form->end(); ?>
</div>
<br/>
<br/>
<br/>
<br/>
	<?php 
	echo $html->link(__("Forgot your password?",true),array('controller'=>'users','action'=>'forgotpass'));
	echo '<br/>';	
	echo $html->link(__("Forgot your username?",true),array('controller'=>'users','action'=>'forgotuser'));
	?>
</center>
<script type="text/javascript">
function setFocus(){
	document.getElementById("UserUsername").focus();
}

setFocus();
</script>
