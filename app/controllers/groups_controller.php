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

class GroupsController extends AppController {

	var $name = 'Groups';
	var $helpers = array('Html', 'Form');

	function add() {
		if (!empty($this->data)) {
            if(!empty($this->curgroup)){
                $this->data['Group']['parent_id']=$this->curgroup['Group']['id'];
            }
			$this->Group->create();
            $name=explode(' ',$this->data['Group']['group_name']);
            $this->data['Group']['name']=implode('_',$name);
			if ($this->Group->save($this->data)) {
                if(!empty($this->data['Group']['import'])){
                    $all_member=$this->Group->Membership->find('all',array('conditions'=>array('Membership.group_id'=>$this->curgroup['Group']['id'])));
                    foreach($all_member as $m){
                        $this->Group->Membership->Create();
                        $membership['Membership']['group_id']=$this->Group->getLastInsertID();
                        $membership['Membership']['foreign_key']=$m['Membership']['foreign_key'];
                        $membership['Membership']['model']=$m['Membership']['model'];
                        $membership['Membership']['head']=$m['Membership']['head'];
                        $membership['Membership']['admin']=$m['Membership']['admin'];
                        $this->Group->Membership->save($membership);   
                    }
                }else{
                    $this->Group->Membership->Create();
                    $membership['Membership']['group_id']=$this->Group->getLastInsertID();
                    $membership['Membership']['foreign_key']=$this->Auth->user('id');
                    $membership['Membership']['model']='User';
                    $membership['Membership']['admin']=1;
                    $this->Group->Membership->save($membership);
                }
                $this->loadModel('Template');
                $this->Template->duplicate(array('Template.model'=>'System'),'Group',$membership['Membership']['group_id']);
				$this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Committee',true)));
				$this->redirect(array('controller'=>'memberships','action'=>'index',$this->data['Group']['name'],'User'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Committee',true)).__('Please try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Committee',true)));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
            $name=explode(' ',$this->data['Group']['group_name']);
            $this->data['Group']['name']=implode('_',$name);
			if ($this->Group->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Committee',true)));
				$this->redirect(array('controller'=>'groups','action'=>'mainpage'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Committee',true)).__('Please try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Group->read(null, $id);
            $this->set('parent',$this->Group->find('list',array('conditions'=>array('Group.id!='.$id))));
		}
        
        
	}

	function delete($group_name) {
        $group=$this->curgroup;
		if (!$group) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Committee',true)));
			$this->redirect(array('action'=>'mainpage'));
		}
		if ($this->Group->delete($group['Group']['id'])) {
            $this->Group->deleteRelate($group['Group']['id']);
            $this->Session->setFlash(sprintf(__('%s deleted', true),__('Committee',true)));
			$this->redirect(array('controller'=>'groups','action'=>'mainpage'));
		}
	}
	/**
     * Describe mainpage
     *
     * @return null
     */
    function mainpage(){
        $this->Group->Membership->unbindmodel(array('belongsTo'=>array('User','Group2' )));
        $group2=$this->User->Group2sUser->find('all',array('conditions'=>array('Group2sUser.user_id'=>$this->Auth->user('id'))));
        $group=$this->Group->Membership->find('all',array('conditions'=>array(
            'or'=>array(
                array('Membership.foreign_key'=>$this->Auth->user('id'),'Membership.model'=>'User'),
                array('Membership.foreign_key'=>set::extract($group2,'{n}.Group2sUser.group2_id'),'Membership.model'=>'Group2')
            ),
            'not'=>array('Group.id'=>null)
        )));
        $group=$this->Group->groupList($group);
		$this->set('groups', $group);
    } 

}
?>
