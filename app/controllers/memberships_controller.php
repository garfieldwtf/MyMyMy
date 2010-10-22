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
class MembershipsController extends AppController {

	var $name = 'Memberships';
	var $helpers = array('Html', 'Form','Javascript');
    var $layout='tab';
    
    
	function index($group_name,$type) {
        $memberships=$this->paginate('Membership',array('model'=>$type,'group_id'=>$this->curgroup['Group']['id']));
		$this->set('memberships',$memberships);
        $this->set('type',$type);
        $this->set('count_admin',$this->Membership->find('count',array('conditions'=>array('Membership.group_id'=>$this->curgroup['Group']['id'],'Membership.admin'=>1))));
	}

	function view($group_name,$type,$id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Membership',true)));
			$this->redirect(array('action'=>'index'));
		}

        $membership=$this->Membership->read(null, $id);
        $member=$this->Membership->$type->read(null, $membership['Membership']['foreign_key']);
        unset($member['Membership']);
        $membership=array_merge($membership,$member);
        
        //every group invloved
        $Group=$this->Membership->find('all',array('conditions'=>array('Membership.foreign_key'=>$membership['Membership']['foreign_key'],'Membership.model'=>$type)));
        $this->set('Group', $Group);
		$this->set('member', $membership);
		$this->set('type', $type);
	}

	function add($group_name,$type) {
		if (!empty($this->data)) {
            $this->data['Membership']['model']=$type;
            $this->data['Membership']['group_id']=$this->curgroup['Group']['id'];
			$this->Membership->create();
			if ($this->Membership->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Membership',true)));
				$this->redirect(array('action'=>'index',$group_name,$type));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Membership',true)).__('Please try again.', true));
			}
		}
        
        $member=set::extract($this->Membership->find('all',array('conditions'=>array('Membership.group_id'=>$this->curgroup['Group']['id'],'Membership.model'=>$type))),'{n}.Membership.foreign_key');
		$users = $this->Membership->$type->find('list',array('conditions'=>array('not'=>array($type.'.id'=>$member))));
		$this->set(compact('users'));
        $this->set('type', $type);
	}

	function edit($group_name,$type,$id = null,$role) {
        $this->data = $this->Membership->read(null, $id);
        if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Membership',true)));
			$this->redirect(array('action'=>'index'));
		}
        if(!empty($this->data['Membership'][$role])){
            $this->data['Membership'][$role]=0;
        }else{
            $this->data['Membership'][$role]=1;
        }
        if ($this->Membership->save($this->data)) {
            $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Membership',true)));
            $this->redirect(array('controller'=>'memberships','action'=>'index',$group_name,$type));
        } else {
            $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Membership',true)).__('Please try again.', true));
        }
	}

	function delete($group_name,$type,$id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Membership',true)));
			$this->redirect(array('action'=>'index',$group_name,$type));
		}
        $user=$this->Membership->read(null,$id);
		if ($this->Membership->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s deleted', true),__('Membership',true)));
            if($type=='User' && $user['Membership']['foreign_key']==$this->Auth->user('id')){
                $this->redirect(array('action'=>'mainpage','controller'=>'groups'));
            }else{
                $this->redirect(array('action'=>'index',$group_name,$type));
            }
		}
	}
	
	

}
?>
