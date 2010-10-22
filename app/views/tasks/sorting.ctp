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
<div class="tasks sorting view">
  <table cellpadding="0" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="sort"><?php echo $paginator->sort(__('Task Name',true),'Task.task_name',array('url'=>array($this->params['pass'][0],$this->params['pass'][1])))?></th>
            <th class="sort"><?php echo $paginator->sort(__('Start Date',true),'Task.start_date',array('url'=>array($this->params['pass'][0],$this->params['pass'][1])))?></th>
            <th class="sort"><?php echo $paginator->sort(__('Target End Date',true),'Task.end_date',array('url'=>array($this->params['pass'][0],$this->params['pass'][1])))?></th>
            <th class="sort"><?php echo $paginator->sort(__('Priority',true),'Task.priority',array('url'=>array($this->params['pass'][0],$this->params['pass'][1])))?></th>
            <th><?php echo __('Status',true)?></th>
            <th><?php echo __('Percentage',true)?></th>
        </tr>
    </thead>
    <?php 
    $i=0;
    if($sortings==null){ echo "<tr><td colspan='6'>There is no task.</td></tr>";}
    foreach($sortings as $sorting):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
        else {
			$class = ' class="odd"';}
     ?>
    <tr <?php echo $class;?>>
        <td>
            <?php 
            if($sorting['view']==1){
                echo $html->link($sorting['Task']['task_name'], array('controller'=>'tasks','action' => 'view',$curgroup['Group']['name'], 'task_id'=>$sorting['Task']['id']));
            }else{
                echo $sorting['Task']['task_name']; 
            }
            ?>
        </td>
        <td><?php echo $sorting['Task']['start_date']; ?></td>
        <td><?php echo $sorting['Task']['end_date']; ?></td>
        <td>
            <?php 
            if($sorting['Task']['priority']==1){
                echo __('High',true);
            }elseif($sorting['Task']['priority']==2){
                echo __('Medium',true);
            }elseif($sorting['Task']['priority']==3){
                echo __('Low',true);
            } 
            ?>
        </td>
        <td>
            <?php 
            $stat=array(
                'N'=>__('Not Started',true),
                'P'=>__('In Progress',true),
                'F'=>__('Completed',true),
                'D'=>__('Delayed',true),
                'C'=>__('Cancelled',true),
                'K'=>__('KIV',true),
            );
            if(!empty($sorting['Status'][0]['task_status'])){echo $stat[$sorting['Status'][0]['task_status']];}else{ echo "&nbsp;";} ?></td>
        <td><?php if(!empty($sorting['Status'][0]['percent'])){echo $sorting['Status'][0]['percent'].'%';}else{ echo "0%";} ?></td>
    </tr>
    <?php endforeach;?>
    
  </table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $paginator->numbers();?>	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
