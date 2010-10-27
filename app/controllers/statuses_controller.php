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

class StatusesController extends AppController {

	var $name = 'Statuses';
	var $helpers = array('Html', 'Form','DatePicker','Javascript');

	function index($group_name) {
		$this->Status->recursive = 0;
        $this->paginate=array('order'=>'Status.status_date DESC');
		$this->set('statuses', $this->paginate('Status',array('Status.task_id'=>$this->params['named']['task_id'])));
	}

	function add($group_name,$old=null) {
        Configure::write('debug', 0);
        $imp=$this->curimp;
        unset($imp['highest']);
        unset($imp[1]);
        unset($imp[2]);
        $name=$this->Auth->user('name');
        foreach($imp as $i){
            foreach($i as $im){
                if($im['id']=='*'.$this->Auth->user('id')){
                    $impl[0]=$name;
                }else{
                    $impl[$im['id']]=$name.' ('.$im['name'].')';
                    $group[$im['id']]=$im['name'];
                }
            }
        }
        $this->set('impl',$impl);
        
        if($old==1){
            $this->Status->recursive=-1;
            $oldStatus=$this->Status->find('first',array('conditions'=>array('Status.task_id'=>$this->params['named']['task_id']),'order'=>'Status.updated DESC'));
            $this->set('old',$oldStatus['Status']);
        }
        $this->Status->Task->recursive=-1;
        $task=$this->Status->Task->find('first',array('conditions'=>array('Task.id'=>$this->params['named']['task_id'])));
        $this->set('task',$task);
        $this->set('task_id',$this->params['named']['task_id']);
		if (!empty($this->data)) {
			$this->Status->create();
			if ($this->Status->save($this->data)) {
                if(!empty($group[$this->data['Status']['group2_id']])){
                    $this->data['Status']['user']=$group[$this->data['Status']['group2_id']];
                }else{
                    $this->data['Status']['user']=$impl[$this->data['Status']['group2_id']];
                }
                $this->data['Updater']=$this->Auth->user('name');
                $this->loadModel('Notification');
                $task=$this->Task->read(null,$this->params['named']['task_id']);
                $this->Notification->toAllImpEmail($group_name,$task['Task'],$this->data,'update status');
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Status',true)));
				$this->redirect(array('controller'=>'tasks','action'=>'view',$group_name,'task_id'=>$this->params['named']['task_id']));
			} else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Status',true)).__('Please try again.', true));
			}
		}
	}

}
?>
