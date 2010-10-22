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
        echo $javascript->link('confirmbox', false);
    endif;
?>
<div class="schemes view">
    <div>
        <br />
        &nbsp;
        <?php echo $curLink->add($html->link(sprintf(__('New %s', true),__('Scheme', true)),array('action'=>'add'))); ?> 
    </div>
    <br />
<center>
<table cellpadding="0" cellspacing="0" width="80%">
<thead>
    <tr>
        <th class="number"><?php __('No.');?></th>
        <th class="sort"><?php echo $paginator->sort(__('Scheme',true),'name');?></th>
        <th class="actions"><?php __('Actions');?></th>
    </tr>
</thead>
<?php
if(!count($schemes)) 
    echo "<tr><td colspan='3'>".__('No record found',true)."</td></tr>";

if($paginator->current() == '1') $i = 0;
else $i = $paginator->current() * $this->params['paging']['Scheme']['options']['limit'] - $this->params['paging']['Scheme']['options']['limit']; 

foreach ($schemes as $scheme):
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
    }
?>
    <tr<?php echo $class;?>>
        <td class="number">
            <?php echo $i.'. '; ?>
        </td>
        <td>
            <?php echo $scheme['Scheme']['name']; ?>
        </td>
        <td class="actions">
            <?php echo $html->link($html->image('icons/edit24.png',array('alt'=>__('Edit',true),'title'=>__('Edit',true))), array('action'=>'edit', $scheme['Scheme']['id']),array('escape'=>false)); ?>
            <?php echo $html->link($html->image('icons/delete24.png',array('alt'=>__('Delete',true),'title'=>__('Delete',true))), array('action'=>'delete', $scheme['Scheme']['id']), array('escape'=>false,'class'=>__('confirmdelete',true))); ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>
</center>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 |  <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
