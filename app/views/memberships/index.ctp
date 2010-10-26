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

<div class="memberships view">
    <?php 
        if($type=='Group2'){
            $type1='Group';
        }else{
            $type1='User';
        }
        if ($curmember['Membership']['head'] || !empty($curmember['Membership']['admin'])){
            if($type=='User'){
                if(!empty($others)){
                    echo $curLink->add($html->link(sprintf(__('Add Existing %s', true),__('User', true)), array('action' => 'add',$curgroup['Group']['name'],$type)));
                    echo '<br/>';
                }
                echo $curLink->add($html->link(sprintf(__('New %s', true),__('User', true)), array('controller'=>'users','action' => 'add',$curgroup['Group']['name'])));
            }else{
                if(!empty($others)){
                    echo $curLink->add($html->link(sprintf(__('Add Existing %s', true),__('Group', true)), array('action' => 'add',$curgroup['Group']['name'],$type)));
                    echo '<br/>';
                }
                echo $curLink->add($html->link(sprintf(__('New %s', true),__('Group', true)), array('controller'=>'group2s','action' => 'add',$curgroup['Group']['name'])));
            }
        } 
    ?>
<br />
<br />
<div>
<center>
<table cellpadding="0" cellspacing="0" width="80%">
<thead>
<tr>
	<th class="number"><?php __('No.')?></th>
	<th class="sort"><?php echo $paginator->sort(__($type1,true),$type.'.name',array('url'=>array($curgroup['Group']['name'],$type)));?></th>
	<th class="sort"><?php echo $paginator->sort(__('Head',true),'Membership.head',array('url'=>array($curgroup['Group']['name'],$type)));?></th>
    <?php if($type=='User'){ ?>
        <th class="sort"><?php echo $paginator->sort('Admin','Membership.admin',array('url'=>array($curgroup['Group']['name'],$type)));?></th>
    <?php } ?>
	<th class="actions"><?php __('Actions');?></th>
</tr>
</thead>
<?php
$i = 0;
foreach ($memberships as $membership):
    if(!empty($membership[$type]['name'])){
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="odd"';
        }
?>
	<tr<?php echo $class;?>>
		<td class="number">
			<?php echo $i; ?>
		</td>
		<td>
			<?php echo $membership[$type]['name']; ?>
		</td>
		<td class='center'>
			<?php 
                if($curmember['Membership']['head'] || !empty($curmember['Membership']['admin'])){
                    if($membership[$type]['name']==$curuser['User']['name']){
                        $jclass=__('confirmedit1',true);
                    }else{
                        $jclass=__('confirmedit',true);
                    }
                    if(!empty($membership['Membership']['head'])){
                        $checked='checked=1';
                    }else{
                        $checked='';
                    }
                    echo $html->link("<input type='checkbox' ".$checked."/>", array('action' => 'edit', $membership['Group']['name'],$type,$membership['Membership']['id'],'head'),array('class'=>$jclass),null,false);
                }else{
                    if($membership['Membership']['head'])echo $html->image('icons/yes.png'); 
                }
            ?>
		</td>
        <?php if($type=='User'){ ?>
            <td class='center'>
                <?php 
                    if(($curmember['Membership']['head'] || !empty($curmember['Membership']['admin'])) && ($count_admin>1 || $membership['Membership']['admin']!=1)){
                        if(!empty($membership['Membership']['admin'])){
                            $checked='checked=1';
                        }else{
                            $checked='';
                        }
                        echo $html->link("<input type='checkbox' ".$checked."/>", array('action' => 'edit', $membership['Group']['name'],$type,$membership['Membership']['id'],'admin'),array('class'=>$jclass),null,false);
                    }else{
                        if($membership['Membership']['admin'])echo $html->image('icons/yes.png'); 
                    }
                ?>
            </td>
        <?php } ?>
		<td class="actions">
            <table>
                <tr>
                    <td>
                        <?php echo $html->link($html->image('icons/view24.png',array('alt'=>__('View',true),'title'=>__('View',true))), array('action'=>'view', $membership['Group']['name'],$type,$membership['Membership']['id']),null,null,false); ?>
                    </td>

                    <?php 
                        if (($curmember['Membership']['head'] || !empty($curmember['Membership']['admin']))){
                            echo "<td>";
                                if($count_admin>1 || empty($membership['Membership']['admin'])){
                                    echo $html->link($html->image('icons/delete24.png',array('alt'=>__('Delete', true),'title'=>__('Delete',true))), array('action' => 'delete', $membership['Group']['name'],$type,$membership['Membership']['id']),array('class'=>__('confirmdelete',true)), null,false);
                                }
                            echo "</td><td>";
                                if(!empty($membership['User']['locked']) && date('Y-m-d H:i:s')< $membership['User']['locked']){
                                    echo $curLink->prompt($html->image('icons/unlock.png',array('alt'=>__('Unlock', true),'title'=>__('Unlock',true))),$membership['User']['id'],$this->element('unlock',array('id'=>$membership['User']['id'],'group'=>$membership['Group']['name'])));
                                }
                            echo "</td>";
                        }  
                    ?>
                </tr>
            </table>
		</td>
	</tr>
<?php 
    }
endforeach; 
?>
</table>
</center>
</div>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>

