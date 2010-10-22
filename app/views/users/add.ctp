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
<div class="users form">
<?php echo $form->create('User',array('url'=>array(isset($curgroup['Group']['name'])?$curgroup['Group']['name']:'')));?>
	<fieldset>
 		<legend><?php echo sprintf(__('Add %s',true),__('User',true));?></legend>
	<?php
		echo $form->input('username',array('class'=>'required','error'=>array(
            'length'=>__('Username',true).': '.__('minimum length should be 4.',true),
            'character'=>__('Number',true).', '.__('Alphabet',true).' '.__('And',true).' '.__('Underscore',true).' '.__('Only',true)
        )));
        if(empty($curgroup)){
            echo $form->input('superuser');
        }else{
            echo $form->input('head',array('type'=>'checkbox'));
            echo $form->input('admin',array('type'=>'checkbox'));
        }
        
        echo "<table><tr><td>";
		echo $form->label(__('Grade',true));
        echo "</td><td>";
		echo $form->input('scheme_id',array('class'=>'grade','label'=>false,'empty'=>'--please select--'));
        echo "</td><td>";
		echo $form->input('grade_id',array('class'=>'grade','label'=>false,'empty'=>'--please select--'));
        echo "</td></tr></table>";
        
        echo $form->input('title_id',array('type' => 'select', 'empty' => '--please select--','class'=>'required'));
		echo $form->input('name',array('class'=>'required','error'=>array('notEmpty'=>__('This field cannot be left blank',true))));
        echo $form->input('job_title', array('size'=>'40', 'label'=>__('Post',true)));
        echo $form->input('bahagian', array('size'=>'40','label'=>__('Section/Division',true)));
        
		echo $form->input('email',array(
            'class'=>'required',
            'error'=>array(
                'format'=>__('Invalid email format',true),
                'email Unique'=>sprintf(__('This %s already exist' ,true),__('Email',true))
            )
        ));
		echo $form->input('telephone',array('error'=>array(
        'format'=>__('Please supply valid telephone number eg: 03-6667777',true),
        )));
		echo $form->input('mobile', array('error'=>array(
        'format'=>__('Please supply valid mobile number eg: 012-3456789',true),
        )));
		echo $form->input('fax',array('error'=>array(
        'format'=>__('Please supply valid fax number eg: 03-6667777',true),
        )));
		echo $form->input('address');
	?>
	</fieldset>
    <?php 
        echo "&nbsp;";
        echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button'));
        echo "&nbsp;";
        if(empty($curgroup)){ 
            echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s List',true),__('User',true))), array('controller' => 'users', 'action' => 'index')));
        }else{
            echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s List',true),__('Membership',true))), array('controller' => 'memberships', 'action' => 'index',$curgroup['Group']['name'],'User')));
        }
        echo $form->end();
    ?>
</div>

