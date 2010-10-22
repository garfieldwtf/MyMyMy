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

class Notification extends AppModel {

	var $name = 'Notification';
	var $validate = array(
		'task_id' => array('numeric'),
		'notification_sent' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'task_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    
    /**
     * Describe sendEmail 
     * send email
     * @param $template
     * @param $user --recipient
     * @param $date
     * @return null
     */
    function sendEmail($task_id=null,$template,$user,$date=null,$extra=null){
        if(!empty($template['Template']['type'])){
            $this->create();
            if(!empty($task_id)){
                $notification['task_id']=$task_id;
            }
            if(!empty($date)){
                $notification['notification_date']=$date;
            }else{
                $notification['notification_date']=date("Y-m-d H:i:s");
            }
            $notification['type']=$template['Template']['type'];
            $notification['message_title']=$template['Template']['title'];
            $notification['to']=$user['User']['email'];
            $user['User']['name']=$user['Title']['long_name'].' '.$user['User']['name'];
            $notification['message']=$this->replacetemplate($template['Template']['template'],$user['User']);
            if(!empty($extra)){
                foreach($extra as $e=>$edata){
                    $notification[$e]=$edata;
                }
            }
            $this->save($notification);
        }
    }
    
    /*process notification email for implementor 
     * input: $task['group_name'],$task['id'],$task['name']
     */
    function sendImpEmail($task){
        //common data
        $data['Task']=$task;
        $data['Link']['task']=array('controller'=>'tasks','action'=>'view',$task['group_name'],'task_id'=>$task['id']);
        $role_list=$this->Task->Implementor->Role->find('list');
        
        $assign_template=$this->findNDelete('assign task',$task['id']);
        $deassign_template=$this->findNDelete('deassign task',$task['id']);
        $change_template=$this->findNDelete('change role',$task['id']);
        
        //old implementor
        $old=$this->whoWasImp($task['id']);
        
        //new implementor
        $new=array();
        $current_imp=$this->Task->Implementor->find('all',array('conditions'=>array('Implementor.task_id'=>$task['id'])));
        
        foreach($current_imp as $imp){
            if(!empty($imp['Implementor']['foreign_key'])){
                if($imp['Implementor']['model']=='Group2'){
                    $groupmember=$this->Task->Implementor->Group2->Group2sUser->find('all',array('conditions'=>array('Group2sUser.group2_id'=>$imp['Implementor']['foreign_key'])));
                    foreach($groupmember as $g){
                        $new[$g['Group2sUser']['user_id'].'/'.$g['Group2sUser']['group2_id']]=$imp['Implementor']['assign_as'];
                    }
                }else{
                    $new[$imp['Implementor']['foreign_key'].'/']=$imp['Implementor']['assign_as'];
                }
            }
        }
        
        $new_assign=array_diff_key($new,$old);
        $deassign=array_diff_key($old,$new);
        if(!empty($new_assign)){
            foreach($new_assign as $nkey=>$ndata){
                $data['Implementor']['as']=$role_list[$new[$nkey]];
                $this->processImpEmail($nkey,$new[$nkey],$data,$assign_template,$task['id']);
                unset($new[$nkey]);
            }
        }
        if(!empty($deassign)){
            foreach($deassign as $key=>$ddata){
                $data['Implementor']['as']=$role_list[$old[$key]];;
                $this->processImpEmail($key,0,$data,$deassign_template,$task['id']);
                unset($old[$key]);
            }
        }
        if(!empty($new)){
            foreach($new as $key=>$ddata){
                if($new[$key]!=$old[$key]){
                    $data['Implementor']['as']=$role_list[$new[$key]];
                    $data['oldImplementor']['as']=$role_list[$old[$key]];
                    $this->processImpEmail($key,$new[$key],$data,$change_template,$task['id']);
                }
                unset($new[$key]);
                unset($old[$key]);
            }
        } 
    }
    
    /*Process individual email
     * $recipient = $user_id.'/'.$group2_id
     * $info=$assign_as
     * $data=template place holder detail
     * $template
     * $task_id
     * 
     */
    function processImpEmail($recipient,$info,$data,$template,$task_id){
        $this->Task->Implementor->User->recursive=0;
        $this->Task->Implementor->Group2->recursive=-1;

        $data['you']=__('you',true);
        $data['your']=__('your',true);
            
        $userdata=explode('/',$recipient);
        $user=$this->Task->Implementor->User->read(null,$userdata[0]);
        if(!empty($userdata[1])){
            $group2=$this->Task->Implementor->Group2->read(null,$userdata[1]);
            $data['you']=$group2['Group2']['name'];
            $data['your']=$group2['Group2']['name']."'s";
        }
                
        $template['Template']['template']=$this->replacetemplate($template['Template']['template'],$data);
        $this->sendEmail($task_id,$template,$user,null,array('recipient'=>$recipient,'info'=>$info));
    }
    
    //send reminder
    function reminderEmail($group_name,$task,$data){
        $data['Task']=$task;
        $data['Link']['task']=array('controller'=>'tasks','action'=>'view',$group_name,'task_id'=>$task['id']);
        $template=$this->findNDelete('reminder',$task['id'],array('recipient'=>$data['Reminder']['user_id']));
        $template['Template']['template']=$this->replacetemplate($template['Template']['template'],$data);

        if($data['Reminder']['active'] == 1 && $data['Reminder']['remind_date']>=date('Y-m-d H:i:s')){
            $this->Task->Implementor->User->recursive=0;
            $user=$this->Task->Implementor->User->read(null,$data['Reminder']['user_id']);
            if($data['Reminder']['repeated']==1){
                $date=$this->Task->split_date($data['Reminder']['remind_date']);
                $before=$data['Reminder']['before'];
                while(!empty($before)){
                    $new_date=date('Y-m-d H:i:s',mktime($date[3],$date[4],$date[5],$date[1],$date[2]-$before,$date[0]));
                    if($new_date>=date('Y-m-d H:i:s')){
                        $this->sendEmail($task['id'],$template,$user,$new_date,array('recipient'=>$data['Reminder']['user_id']));
                    }
                    $before--;
                }
            }
            $this->sendEmail($task['id'],$template,$user,$data['Reminder']['remind_date'],array('recipient'=>$data['Reminder']['user_id']));
        }
    }
    
    //send email after comment or update status
    function toAllImpEmail($group_name,$task,$data,$key){
        $data['Task']=$task;
        $data['Link']['task']=array('controller'=>'tasks','action'=>'view',$group_name,'task_id'=>$task['id']);
        App::import('Model','Template');
        $this->Template = &new Template();
        $template=$this->Template->find('first',array('conditions'=>array('Template.model'=>'Task','Template.foreign_key'=>$task['id'],'Template.type'=>$key)));
        $template['Template']['template']=$this->replacetemplate($template['Template']['template'],$data);
        $this->Task->Implementor->recursive=-1;
        $imp=$this->Task->Implementor->find('all',array('conditions'=>array('Implementor.task_id'=>$task['id'])));
        $recipient=array();
        foreach($imp as $i){
            if($i['Implementor']['model']=='User'){
                $recipient[]=$i['Implementor']['foreign_key'];
            }else{
                $groupmember=$this->Task->Implementor->Group2->Group2sUser->find('all',array('conditions'=>array('Group2sUser.group2_id'=>$i['Implementor']['foreign_key'])));
                $recipient=array_merge($recipient,set::extract($groupmember,'{n}.Group2sUser.user_id'));
            }
        }
        $recipient=array_unique($recipient);
        foreach($recipient as $r){
            $this->Task->Implementor->User->recursive=0;
            $user=$this->Task->Implementor->User->read(null,$r);
            $this->sendEmail($task['id'],$template,$user);
        }
        
    }
    
    /* Find the template and delete the unsent notification data
     * $type=template type, $task_id, $conditions=>extra conditions
     * return template
     */
    function findNDelete($type,$task_id,$conditions=array()){
        //find template
        App::import('Model','Template');
        $template = &new Template();
        $wantedtemplate=$template->find('first',array('conditions'=>array('Template.model'=>'Task','Template.foreign_key'=>$task_id,'Template.type'=>$type)));
        
        $conditions=array_merge($conditions,array('Notification.notification_sent'=>0,'Notification.task_id'=>$task_id,'Notification.type'=>$type));
        //delete unsent
        $unsent=$this->find('first',array('conditions'=>$conditions));
        while(!empty($unsent)){
            $this->delete($unsent['Notification']['id']);
            $unsent=$this->find('first',array('conditions'=>array('Notification.notification_sent'=>0,'Notification.task_id'=>$task_id,'Notification.type'=>$type)));
        }
        return $wantedtemplate; 
    }
    
    
    /*find the implementor who receive the notification of task assigned 
     * 
     * $output:$old[$user_id.'/'.$group_id]=$as
     */
    function whoWasImp($task_id,$conditions=array()){
        $old=array();
        $this->recursive=-1;
        
        $conditions=array_merge($conditions,array('Notification.notification_sent'=>1,'Notification.task_id'=>$task_id,'Notification.type'=>array('assign task','deassign task','change role')));
        
        $sentByRecipient=$this->find('all',array(
            'conditions'=>$conditions,
            'fields'=>array('Notification.recipient','Notification.info'),
            'order'=>array('Notification.notification_date ASC')
        ));
        
        $old=set::combine($sentByRecipient,'{n}.Notification.recipient','{n}.Notification.info');
        $old=array_filter($old);
        
        return $old;
    }

}
?>
