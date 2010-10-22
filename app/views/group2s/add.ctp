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
function checkAll(all,user){
    a=user.split(',');
    for(i=0;i<a.length;i++){
        $('UserUser'+a[i]).checked=all.checked;
    }
}
</script>

<div class="group2s form">
<?php echo $form->create('Group2',array('url'=>array(isset($curgroup['Group']['name'])?$curgroup['Group']['name']:'')));?>
	<fieldset>
 		<legend><?php echo sprintf(__('Add %s',true),__('Group',true));?></legend>
	<?php
		echo $form->input('name');
        if(!empty($curgroup)){
            echo $form->input('head',array('type'=>'checkbox'));
        }
		echo $form->input('description');
        $user_ids=implode(',',array_keys($users));
        echo $html->div('input checkbox',
            $form->checkbox('Select All',array('checked'=>false,'onClick'=>'checkAll(this,"'.$user_ids.'")')).$form->label(__('Select All',true))
        );
        echo $form->input('User',array('label'=>false,'multiple'=>'checkbox'));
	?>
	</fieldset>
    <?php 
        echo "&nbsp;";
        echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button'));
        echo "&nbsp;";
        if(isset($curgroup['Group']['name'])){
            echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s List',true),__('Group',true))), array('controller' => 'memberships', 'action' => 'index',$curgroup['Group']['name'],'Group2')));
        }else{
            echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s List',true),__('Group',true))), array('controller' => 'group2s', 'action' => 'index')));
        }
        echo $form->end();
    ?>
</div>
