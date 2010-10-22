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

	$first_of_month = mktime(0, 0, 0, $month, 1, $year);
	$num_days = cal_days_in_month(0, $month, $year);
	$offset = date('w', $first_of_month);
	$rows = 1;
?>
<!-- Jeff Linse's Calendar Element for CakePHP -->
<div class="calendarbig" >
<center>
    <?php if ($month == 1)echo $html->link('<<', $month_link.($year-1).'/'.(12));
          else echo $html->link('<<', $month_link.$year.'/'.($month-1)); ?> 
    <?php echo __(date('F', $first_of_month),true).date(' Y', $first_of_month); ?> 
    <?php if ($month != 12)echo $html->link('>>', $month_link.$year.'/'.($month+1));
          else echo $html->link('>>', $month_link.($year+1).'/'.(1)); ?>
  

</center>
<?php
    //translation
    __('January',true);
    __('February',true);
    __('March',true);
    __('April',true);
    __('May',true);
    __('June',true);
    __('July',true);
    __('August',true);
    __('September',true);
    __('October',true);
    __('November',true);
    __('December',true);
?>
<table class="task_table" border ="1"width ="100%">
	<tr class="thead" align="left">
    <th><?php  __('Sunday');?></th>
    <th><?php  __('Monday');?></th>
    <th><?php  __('Tuesday');?></th>
    <th><?php  __('Wednesday');?></th>
    <th><?php  __('Thrusday');?></th>
    <th><?php  __('Friday');?></th>
    <th><?php  __('Saturday');?></th></tr>
	<tr>	
	<?php for( $i = 1; $i < $offset + 1; ++$i ): ?>
		<td class="tbodynon"></td>
	<?php endfor; ?>
	
	<?php for( $day = 1; $day <= $num_days; ++$day ): ?>
		<?php if( ($day + $offset - 1) % 7 == 0 && $day != 1 ): ?>
			</tr><tr>
			<?php ++$rows; ?>
		<?php endif; ?>
        <?php if (date('Y-m-d',mktime(0,0,0,$month,$day,$year))==date('Y-m-d')){
            echo '<td class="today">';
        }else{
            echo '<td class="tbody">';
        }
        ?>
            <?php 
            echo $day;
            $tdate=date('Y-m-d',mktime(0,0,0,$month,$day,$year));
            if(!empty($tasks[$tdate])){
                foreach ($tasks[$tdate] as $key=>$task):
                    echo '<br />';
                    if($task['Task']['priority']==1){ echo '<div class="yellow">';}
                    if($task['view'] ==1){
                        echo $html->link($task['Task']['task_name'], array('controller'=>'tasks','action' => 'view',$task['Group']['name'], 'task_id'=>$task['Task']['id']));
                    }else{
                        echo $task['Task']['task_name'];
                    }
                    if($task[1]=='end'){
                        echo $html->image('icons/deadline.png');
                    }elseif($task[1]=='start,end'){
                        echo $html->image('icons/start.png');
                        echo '&nbsp;';
                        echo $html->image('icons/deadline.png');
                    }elseif($task[1]=='start'){
                        echo $html->image('icons/start.png');
                        
                    }
                    if($task['Task']['priority']==1){ echo '</div>';}
                endforeach;
            } else { echo '<br />';echo '<br />';echo '<br />';}
            ?>
        </td>
    <?php endfor; ?>
	
	<?php for( $day; ($day + $offset) <= $rows * 7; ++$day ): ?>
		<td class="tbodynon"></td>
	<?php endfor;?>
	
	</tr>
</table>
</div>
<div>
    <fieldset>
        <legend><?php __('Legend'); ?>:</legend>
        <table class="legend" width="100%"> 
            <tr>
                <td width="33%"><?php echo $html->image('icons/start.png'); ?> --<?php __('Start')?></td>
                <td width="33%"><?php echo $html->image('icons/deadline.png'); ?> --<?php __('Deadline')?></td>
                <td width="33%"><span class="yellow">&nbsp;&nbsp;&nbsp;&nbsp;</span> --<?php __('High Priority');?></td>
            </tr>
        </table>
            
    </fieldset>
</div>
<br/>
