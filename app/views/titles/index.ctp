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
<div class="titles view">
<h2><?php __('Titles');?></h2>
<?php echo $curLink->add($html->link(sprintf(__('New %s', true),__('Title', true)), array('action' => 'add'))); ?>
<br />
<br />
<center>
<table cellpadding="0" cellspacing="0" width="80%">
<thead>
    <tr>
        <th class="number"><?php __('No.')?></th>
        <th class="sort"><?php echo $paginator->sort(__('Name',true),'Title.long_name');?></th>
        <th class="actions"><?php __('Actions');?></th>
    </tr>
</thead>
<?php
if(!count($titles))
    echo "<tr><td colspan='4'>".__('No record found',true)."</td></tr>";

if($paginator->current() == '1') $i = 0;
else $i = $paginator->current() * $this->params['paging']['Title']['options']['limit'] - $this->params['paging']['Title']['options']['limit'];

foreach ($titles as $title):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="odd"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="number">
			<?php echo $i.'. '?>
		</td>
		<td class="tbody" width="60%">
			<?php echo $title['Title']['long_name']; ?>
		</td>
		<td class="actions">
            <?php echo $html->link($html->image('icons/edit24.png',array('title'=>__('Edit',true))), array('action'=>'edit', $title['Title']['id']),null,null,false); ?>
			<?php echo $html->link($html->image('icons/delete24.png', array('title'=>__('Delete',true))), array('action' => 'delete', $title['Title']['id']), array('class'=>__('confirmdelete',true)), null,false); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</center>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>

