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
<div class="statuses view">
<h2><?php __('Statuses');?></h2>
<table cellpadding="0" cellspacing="0" class="task_table" width="80%">
    <thead>
        <tr>
            <th><?php echo __('No.',true);?></th>
            <th class="sort"><?php echo $paginator->sort(__('Status',true),'Status.task_status',array('url'=>array($this->params['pass'][0],'task_id'=>$this->params['named']['task_id'])));?></th>
            <th class="sort"><?php echo $paginator->sort(__('Progress',true).'(%)','Status.percent',array('url'=>array($this->params['pass'][0],'task_id'=>$this->params['named']['task_id'])));?></th>
            <th class="sort"><?php echo $paginator->sort(__('Status Remark',true),'Status.description',array('url'=>array($this->params['pass'][0],'task_id'=>$this->params['named']['task_id'])));?></th>
            <th class="sort"><?php echo $paginator->sort(__('Implementor',true),'User.name',array('url'=>array($this->params['pass'][0],'task_id'=>$this->params['named']['task_id'])));?></th>
            <th class="sort"><?php echo $paginator->sort(__('Updated date',true),'Status.status_date',array('url'=>array($this->params['pass'][0],'task_id'=>$this->params['named']['task_id'])));?></th>
            <th class="sort"><?php echo $paginator->sort(__('Close date',true),'Status.date_closed',array('url'=>array($this->params['pass'][0],'task_id'=>$this->params['named']['task_id'])));?></th>
        </tr>
    </thead>
<?php
$i = 0;
$stat=array(
    'N'=>__('Not Started',true),
    'P'=>__('In Progress',true),
    'F'=>__('Completed',true),
    'D'=>__('Delayed',true),
    'C'=>__('Cancelled',true),
    'K'=>__('KIV',true),
);
foreach ($statuses as $status):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="odd"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $i; ?>
		</td>
        <td>
			<?php echo $stat[$status['Status']['task_status']]; ?>
		</td>
        <td align="right">
			<?php echo $status['Status']['percent']."&nbsp;"; ?>
		</td>
		<td>
			<?php echo $status['Status']['description']; ?>
		</td>
		<td>
			<?php echo $status['User']['name']; ?>
		</td>
		<td>
			<?php echo $status['Status']['status_date']; ?>
		</td>
		<td>
			<?php if(empty($status['Status']['closed'])){echo '<center>-</center>';}else{echo $status['Status']['date_closed'];} ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div align="right">
    <?php echo $curLink->back($html->link(sprintf(__('Go Back to "%s"', true),sprintf(__('%s View',true),__('Task',true))), array('controller' => 'tasks', 'action' => 'view',$curgroup['Group']['name'],'task_id'=>$this->params['named']['task_id'])));?>
</div>

