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
<div id="topcontent">
    <?php echo "<b>".$html->link($curuser['User']['name'], array('controller' => 'users', 'action' => 'profile'))."</b>"." | "
					.$html->link(__('Mainpage',true), array('controller' => 'groups', 'action' => 'mainpage'))." | "
					.$html->link(__('My Task',true), array('controller' => 'tasks', 'action' => 'calendar'))." | "
					.$html->link(__('Logout',true), array('controller' => 'Users', 'action' => 'logout'));?>
</div>
<br />
<div class="topsearch">
    <?php 
        echo $form->create('Task',array('url'=>array('controller'=>'tasks','action'=>'keyword')));
        echo $html->div('input',$ajax->autoComplete('Search.text','/tasks/getmultidata',array('onfocus'=>"if(this.value=='".__('Type keyword and press enter to search',true)."') this.value='';", 'onblur'=>"if(this.value=='') this.value='".__('Type keyword and press enter to search',true)."';" ,'value'=>__("Type keyword and press enter to search",true)))); 
        echo $form->end();
    ?>
</div>
<br />
<br />
