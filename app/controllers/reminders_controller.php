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

class RemindersController extends AppController {

	var $name = 'Reminders';
	var $helpers = array('Html', 'Form','DatePicker');

	function add($group_name) {
        Configure::write('debug', 0);
        
        $this->Reminder->recursive=-1;
        $old=$this->Reminder->find('first',array('conditions'=>array('Reminder.task_id'=>$this->params['named']['task_id'],'Reminder.user_id'=>$this->Auth->user('id'))));
        
        $this->Task->recursive=-1;
        $task=$this->Task->read(null,$this->params['named']['task_id']);
        $this->set('task',$task);
        
        if(!empty($old)){
            $this->set('old',$old['Reminder']);
        }
		if (!empty($this->data)) {
            //this reminder exist?
            if(!empty($old)){
                $this->data['Reminder']['id']=$old['Reminder']['id'];
            }else{
                $this->Reminder->create();
            }
			if ($this->Reminder->save($this->data)) {
                $this->loadModel('Notification');
                $this->Notification->reminderEmail($group_name,$task['Task'],$this->data);
                
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Reminder',true)));
				$this->redirect(array('controller'=>'tasks','action'=>'view',$group_name,'task_id'=>$this->params['named']['task_id']));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Reminder',true)).__('Please try again.', true));
			}
		}

        $this->set('task_id',$this->params['named']['task_id']);
	}

}
?>
