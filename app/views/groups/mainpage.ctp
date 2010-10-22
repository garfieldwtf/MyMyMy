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
	// load script in <head> section
        echo $html->charset("UTF-8");
        echo $javascript->link('scriptaculous/src/effects', false);
        echo $javascript->link('scriptaculous/src/controls', false);
        echo $javascript->link('confirmbox', false);
    endif;
    
?>
<div id="mainpage">    
    <div>&nbsp;
        
        <table cellspacing="0" cellpadding="0" align="left" width="100%">
            <tr>
                <td width="87%" align="left">
                    <div><h2><?php __("My Committees")?></h2></div>
                    <br/>
                    <table  cellspacing="0" cellpadding="0" align="left" width="80%" id="comm_list">
                        <?php
                            $i = 0;
                            $j= 0;
                            if (!count($groups)) {
                                echo "<tr><td colspan='2'>".__("You are not registered under any committees yet",true)." </td></tr>";
                            }else{
                                echo "<tr><td colspan='2'>".__("Please click on the appropriate committee name to continue:",true)."</td></tr>";
                                foreach ($groups as $group){ 
                                    $j++;
                                    if($j%2==1){
                                        $class='class="altrow"';
                                    }else{
                                        $class='';
                                    }
                        ?>
                                    <tr <?php echo $class;?>>
                                        <td>
                                            <?php 
                                                $i=$group['order_rank'];
                                                while(!empty($i)){
                                                    if($i==1){
                                                        echo "&nbsp;";
                                                    }else{
                                                        //if(isset($group['remove']) && in_array($i,$group['remove'])){
                                                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                        /*}else{
                                                            echo "&nbsp;&nbsp;|";
                                                        }*/
                                                    }
                                                    $i--;
                                                }
                                                if(!empty($group['order_rank'])){
                                                    echo $html->image('icons/arrow_downright.png');
                                                }else{
                                                    echo "&nbsp;";
                                                }
                                                echo $html->link($group['Group']['group_name'], array($group['Group']['name'],'action' => 'calendar','controller'=>'tasks')); 
                                        echo '&nbsp;</td>';
                                                if($group['Membership']['admin']){
                                                    echo "<td width='5%'>".$html->link($html->image('icons/subGroup_32.png', array('title'=>sprintf(__('Add %s',true),__('Sub Committee',true)))),array($group['Group']['name'],'action' => 'add','controller'=>'groups'),null,null,false).'&nbsp;</td>'; 
                                                    echo "<td width='5%'>".$html->link($html->image('icons/edit24.png', array('title'=>__('Edit',true))), array('action' => 'edit', $group['Group']['id']),null,null,false).'&nbsp;</td>'; 
                                                    echo "<td width='5%'>".$html->link($html->image('icons/delete24.png', array('title'=>__('Delete',true))), array('action' => 'delete', $group['Group']['name']), array('class'=>__('confirmdelete',true)), null,false).'&nbsp;</td>'; 
                                                    echo "<td width='5%'>".$html->link($html->image('icons/Usersetting32.png', array('title'=>__('Memberships',true))),array('controller'=>'memberships','action'=>'index',$group['Group']['name'],'User'),null,null,false).'</td>';
                                                    echo "<td width='5%'>".$html->link($html->image('icons/mail32.png', array('title'=>__('Email Templates',true))),array($group['Group']['name'],'action'=>'index','controller'=>'templates'),null,null,false).'</td>';
                                                }else{
                                                    echo "<td width='5%'>&nbsp;</td>";
                                                    echo "<td width='5%'>&nbsp;</td>";
                                                    echo "<td width='5%'>&nbsp;</td>";
                                                    echo "<td width='5%'>".$html->link($html->image('icons/Usersetting32.png', array('title'=>__('Memberships',true))),array('controller'=>'memberships','action'=>'index',$group['Group']['name'],'User'),null,null,false).'</td>';
                                                    echo "<td width='5%'>&nbsp;</td>";
                                                }
                                            ?>
                                    </tr>
                            <?php }} ?>
                    </table>
                </td>
                <td>
                    <?php if(isset($curuser) && $curuser['User']['superuser'] ) {
                        echo $this->element('adminmenu');} ?>
                </td>
            </tr>
        </table>
    </div>
</div>
