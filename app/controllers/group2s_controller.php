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

class Group2sController extends AppController {
    
	var $name = 'Group2s';
	var $helpers = array('Html', 'Form','Javascript');
    var $layout='tab';
    
	function index() {
		$this->Group2->recursive = 0;
		$this->set('group2s', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Group',true)));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('group2', $this->Group2->read(null, $id));
	}

	function add($group_name=null) {
		if (!empty($this->data)) {
			$this->Group2->create();
			if ($this->Group2->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Group',true)));
                if($group_name==null){
                    $this->redirect(array('action' => 'index'));
                }else{
                    $this->User->Membership->Create();
                    $membership['Membership']['head']=$this->data['Group2']['head'];
                    $membership['Membership']['group_id']=$this->curgroup['Group']['id'];
                    $membership['Membership']['foreign_key']=$this->Group2->getLastInsertId();
                    $membership['Membership']['model']='Group2';
                    $this->User->Membership->save($membership);
                    $this->redirect(array('controller'=>'memberships','action'=>'index',$group_name,'Group2'));
                }
			} else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Group',true)).__('Please try again.', true));
			}
		}else{
            $this->set('users',$this->User->find('list',array('order'=>'User.name Asc')));
        }
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Group',true)));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Group2->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Group',true)));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Group',true)).__('Please try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Group2->read(null, $id);
            $this->set('users',$this->User->find('list',array('order'=>'User.name Asc')));
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Group',true)));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Group2->del($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true),__('Group',true)));
			$this->redirect(array('action' => 'index'));
		}
        $this->Session->setFlash(sprintf(__('The %s could not be deleted. ', true),__('Group',true)).__('Please try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
