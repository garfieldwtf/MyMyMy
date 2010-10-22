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

class Task extends AppModel {

	var $name = 'Task';
    var $actsAs = array('MultiFile');
	var $validate = array(
		'task_name' => array('notEmpty'=>array('rule'=>'notEmpty')),
		'priority' => array('notEmpty'=>array('rule'=>'notEmpty')),
		'start_date' => array('notEmpty'=>array('rule'=>'notEmpty')),
		'end_date' => array('notEmpty'=>array('rule'=>'notEmpty')),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
    );
    
    /**
     * Building assosiations betweeen models
     *
     */
    var $hasAndBelongsToMany = array(
        'Client' =>array(
            'className' => 'Client',
            'joinTable' => 'taskinfos',
            'foreignKey' => 'task_id',
            'associationForeignKey' => 'foreign_key',
            'unique' => true,
            'conditions' => array('Taskinfo.Model'=>'Client'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Meeting' =>array(
            'className' => 'Meeting',
            'joinTable' => 'taskinfos',
            'foreignKey' => 'task_id',
            'associationForeignKey' => 'foreign_key',
            'unique' => true,
            'conditions' => array('Taskinfo.Model'=>'Meeting'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Project' =>array(
            'className' => 'Project',
            'joinTable' => 'taskinfos',
            'foreignKey' => 'task_id',
            'associationForeignKey' => 'foreign_key',
            'unique' => true,
            'conditions' => array('Taskinfo.Model'=>'Project'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Category' =>array(
            'className' => 'Category',
            'joinTable' => 'taskinfos',
            'foreignKey' => 'task_id',
            'associationForeignKey' => 'foreign_key',
            'unique' => true,
            'conditions' => array('Taskinfo.Model'=>'Category'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
    );

	var $hasMany = array(
		'Implementor' => array(
			'className' => 'Implementor',
			'foreignKey' => 'task_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Notification' => array(
			'className' => 'Notification',
			'foreignKey' => 'task_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'foreign_key',
			'dependent' => false,
			'conditions' => array('Comment.model'=>'Task'),
			'fields' => '',
			'order' => 'Comment.created ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'task_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Status.status_date desc',
			'limit' => '1',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
    
    //process 
    function multiItem($task_id,$data,$fields){
        foreach($fields as $f){
            if(!empty($data[$f.'_add'])){
                foreach($data[$f.'_add'] as $akey=>$atext){
                    if(in_array($akey,$data[$f])){
                        $this->{ucfirst($f)}->recursive=-1;
                        $exist=$this->{ucfirst($f)}->find('first',array('conditions'=>array('name'=>$atext,'group_id'=>$data['Task']['group_id'])));
                        if(empty($exist)){
                            //if don't have same name, create new 
                            $d[ucfirst($f)]['group_id']=$data['Task']['group_id'];
                            $d[ucfirst($f)]['name']=$atext;
                            $this->{ucfirst($f)}->create();
                            $this->{ucfirst($f)}->save($d);
                            $data[$f][array_search($akey,$data[$f])]=$this->{ucfirst($f)}->getLastInsertId();
                        }else{
                            //if exist, take the exist id
                            $data[$f][array_search($akey,$data[$f])]=$exist[ucfirst($f)]['id'];
                        }
                    }
                }
            }
            if(!empty($data[$f])){
                if(isset($data[$f]['edit'])){
                    $old=$this->Taskinfo->find('all',array('conditions'=>array('Taskinfo.task_id'=>$task_id,'Taskinfo.model'=>ucfirst($f))));
                    foreach($old as $o){
                        $this->Taskinfo->del($o['Taskinfo']['id']);
                    }
                }
                unset($data[$f]['edit']);
                foreach(array_unique($data[$f]) as $fkey){
                    $d2['Taskinfo']['task_id']=$task_id;
                    $d2['Taskinfo']['model']=ucfirst($f);
                    $d2['Taskinfo']['foreign_key']=$fkey;
                    $this->Taskinfo->create();
                    $this->Taskinfo->save($d2);
                }
            }
        }
        return $data;
    }
    
    function assigned($imp,$user_id){
        $users=set::extract($imp,'{n}.user_id');
        if(in_array($user_id,$users)){
            return $imp[array_search($user_id,$users)]['assign_as'];
        }else{
            return 0;
        }
    }
    
    function split_date($date){
        $fulldate=explode(' ',$date);
        $date=explode('-',$fulldate[0]);
        $time=explode(':',$fulldate[1]);
        return array_merge($date,$time);
    }
    
    //for keyword_search
    function keyword_search($word,$user){
        $group=set::extract($this->Implementor->User->Group2sUser->find('all',array('conditions'=>array('Group2sUser.user_id'=>$user))),'{n}.Group2User.group2_id');
        $task_involved=$this->Implementor->find('all',array('conditions'=>array('or'=>array(array('Implementor.foreign_key'=>$user,'Implementor.model'=>'User'),array('Implementor.foreign_key'=>$group,'Implementor.model'=>'Group2')))));
        $task_involved_id=set::extract($task_involved,'{n}.Task.id');
        $task=$this->find('all',array('conditions'=>array('Task.id'=>$task_involved_id,'or'=>array('Task.task_desc LIKE'=>'%'.$word.'%','Task.task_name LIKE'=>'%'.$word.'%')),'order'=>array('Task.task_name ASC')));
        //$task_name=set::extract($task,'{n}.Task.task_name');
        return $task;
    }
    
    //after delete
    function deleteRelate($task_id){
        $task=$this->read(null,$task_id);
        
        if($this->delete($task_id)){
        
            //delete implementor
            $ical['User']=array();
            $imp=$this->Implementor->find('first',array('conditions'=>array('Implementor.task_id'=>$task_id)));
            while(!empty($imp)){
                $ical[$imp['Implementor']['model']][]=$imp['Implementor']['foreign_key'];
                $this->Implementor->delete($imp['Implementor']['id']);
                $imp=$this->Implementor->find('first',array('conditions'=>array('Implementor.task_id'=>$task_id)));
            }
            $this->Implementor->processCal($ical);
        
            $this->bindmodel(array('hasMany'=>array('Reminder','Attachment','Template')));
            
            $simpleDelete=array('Status','Reminder','Taskinfo');
            foreach($simpleDelete as $s){
                $data=$this->{$s}->find('first',array('conditions'=>array($s.'.task_id'=>$task_id)));
                while(!empty($data)){
                    $this->{$s}->delete($data[$s]['id']);
                    $data=$this->{$s}->find('first',array('conditions'=>array($s.'.task_id'=>$task_id)));
                }
            }
        
            //notification
            $unsent=$this->Notification->find('first',array('conditions'=>array('Notification.notification_sent'=>0,'Notification.task_id'=>$task_id)));       
            while(!empty($unsent)){
                $this->Notification->delete($unsent['Notification']['id']);
                $unsent=$this->Notification->find('first',array('conditions'=>array('Notification.notification_sent'=>0,'Notification.task_id'=>$task_id)));       
            }

            $whowasimp=$this->Notification->whoWasImp($task_id);
            if(!empty($whowasimp)){
                $user=array();
                foreach($whowasimp as $w=>$as){
                    $userid=explode('/',$w);
                    $user[$userid[0]]=$as;
                }
            
                $deletetemplate=$this->Template->find('first',array('conditions'=>array('Template.model'=>'Task','Template.foreign_key'=>$task_id,'Template.type'=>'delete task')));
                $deletetemplate['Template']['template']=$this->replacetemplate($deletetemplate['Template']['template'],$task);
            
                $this->Implementor->User->recursive=0;
                foreach($user as $id=>$as){
                    $userdata=$this->Implementor->User->read(null,$id);
                    $this->Notification->sendEmail($task_id,$deletetemplate,$userdata);
                }
            }
            
            //delete data which model is task
            $bymodel=array('Attachment','Template','Comment');
            foreach($bymodel as $b){
                $data=$this->{$b}->find('first',array('conditions'=>array($b.'.foreign_key'=>$task_id,$b.'.model'=>'Task')));
                while(!empty($data)){
                    $this->{$b}->delete($data[$b]['id']);
                    $data=$this->{$b}->find('first',array('conditions'=>array($b.'.foreign_key'=>$task_id,$b.'.model'=>'Task')));
                }
            }

            return true;
        }
        
    }

}
?>
