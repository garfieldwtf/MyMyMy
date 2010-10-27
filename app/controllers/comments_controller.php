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
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html', 'Form');

	function add($group_name,$model,$id) {
        Configure::write('debug', 0);
        function reduce_order($a,$b){
            if(empty($a)){
                $a=array();
            }
            if(is_array($b)){
                $a=array_merge($a,$b);
            }
            return $a;
        }
        $imp=array_reduce($this->curimp,'reduce_order');
        $name=$this->Auth->user('name');
        foreach($imp as $im){
            if($im['id']=='*'.$this->Auth->user('id')){
                $impl[0]=$name;
            }else{
                $impl[$im['id']]=$name.' ('.$im['name'].')';
            }
        }

		if (!empty($this->data)) {
            $this->data['Comment']['user']=$impl[$this->data['Comment']['group2_id']];
            $this->loadModel('Notification');
            $task=$this->Task->read(null,$this->params['named']['task_id']);
            $this->Notification->toAllImpEmail($group_name,$task['Task'],$this->data,'task comment');
			$this->Comment->create();
			if ($this->Comment->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Comment',true)));
				$this->redirect(array('controller'=>'tasks','action'=>'view',$group_name,'task_id'=>$this->params['named']['task_id']));
			} else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Comment',true)).__('Please try again.', true));
			}
		}else{
            $this->Task->recursive=-1;
            $this->set('task',$this->Task->read(null,$this->params['named']['task_id']));
        }
        $this->set(compact('model','id','impl'));
	}
}
?>
