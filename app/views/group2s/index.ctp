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
<div class="schema view ">
    <p>
        <?php echo $curLink->add($html->link(sprintf(__('New %s', true),__('Group', true)), array('action' => 'add'))); ?>
    </p>
    <br />
    <br />
    <center>
       <table cellpadding="0" cellspacing="0" width="80%" border="1">
            <thead>
                <th class="number"><?php __('No.')?></th>
                <th class="sort"><?php echo $paginator->sort('name');?></th>
                <th class="sort"><?php echo $paginator->sort('description');?></th>
                <th class="actions"><?php __('Actions');?></th>
            </thead>
            <?php
                if(!count($group2s))
                    echo "<tr><td colspan='4'>".__('No record found',true)."</td></tr>";
                $i = 0;
                foreach ($group2s as $group2):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="odd"';
                    }
            ?>
                    <tr<?php echo $class;?>>
                        <td class="number">
                            <?php echo $i.'. '?>
                        </td>
                        <td class="tbody">
                            <?php echo $group2['Group2']['name']; ?>
                        </td>
                        <td class="tbody">
                            <?php echo $group2['Group2']['description']; ?>
                        </td>
                        <td class="actions">
                            <?php echo $html->link($html->image('icons/view24.png',array('title'=>__('View',true))), array('action'=>'view', $group2['Group2']['id']),null,null,false); ?>
                            <?php echo $html->link($html->image('icons/edit24.png',array('title'=>__('Edit',true))), array('action'=>'edit', $group2['Group2']['id']),null,null,false); ?>
                            <?php echo $html->link($html->image('icons/delete24.png',array('title'=>__('Delete', true))), array('action' => 'delete', $group2['Group2']['id']),array('class'=>__('confirmdelete',true)), null,false); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
        </table>
    </center>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $paginator->numbers();?>	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
