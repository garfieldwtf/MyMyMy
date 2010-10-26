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
<div class="tasks view2">
    <h2><?php  __('Task');?></h2>

    <div class ="menubackground">
    	<?php 
    		echo $this->element('taskbar',array('task_id'=>$this->params['named']['task_id']));
            if($can_add){echo $form->button(__('Skip',true),array('class'=>'rightbutton','onclick'=>'parent.location=\'../../additional/'.$curgroup['Group']['name'].'/task_id:'.$this->params['named']['task_id'].'\''));}
        ?>
    </div>
    <br/>
    <br/>
    <?php echo $form->create('Task',array('url'=>'/tasks/imp/'.$curgroup['Group']['name'].'/task_id:'.$this->params['named']['task_id']));?>
    	<fieldset>
        	<?php 
                echo $form->input('task_id',array('type'=>'hidden','value'=>$this->params['named']['task_id']));
                if($curimp['highest']==1){
            		echo $form->input('head',array('label'=>$role[1],'type'=>'select','options'=>$head));
				}
                $right=array();
                ksort($role);
                foreach($role as $rkey=>$r){
                    if($curimp['highest']>$rkey){
                        echo $form->label($r).'&nbsp;';
                        foreach($implementor[$rkey] as $impl){
                            foreach($impl as $imp){
                                echo $imp;
                                echo '<br/>';
                            }
                        }
                        echo '<br/>';
                    }
                    
                    if($curimp['highest']<=$rkey && $rkey!=1){
                        $right['imp'.$rkey]=array('label'=>$r,'options'=>array('selected'=>$selected[$rkey]));
                    }
                    
                }
                
				echo $multiItem->multiinput(array('Members'=>array('label'=>__('Members',true),'options'=>array('option'=>$umembers,'selected'=>$m_selected)),'Groups'=>array('label'=>__('Groups',true),'options'=>array('option'=>$gmembers,'selected'=>$g_selected))),$right);
				
			?>
		</fieldset>
		<?php echo $form->button(__('Save',true),array('type'=>'submit'));?>
		<?php 
        if($can_add){
            echo $form->button(__('Skip',true),array('onclick'=>'parent.location=\'../../additional/'.$curgroup['Group']['name'].'/task_id:'.$this->params['named']['task_id'].'\''));
        }else{
            echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s View',true),__('Task',true))), array('controller' => 'tasks', 'action' => 'view',$curgroup['Group']['name'],'task_id'=>$this->params['named']['task_id'])));
        } ?>

	<?php echo $form->end();?>
</div>

