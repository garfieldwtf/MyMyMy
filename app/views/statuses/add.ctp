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

// load script in <head> section
echo $javascript->link('jscalendar/calendar.js',false);
echo $javascript->link('jscalendar/lang/calendar-en.js',false);
echo $javascript->link('common.js',false);
echo $html->css('../js/jscalendar/skins/aqua/theme',false,false,false,false);
?>
<script type="text/javascript">
    function checkstatus(){
        a=document.getElementById('StatusTaskStatus').value;
        r='';
        b=document.getElementById('StatusPercent');
        if(a=='N'){
            b.value=0;
        }else{
            if(a!='N' && a!='P'){
                r+='<div class="input checkbox"><input name="data[Status][closed]" id="StatusClosed_" value="0" type="hidden"><input name="data[Status][closed]" value="1" id="StatusClosed" type="checkbox"><label for="StatusClosed">'+'<?php __('Closed'); ?>'+'<\/label><\/div>';
            }
            if(a=='F'){
                 b.value=100;
                date=document.getElementById('StatusOldclosedate').value;
                r+='<div class="date"><label for="StatusDateClosed">'+'<?php __('Actual End Date'); ?>'+'<\/label><input id="StatusDateClosed" type="text" value="'+date+'" name="data[Status][date_closed]"\/><a onclick="return showCalendar(\'StatusDateClosed\', \'%Y-%m-%d %k:%M\',\'24\'); return false;" href="#"><img alt="" src="\/tm2\/img\/..\/js\/jscalendar/img.gif"\/><\/a><\/div>';
            }
        }
        e = document.getElementById('closed');
        e.innerHTML =r;
    }
    window.setTimeout('checkstatus()', 50);
</script>

<div class="statuses form">
<?php echo $this->element('taskdetail',array('task'=>$task['Task'])); ?>
<?php echo $form->create('Status',array('url'=>'/statuses/add/'.$curgroup['Group']['name'].'/task_id:'.$task_id,'name'=>'statusform'));?>
	<fieldset>
 		<legend><?php echo sprintf(__('Add %s',true),__('Status',true));?></legend>
	<?php
		echo $form->hidden('task_id',array('value'=>$task_id));
		echo $form->hidden('user_id',array('value'=>$curuser['User']['id']));
        echo $form->input('group2_id',array('label'=>__('Implementor',true),'type'=>'select','options'=>$impl));
		echo $form->hidden('updater',array('value'=>$curuser['User']['id']));
		echo $form->input('task_status',array(
            'label'=>__('Status',true),
            'options'=>array(
                'N'=>__('Not Started',true),
                'P'=>__('In Progress',true),
                'F'=>__('Completed',true),
                'D'=>__('Delayed',true),
                'C'=>__('Cancelled',true),
                'K'=>__('KIV',true),
            ),
            'value'=>!empty($old['task_status'])?$old['task_status']:'N',
            'onchange'=>'checkstatus()',
            'class'=>'required'
        ));
        
		echo $form->input('percent',array('label'=>__('Status Percentage',true).' (%)','value'=>!empty($old['percent'])?$old['percent']:null,'error'=>array('numeric'=>__('Number',true).' '.__('Only',true))));
		echo $form->input('description',array('label'=>__('Status Remark',true),'value'=>!empty($old['description'])?$old['description']:null));
		echo $form->hidden('status_date',array('value'=>date('Y-m-d H:i:s')));            
        echo $form->hidden('oldclosedate',array('value'=>!empty($old['date_closed'])?date('Y-m-d H:i',strtotime($old['date_closed'])):''));
        echo '<span id="closed"></span>';
	?>
	</fieldset>
<?php echo $form->button(__('Save', true),array('type'=>'submit','class'=>'button')); ?>
<?php echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s View',true),__('Task',true))), array('controller' => 'tasks', 'action' => 'view',$curgroup['Group']['name'],'task_id'=>$task_id)));?>
<?php echo $form->end();?>
</div>
