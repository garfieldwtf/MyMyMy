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
 
<div class="tasks form">
    <h2><?php  __('Keyword Search');?></h2>
    <?php 
        echo $form->create('Committee',array('url'=>array('action'=>'keyword','controller'=>'tasks')));
        __('This will search the task with the keyword.');
        echo $form->input('Search.text', array('value'=>$dtext[0],'size'=>'40','label'=>__('Keyword',true)));
        echo $html->div('',$form->button(__('Search!', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'parent.location="'.Router::url('/').'"')));
        echo $form->end();
        if(!empty($multi)){
            $stat=array(
                'N'=>__('Not Started',true),
                'P'=>__('In Progress',true),
                'F'=>__('Completed',true),
                'D'=>__('Delayed',true),
                'C'=>__('Cancelled',true),
                'K'=>__('KIV',true),
            );
    ?>
            <table cellpadding="0" cellspacing="0" class="task_table">
                <tr class="thead">
                    <td class="sort"><?php echo __('Task Name',true)?></td>
                    <td class="sort"><?php echo __('Description',true)?></td>
                    <td class="sort"><?php echo __('Start Date',true)?></td>
                    <td class="sort"><?php echo __('Target End Date',true)?></td>
                    <td class="sort"><?php echo __('Committee',true)?></td>
                    <td class="sort"><?php echo __('Priority',true)?></td>
                    <td class="sort"><?php echo __('Status',true)?></td>
                    <td class="sort"><?php echo __('Percentage',true)?></td>
                </tr>
                
                <?php 
                $i=0;
                foreach($multi as $single):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                ?>
                    <tr <?php echo $class;?>>
                        <td>
                            <?php 
                                $string=$text->highlight($text->excerpt($single['Task']['task_name'],$dtext,'50'),$dtext);
                                echo $html->link($string, array('controller'=>'tasks','action' => 'view',$single['Group']['name'], 'task_id'=>$single['Task']['id']),null,null,false);
                            ?>
                        </td>
                        <td><?php echo $single['Task']['task_desc'];?></td>
                        <td><?php echo $single['Task']['start_date']; ?></td>
                        <td><?php echo $single['Task']['end_date']; ?></td>
                        <td><?php echo $single['Group']['name'] ?></td>
                        <td>
                            <?php 
                                if($single['Task']['priority']==1){
                                    echo __('High',true);
                                }elseif($single['Task']['priority']==2){
                                    echo __('Medium',true);
                                }elseif($single['Task']['priority']==3){
                                    echo __('Low',true);
                                } 
                            ?>
                        </td>
                        <td><?php if(!empty($single['Status'][0]['task_status']))echo $stat[$single['Status'][0]['task_status']];?></td>
                        <td><?php if(!empty($single['Status'][0]['percent']))echo $single['Status'][0]['percent'].'%'; ?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        <?php }?>
</div>
