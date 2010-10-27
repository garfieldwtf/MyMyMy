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

class Implementor extends AppModel {

	var $name = 'Implementor';
	var $validate = array(
		'task_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'task_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'foreign_key',
			'conditions' => array('Implementor.model'=>'User'),
			'fields' => '',
			'order' => ''
		),
		'Group2' => array(
			'className' => 'Group2',
			'foreignKey' => 'foreign_key',
			'conditions' => array('Implementor.model'=>'Group2'),
			'fields' => '',
			'order' => ''
		),
        'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'assign_as',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
    //process to save implementor
    function AssignImplementor($task_id,$data){
        $ical['User']=array();
        
        if(!empty($data[1])){
            //save head
            $old_head=$this->find('first',array('conditions'=>array('Implementor.task_id'=>$task_id,'Implementor.assign_as'=>1)));
            $ical[$old_head['Implementor']['model']][]=$old_head['Implementor']['foreign_key'];
            $this->delete($old_head['Implementor']['id']);
            $this->Create();
            $head['Implementor']=$this->UserOGroup($data[1]);
            $head['Implementor']['task_id']=$task_id;
            $head['Implementor']['assign_as']=1;
            $ical[$head['Implementor']['model']][]=$head['Implementor']['foreign_key'];
            $this->save($head);
            unset($data[1]);
        }
                
        foreach($data as $key=>$d){
            if(isset($d['edit'])){
                $old=$this->find('all',array('conditions'=>array('Implementor.task_id'=>$task_id,'Implementor.assign_as'=>$key)));
                if(!empty($old)){
                    foreach($old as $o){
                        $ical[$o['Implementor']['model']][]=$o['Implementor']['foreign_key'];
                        $this->delete($o['Implementor']['id']);
                    }
                }
            }
            unset($d['edit']);
            foreach($d as $dkey=>$d){
                $this->Create();
                $imp['Implementor']=$this->UserOGroup($d);
                $imp['Implementor']['task_id']=$task_id;
                $imp['Implementor']['assign_as']=$key;
                $ical[$imp['Implementor']['model']][]=$imp['Implementor']['foreign_key'];
                $this->save($imp);
            }
        }
        $this->processCal($ical);
    }
    
    
    /*task implementor list
     * 
     * return $implementor=array($assign_as=>array($model=>array($foreign_key=>$name)));
     */
    function AssignAs($data){
    	$implementor[1]=$implementor[2]=$implementor[3]=$implementor[4]=array();
		foreach($data['Implementor'] as $imp){
            $this->{$imp['model']}->unbindmodel(array('hasMany'=>array('Implementor','Membership','Group2sUser')));
            if(!empty($imp['foreign_key'])){
                $name=$this->{$imp['model']}->read(null,$imp['foreign_key']);
                $implementor[$imp['assign_as']][$imp['model']][$imp['foreign_key']]=$name[$imp['model']]['name'];
            }
        }
        return $implementor;
    }
    
    /*automatically add current user/group2 as head
     * 
     * $task=task;
     * $user_id=user_id;
     * $group_id=group2 id which user involve(in the group)
     * 
     */
    function AutoHead($task,$user_id,$group_id){
        $this->create();
        
        $head_user=$this->User->Membership->find('first',array('conditions'=>array('Membership.group_id'=>$task['Task']['group_id'],'Membership.head'=>1,'Membership.model'=>'User','Membership.foreign_key'=>$user_id)));
        if(!empty($head_user)){
            $imp['Implementor']['foreign_key']=$user_id;
            $imp['Implementor']['model']='User';
        }else{
            $head_group=$this->User->Membership->find('first',array('conditions'=>array('Membership.group_id'=>$task['Task']['group_id'],'Membership.head'=>1,'Membership.model'=>'Group2','Membership.foreign_key'=>$group_id)));
            if(!empty($head_group)){
                $imp['Implementor']['foreign_key']=$head_group['Membership']['foreign_key'];
                $imp['Implementor']['model']='Group2';
            }
        }
        
        $imp['Implementor']['task_id']=$task['Task']['id'];
        $imp['Implementor']['assign_as']=1;
        
        if($this->save($imp)){  
            $this->Task->Notification->sendImpEmail($task['Task']);
        }
    }
    
    /*process the model and foreign_key
     * 
     * $d --eg: User1,Group24
     */
    function UserOGroup($d){
        if(strpos(' '.$d,'User')){
            $result['model']='User';
            $result['foreign_key']=str_replace('User','',$d);
        }else{
            $result['model']='Group2';
            $result['foreign_key']=str_replace('Group2','',$d);
        }
        return $result;
    }
    
    /*process the user and group2 to call ical
     * 
     * $ical --eg: $ical['Group2']=array($id...), $ical['User']=array($id...);
     */
    function processCal($ical){
        if(!empty($ical['Group2'])){
            $group2_user=$this->User->Group2sUser->find('all',array('conditions'=>array('Group2sUser.group2_id'=>set::extract($ical['Group2'],'{n}'))));
            $ical['User']=array_merge($ical['User'],set::extract($group2_user,'{n}.Group2sUser.user_id'));
        }
        foreach(array_unique($ical['User']) as $u){
            $user=$this->User->read(null,$u);
            $this->User->create_cal($user);
        }
    }
}
?>
