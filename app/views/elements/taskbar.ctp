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
<?php
    echo $curLink->permit(
    	'tasks/basic',
    	$task_permission,
    	$curLink->link("<font color='black'>".__('Basic',true)."</font>",$html->link(__('Basic',true), array('controller' => 'tasks', 'action' => 'basic',$curgroup['Group']['name'],'task_id'=>$task_id)),!strpos(' '.$this->params['url']['url'],'basic')).">>>"
    );
    
    echo $curLink->permit(
    	'tasks/imp',
    	$task_permission,
    	$curLink->link("<font color='black'>".__('Assign Task',true)."</font>",$html->link(__('Assign Task',true), array('controller' => 'tasks', 'action' => 'imp',$curgroup['Group']['name'],'task_id'=>$task_id)),!strpos(' '.$this->params['url']['url'],'imp'))
    );
    
    echo $curLink->permit(
    	'tasks/additional',
    	$task_permission,
    	">>>".$curLink->link("<font color='black'>".__('Additional Info',true)."</font>",$html->link(__('Additional Info',true), array('controller' => 'tasks', 'action' => 'additional',$curgroup['Group']['name'],'task_id'=>$task_id)),!strpos(' '.$this->params['url']['url'],'additional'))
    );
?>
                           
