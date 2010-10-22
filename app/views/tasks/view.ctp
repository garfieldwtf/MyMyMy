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

    if(isset($javascript)):
        echo $javascript->link('confirmbox', false);
    endif;
?>
<div class="tasks view">
    <h2><?php  __('Task');?></h2>
    <?php if(!empty($curimp)){ ?>
    <table cellpadding="0" cellspacing="0" class="maincontent" width="100%">
        <thead class= "taballcontent">  
        <tr>
            <td>
                <?php //menubar
                if(!empty($curimp[1]) ||!empty($curimp[2])){
                    echo "|-".$html->link(__('Edit',true), array('controller' => 'tasks', 'action' => 'basic',$curgroup['Group']['name'],'task_id'=>$task['Task']['id']))."-|";
                }elseif(!empty($curimp[3])){
                    echo "|-".$html->link(__('Assign Task',true), array('controller' => 'tasks', 'action' => 'imp',$curgroup['Group']['name'],'task_id'=>$task['Task']['id']))."-|";
                }
                echo $curLink->permit(
                	'tasks/delete',
                	$task_permission,
                	"|-".$html->link(__('Delete',true), array('controller' => 'tasks', 'action' => 'delete',$curgroup['Group']['name'],'task_id'=>$task['Task']['id']),array('class'=>__('confirmdelete',true)))."-|"
                );
                echo $curLink->permit(
                 	'statuses/add',
                 	$task_permission,
                 	"|-".$curLink->dialogPage($html->url(array('controller' => 'statuses', 'action' => 'add',$curgroup['Group']['name'],!empty($task['Status'][0]),'task_id'=>$task['Task']['id'])),__('Status',true))."-|"
                );
                echo $curLink->permit(
                 	'comments/add',
                 	$task_permission,
                    "|-".$curLink->dialogPage($html->url(array('controller' => 'comments', 'action' => 'add',$curgroup['Group']['name'],'Task',$task['Task']['id'],'task_id'=>$task['Task']['id'])),__('Comment',true))."-|"
                );
                echo $curLink->permit(
                 	'reminders/add',
                 	$task_permission,
					"|-".$curLink->dialogPage($html->url(array('controller' => 'reminders', 'action' => 'add',$curgroup['Group']['name'],'task_id'=>$task['Task']['id'])),__('Reminder',true))."-|"
                );
                if(!empty($head_group['available'])){
                    echo $curLink->permit(
                        'tasks/copy',
                        $task_permission,
                        "|-".$curLink->dialogPage($html->url(array('controller' => 'tasks', 'action' => 'copy',$curgroup['Group']['name'],'task_id'=>$task['Task']['id'])),__('Copy the task to other committee',true))."-|"
                    );
                }
                ?>
            </td>
        </tr>
        </thead>
    </table>
    <?php } ?>
    <br/>
    <br/>
    <center>
    <table border="1" width ="95%" class="task_width">
        <thead>
            <tr>
                <td colspan="3">
                    <a name="reminder"></a>
                    <?php 
                        if(!empty($reminder['Reminder'])){
                            echo '<table cellpadding="0" cellspacing="0" class="task_table">';
                            echo '<tr><td class="thead1" colspan="4" >'.__('Reminder for this Task',true).'</td></tr>';
                            if (!empty($reminder['Reminder']['note'])){
                                echo '<tr><td class="thead" colspan="4" >'.__('Note',true).'</td></tr>';
                                echo '<tr><td class="tbody" colspan="4" >'.nl2br($reminder['Reminder']['note']).'</td></tr>';
                            } 
                            if (!empty($reminder['Reminder']['remind_date'])){
                                echo '<tr><td class="thead" colspan="4" >'.__('Reminder Setting',true).'</td></tr>';
                                echo '<tr><td class="tbody" colspan="4" >';
                                //remind date
                                echo '<b>'.__('Remind Date',true).'</b> : '.$reminder['Reminder']['remind_date'].'&nbsp;';
                                //sending 
                                if(!empty($reminder['Reminder']['send_date'])){
                                    echo '<i>';
                                    echo __('will send',true).'&nbsp;';
                                    if($reminder['Reminder']['repeated']){
                                        echo __('everyday',true).'&nbsp;'.__('after',true).'&nbsp;';
                                    }else{
                                        echo __('on',true).'&nbsp;';
                                    }
                                    echo $reminder['Reminder']['send_date'].'.';
                                    echo '</i>';
                                    echo '<br/>';
                                }
                                //active
                                echo '<b>'.__('Notification status',true).'</b> : ';
                                echo !empty($reminder['Reminder']['active'])?__('Active',true):__('Not active',true);
                                echo '</td></tr></table>';
                            } 
                        }
                        else{ echo '<h4>'.sprintf(__('No %s found',true),__('Reminder',true)).'</h4>';}
                    ?>
                    
                </td>
            </tr>
            <tr>
                <td width="20%">
                    <?php 
                        if(!empty($task['Implementor'])){
                            echo '<h3>'.__('Implementor',true).'</h3><br/>';
                            ksort($implementor);
                            foreach($implementor as $i=>$idata){
                                echo '<b>'.$role[$i].':&nbsp;</b>';
                                echo '<br/>';
                                foreach($idata as $impl){
                                	foreach($impl as $imp){
                                    	echo '- '.$imp.'<br/>';
									}
                                }
                                echo '<br/>';
                            }
                        }
                    ?>
                </td>
                <td width="55%">
                    <a name="task"></a>
                    <table cellpadding="0" cellspacing="0" class="task_table">
                        <tr>
							<td class="thead1" colspan="4" ><?php echo __('Task Detail',true); ?></td>
						</tr>
                        <tr>
                            <td class="thead" >&nbsp;<?php  __('Task Name');?></td>
                            <td class="tbody" colspan="3" >&nbsp;<?php echo $task['Task']['task_name']; ?></td>
                        </tr>
                        <?php 
                            if (!empty($task['Meeting'])){?>
                                <tr>
                                    <td class="thead">&nbsp;<?php  __('Meeting');?></td>
                                    <td class="tbody" colspan="3" >
                                        <?php 
                                            foreach($task['Meeting'] as $meeting){
                                                echo "&nbsp;";
                                                echo $meeting['name'];
                                                echo "<br/>";
                                            } 
                                        ?>
                                    </td>
                                </tr>
                        <?php } ?>
                        <?php if (!empty($task['Task']['ref_no'])){?>
                            <tr>
                                <td class="thead">&nbsp;<?php  __('Reference Number');?></td>
                                <td class="tbody" colspan="3" >&nbsp;<?php echo $task['Task']['ref_no']; ?></td>
                            </tr>
                        <?php } ?>
                        <?php if (!empty($task['Project'])){?>
                            <tr>
                                <td class="thead">&nbsp;<?php  __('Project');?></td>
                                <td class="tbody" colspan="3" >
                                    <?php 
                                        foreach($task['Project'] as $project){
                                            echo "&nbsp;";
                                            echo $project['name'];
                                            echo "<br/>";
                                        } 
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (!empty($task['Client'])){?>
                            <tr>
                                <td class="thead">&nbsp;<?php  __('Client');?></td>
                                <td class="tbody" colspan="3" >
                                    <?php 
                                        foreach($task['Client'] as $client){
                                            echo "&nbsp;";
                                            echo $client['name'];
                                            echo "<br/>";
                                        } 
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (!empty($task['Category'])){?>
                            <tr>
                                <td class="thead">&nbsp;<?php  __('Category');?></td>
                                <td class="tbody" colspan="3" >
                                    <?php 
                                        foreach($task['Category'] as $category){
                                            echo "&nbsp;";
                                            echo $category['name'];
                                            echo "<br/>";
                                        } 
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="thead">&nbsp;<?php  __('Priority');?></td>
                            <td class="tbody" colspan="3" >
                                &nbsp;
                                <?php 
                                    if($task['Task']['priority']==1){
                                        echo __('High',true);
                                    }elseif($task['Task']['priority']==2){
                                        echo __('Medium',true);
                                    }elseif($task['Task']['priority']==3){
                                        echo __('Low',true);
                                    }; 
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="thead" >&nbsp;<?php  __('Start Date');?></td>
                            <td class="tbody" >&nbsp;<?php echo $task['Task']['start_date']; ?></td>
                            <td class="thead" >&nbsp;<?php  __('End Date');?></td>
                            <td class="tbody">&nbsp;<?php echo $task['Task']['end_date']; ?></td> 
                        </tr>
                        <?php if (!empty($task['Task']['task_desc'])){?>
                            <tr><td class="thead" colspan="4" ><?php  __('Description');?></td></tr>
                            <tr><td class="tbody" colspan="4" ><?php echo $task['Task']['task_desc']; ?></td></tr>
                        <?php } ?>
                        <?php if (!empty($task['MultiFile']['task'])){?>
                            <tr>
                                <td class="thead"><?php  __('Task File');?></td>
                                <td class="tbody" colspan="3" >
                                    <ul>
                                    <?php 
                                        foreach($task['MultiFile']['task'] as $mfd){
                                            echo "<li>";
                                            echo $html->link($mfd['Attachment']['filename'],array('controller'=>'tasks','action'=>'attachment',$mfd['Attachment']['id']));
                                            echo "</li>";
                                        }
                                    ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <br/>
                    <table cellpadding="0" cellspacing="0" class="task_table"> 
					<?php  
					if(!empty($task['Status'])){ 
						echo '<tr><td class="thead1" colspan="4" >'.__('Latest Status',true).'</td></tr>'; 
						 
						$stat=array( 
							'N'=>__('Not Started',true), 
							'P'=>__('In Progress',true), 
							'F'=>__('Completed',true), 
							'D'=>__('Delayed',true), 
							'C'=>__('Cancelled',true), 
							'K'=>__('KIV',true), 
						); 
						echo '<tr><td class="thead" >&nbsp;'.__('Task Status',true).'</td>'; 
							echo '<td class="tbody" colspan="3" >'.$stat[$task['Status'][0]['task_status']].'</td>'; 
						echo '</tr>'; 
						echo '<tr><td class="thead" >&nbsp;'.__('Status Percentage',true).'</td>'; 
							echo '<td class="tbody" colspan="3" >'.$task['Status'][0]['percent'].'%'.'</td>'; 
						echo '</tr>'; 
						if(!empty($task['Status'][0]['description'])){ 
							echo '<tr><td class="thead" >&nbsp;'.__('Status Remark',true).'</td>'; 
								echo '<td class="tbody" colspan="3" >'.$task['Status'][0]['description']; 
							echo '</tr>'; 
						} 
						if(!empty($task['Status'][0]['updater_name'])){ 
							echo '<tr><td class="thead" >&nbsp;'.__('By',true).'</td>'; 
								echo '<td class="tbody">'.$task['Status'][0]['updater_name'].'</td>'; 
								 echo '<td class="thead" >&nbsp;'.__('Updated date',true).'</td>'; 
								echo '<td class="tbody">'.$task['Status'][0]['status_date'].'</td>'; 
							echo '</tr>'; 
						} 
						if(!empty($task['Status'][0]['closed'])){ 
							echo '<tr><td class="thead" >&nbsp;'.__('Actual End Date',true).'</td>'; 
								echo '<td class="tbody" colspan="3" >'.$task['Status'][0]['date_closed'].'</td>'; 
							echo '</tr>'; 
						} 
						if(in_array('statuses/index',$task_permission)){ 
							echo '<tr><td class="tbody1" colspan="4" align="right">'.$html->link(__('More Detail',true), array('controller' => 'statuses', 'action' => 'index',$curgroup['Group']['name'],'task_id'=>$task['Task']['id']),array('class'=>'button')).'</td></tr>'; 
						} 
					} 
                    ?> 
                    </table> 
                    <br/>
                </td>
                <td>
                    <a name="comment"></a>
                    <?php 
                        if(!empty($task['Comment'])){
                            echo '<table cellpadding="0" cellspacing="0" class="task_table">';
                            echo '<thead><tr><td class="comment"><h3>'.__('Comment for this Task',true).'</h3></td></tr></thead>';
                            foreach($task['Comment'] as $comm){
                                echo '<tr><td class="tbody">';
                                    echo '&nbsp;'.$comm['description'];
                                    echo '<br/>';
                                    echo '&nbsp; -- posted by '.$user[$comm['user_id']];
                                    if(!empty($comm['group2_id'])){
                                        echo ' ('.$group2[$comm['group2_id']].')';
                                    };
                                    echo "<br/>&nbsp;&nbsp;&nbsp;&nbsp; on ".$comm['created'];
                                echo '</td></tr>';
                            }
                            echo '</table>';
                        }else{
                            echo '<h4>'.sprintf(__('No %s found',true),__('Comment',true)).'</h4>';
                        }
                    ?>
                </td>
            </tr>
        </thead>
    </table>
    </center>
</div>

<?php 
    if(!empty($curimp[1]) || !empty($head_group['subtask'])){
        echo "<table width='100%'><tr><td width='50%' align='left'> ";
    }
    if(!empty($curimp[1])){
        echo $curLink->link(null,$html->link(__('Go to parent task',true),array('controller'=>'tasks','action'=>'view',$ptask['Group']['name'],'task_id'=>$ptask['Task']['id']),array('class'=>'button')),!empty($ptask));
    }
    if(!empty($curimp[1]) || !empty($head_group['subtask'])){
        echo "</td><td width='50%'> ";
    }
    if(!empty($head_group['subtask'])){
        if(count($head_group['subtask'])==1){
            echo $html->link(__('Go to child task',true),array('controller'=>'tasks','action'=>'view',$head_group['subtask'][0]['Group']['name'],'task_id'=>$head_group['subtask'][0]['Task']['id']),array('class'=>'button rightbutton'));
        }else{
            echo $curLink->dialogPage($html->url(array('controller'=>'tasks','action'=>'childtask',$curgroup['Group']['name'],$task['Task']['id'])),__('Go to child task',true),array('class'=>'button rightbutton'));
        }
    }
    if(!empty($curimp[1]) || !empty($head_group['subtask'])){
        echo "</td></tr></table> ";
    }
?>

