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

class TasksController extends AppController {

	var $name = 'Tasks';
	var $helpers = array('Html', 'Form', 'Ajax', 'Javascript', 'DatePicker','MultiFile','MultiItem','Text','CurLink');
    var $components = array('RequestHandler','MultiFile');

  function calendar($group_name=null) {
    $this->Task->recursive = 1;
    $this->Task->Behaviors->detach('MultiFile');
    $this->Task->unbindModel(array('hasMany' => array('Notification','Status','Comment')),false);
    $this->Task->unbindModel(array('hasAndBelongsToMany' => array('Client','Category','Project','Meeting')),false);
    
    $this->paginate=array('limit'=>1000);

    //set year and month when go to the next month
    if (isset($this->params['pass'][2])){
        $__year = $this->params['pass'][1];
        $__month = $this->params['pass'][2];
    }elseif(isset($this->params['pass'][1]) && empty($this->curgroup)) {
        $__year = $this->params['pass'][0];
        $__month = $this->params['pass'][1];
    } else {
        $__year = date('Y');
        $__month = date('n');
    } 
    $this->set('year',$__year);
    $this->set('month',$__month);
    $this->set('date',date('j'));
    if(empty($this->curgroup)){
        $group=$this->User->Group2sUser->find('all',array('conditions'=>array('Group2sUser.user_id'=>$this->Auth->user('id'))));
        $imp=$this->Task->Implementor->find('all',array('conditions'=>array('or'=>array(array('Implementor.foreign_key'=>$this->Auth->user('id'),'Implementor.model'=>'User'),array('Implementor.foreign_key'=>set::extract($group,'{n}.Group2sUser.group2_id'),'Implementor.model'=>'Group2')))));
        $imp_task=set::extract($imp,'{n}.Implementor.task_id');
        $tasks=$this->paginate('Task',array('Task.id'=>$imp_task,'or'=>array(array('month(Task.end_date)'=>$__month,'year(Task.end_date)'=>$__year),array('month(Task.start_date)'=>$__month,'year(Task.start_date)'=>$__year))));
        $this->set('month_link','calendar/');
        $this->set('day_link','calendar/');

        foreach($tasks as $t=>$task){
            $tasks[$t]['Task']['task_name']=$task['Group']['name'].'-'.$task['Task']['task_name'];
            $tasks[$t]['view']=1;
        }
    }else{
        $tasks=$this->paginate('Task',array('Task.group_id'=>$this->curgroup['Group']['id'],'or'=>array(array('month(Task.end_date)'=>$__month,'year(Task.end_date)'=>$__year),array('month(Task.start_date)'=>$__month,'year(Task.start_date)'=>$__year))));
        $this->set('month_link','calendar/'.$this->curgroup['Group']['name'].'/');
        $this->set('day_link','calendar/'.$this->curgroup['Group']['name'].'/');
        foreach($tasks as $t=>$task){
            if(!empty($this->curmember['Membership']['admin']) || isset($this->curmember['Membership']['head'])){
                $tasks[$t]['view']=1;
            }else{
                $user_id=set::extract($task,'Implementor.{n}.user_id');
                if(!empty($user_id) && in_array($this->Auth->user('id'),$user_id)){
                    $tasks[$t]['view']=1;
                }else{
                    $tasks[$t]['view']=0;
                }
            }
        }
    }
    //find the task with the start and end date
    $taskwdate=array();
    foreach($tasks as $t=>$task){
        $task[1]='start';
        $startdate = explode(' ',$task['Task']['start_date']);
        $enddate = explode(' ',$task['Task']['end_date']);
        if($enddate[0]==$startdate[0]){
            $task[1].=',end';
            $taskwdate[$startdate[0]][]=$task;
        }else{
            $taskwdate[$startdate[0]][]=$task;
            $task[1]='end';
            $taskwdate[$enddate[0]][]=$task;
        }
    }
    $this->set('tasks',$taskwdate);
  }


	function view($group_name) {
        $task_id=$this->params['named']['task_id'];
        $this->Task->recursive=1;
        $this->Task->unbindmodel(array('hasMany'=>array('Notification')));
        $task=$this->Task->read(null, $task_id);
        
        if (!$task) {
            $this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Task',true)));
			$this->redirect(array('action'=>'calendar',$group_name));
		}
        
        if(!empty($task['Implementor'])){
            //find implementor
            $implementor=$this->Task->Implementor->AssignAs($task);
            $this->set('implementor',$implementor);
            
            //process implementor as user list and group2 list
            $ukey=$udata=$gkey=$gdata=$user=$group2=array();
            foreach($implementor as $imp){
                if(!empty($imp['User'])){
                    $ukey=array_merge($ukey,array_keys($imp['User']));
                    $udata=array_merge($udata,array_values($imp['User']));
                }
                if(!empty($imp['Group2'])){
                    $gkey=array_merge($gkey,array_keys($imp['Group2']));
                    $gdata=array_merge($gdata,array_values($imp['Group2']));
                }
            }
            if(!empty($ukey)){$user=array_combine($ukey,$udata);}
            if(!empty($gkey)){$group2=array_combine($gkey,$gdata);}
            $this->set(compact('user','group2'));
        }
        $this->set('role',$this->Task->Implementor->Role->find('list'));
        $this->set('task_permission',$this->task_permission($group_name,$task_id,1));

        //reminder
        $this->loadModel('Reminder');
        $reminder=$this->Reminder->find('first',array('conditions'=>array('Reminder.task_id'=>$task_id,'Reminder.user_id'=>$this->Auth->user('id'))));
        if(!empty($reminder)){
            $remind_date=$this->Task->split_date($reminder['Reminder']['remind_date']);
            $reminder['Reminder']['send_date']=date('Y-m-d H:i:s',mktime($remind_date[3],$remind_date[4],$remind_date[5],$remind_date[1],$remind_date[2]-$reminder['Reminder']['before'],$remind_date[0]));
            $this->set('reminder',$reminder);
        }
        
        //set status user name
        if(!empty($task['Status'][0])){
            if(!empty($user[$task['Status'][0]['user_id']])){
                $task['Status'][0]['updater_name']=$user[$task['Status'][0]['user_id']];
            }else{
                $this->User->recursive=-1;
                $name=$this->User->read('name',$task['Status'][0]['user_id']);
                $task['Status'][0]['updater_name']=$name['User']['name'];
            }
        	if(!empty($task['Status'][0]['group2_id'])){
                if(!empty($group2[$task['Status'][0]['group2_id']])){
                    $task['Status'][0]['updater_name'].=' ('.$group2[$task['Status'][0]['group2_id']].')';
                }else{
                    $name=$this->Task->Implementor->Group2->read('name',$task['Status'][0]['group2_id']);
                    $task['Status'][0]['updater_name'].='('.$name['Group2']['name'].')';
                }
			}
		}
         //set comment user name
        if(!empty($task['Comment'])){
            foreach($task['Comment'] as $c=>$comment){
                if(!empty($user[$comment['user_id']])){
                    $task['Comment'][$c]['user']=$user[$comment['user_id']];
                }else{
                    $this->User->recursive=-1;
                    $name=$this->User->read('name',$comment['user_id']);
                    $task['Comment'][$c]['user']=$name['User']['name'];
                }
                if(!empty($comment['group2_id'])){
                    if(!empty($group2[$comment['group2_id']])){
                        $task['Comment'][$c]['user'].=' ('.$group2[$comment['group2_id']].')';
                    }else{
                        $group2=$this->Task->Implementor->Group2->read('name',$comment['group2_id']);
                        $task['Comment'][$c]['user'].=' ('.$group2['Group2']['name'].')';
                    }
                }
            }
		}

		$this->set('task',$task );
        
        //parent task
        if(!empty($this->curimp[1])){
            $this->Task->recursive=0;
            $this->set('ptask',$this->Task->find('first',array('conditions'=>array('Task.id'=>$task['Task']['parent_id']))));
        }
        $this->Task->Group->Membership->recursive=-1;
        $this->set('head_group',$this->Task->Group->Membership->head_group($this->Auth->user('id'),set::extract($this->curmember,'Group.{n}.id'),$task));
	}
	
	function delete($group_name) {
		if (!($this->params['named']['task_id'])) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Task',true)));
			$this->redirect(array('action'=>'calendar',$group_name));
		}
        if($this->Task->deleteRelate($this->params['named']['task_id'])){
            $this->Session->setFlash(sprintf(__('%s deleted', true),__('Task',true)));
			$this->redirect(array('action'=>'calendar',$group_name));
        }
	}

    function sorting($group_name,$search=null) {
        $date=date('Y-m-d');
        $this->Task->recursive = 1;
        $this->Task->Behaviors->detach('MultiFile');
        $this->Task->unbindModel(array('hasMany' => array('Notification','Comment' )),false);
        $this->Task->unbindModel(array('hasAndBelongsToMany' => array('Client','Category','Project','Meeting')),false);
        $this->Task->bindModel(array('hasOne'=>array('Status')));
        //task that not expired data and not closed
        if ($search == 'upcoming'){
            $data = $data = $this->paginate('Task',array('Task.end_date >=' => $date,'Task.group_id'=>$this->curgroup['Group']['id']));
        }
    
        //task that expired date 
        if ($search == 'previous') {
            $data = $this->paginate('Task',array('Task.end_date <' => $date,'Task.group_id'=>$this->curgroup['Group']['id']));
        }
        
        //task that expired date and not closed
        if ($search == 'outstanding'){
            $data = $this->paginate('Task',array('Task.end_date <' => $date,'Task.group_id'=>$this->curgroup['Group']['id']));
            foreach($data as $d=>$dat){
                if(!empty($dat['Status'][0]['closed'])){
                    unset ($data[$d]);
                }
            }
        }
        foreach($data as $d=>$dat){
            if($this->curmember['Membership']['head'] || $this->curmember['Membership']['admin']){
                $data[$d]['view']=1;
            }else{
                if($this->curimp($dat['Group']['name'],$dat['Task']['id'])){
                    $data[$d]['view']=1;
                }else{
                    $data[$d]['view']=0;
                }
            }
        }
        $this->set('sortings',$data);
    }
    
    //1st step to add/edit task
    function basic($group_name){
        if (!empty($this->data)) {
            if(!empty($this->params['named']['task_id'])){
                $this->data['Task']['id']=$this->params['named']['task_id'];
            }else{
                $this->Task->create();
            }
			if ($this->Task->save($this->data)) {
                if(empty($this->params['named']['task_id'])){
                    $this->data['Task']['id']=$this->Task->getLastInsertId();
                    $this->loadModel('Template');
                    $this->Template->duplicate(array('Template.model'=>'Group','Template.foreign_key'=>$this->curgroup['Group']['id']),'Task',$this->data['Task']['id']);
                    $this->data['Task']['group_name']=$group_name;
                    $this->Task->Implementor->AutoHead($this->data,$this->Auth->user('id'),set::extract($this->curmember['Group'],'{n}.id'));
                }else{
                    $user_imp=$this->Task->Implementor->find('all',array('conditions'=>array('Implementor.task_id'=>$this->params['named']['task_id'],'Implementor.model'=>'User')));
                    foreach($user_imp as $imp){
                        $this->Task->Implementor->User->create_cal($imp);
                    }
                    $group_id=set::extract($this->Task->Implementor->find('all',array('conditions'=>array('Implementor.task_id'=>$this->params['named']['task_id'],'Implementor.model'=>'Group2'))),'{n}.Implementor.foreign_key');
                    $this->User->Group2sUser->bindmodel(array('belongsTo'=>array('User')));
                    foreach($this->User->Group2sUser->find('all',array('conditions'=>array('not'=>array('Group2sUser.user_id'=>set::extract($user_imp,'{n}.User.id')),'Group2sUser.group2_id'=>$group_id))) as $imp){
                        $this->Task->Implementor->User->create_cal($imp);
                    }
                }
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Basic information of Task',true)));
                $this->redirect(array('action'=>'imp',$group_name,'task_id'=>$this->data['Task']['id']));
            }
        }
        if(!empty($this->params['named']['task_id'])){
            $this->Task->recursive=-1;
            $this->data=$this->Task->find('first',array('conditions'=>array('Task.id'=>$this->params['named']['task_id'])));
        }
    }
    
    //last step to add/edit task
    function additional($group_name){
        $mpcc=array('meeting','category','project','client');
        if(!empty($this->data)){
            $this->data['Task']['id']=$this->params['named']['task_id'];
            if ($this->Task->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Additional info of Task',true)));
                $this->data['Task']['group_id']=$this->curgroup['Group']['id'];
                $this->data=$this->Task->multiItem($this->data['Task']['id'],$this->data,$mpcc);
                $this->redirect(array('action'=>'view',$group_name,'task_id'=>$this->params['named']['task_id']));
            }
        }

        $this->Task->unbindModel(array('hasMany'=>array('Notification','Comment','Status','Implementor')));

        $this->data=$this->Task->find('first',array('conditions'=>array('Task.id'=>$this->params['named']['task_id'])));
        
        //the options for meeting,category,project,client
        foreach($mpcc as $field){
            $this->set(Inflector::pluralize($field),$this->Task->{ucfirst($field)}->find('list',array('conditions'=>array('group_id'=>$this->curgroup['Group']['id']))));
            if(!empty($this->data[ucfirst($field)])){
                $id=Set::extract($this->data[ucfirst($field)],'{n}.id');
                $name=Set::extract($this->data[ucfirst($field)],'{n}.name');
                $this->set($field.'_sel',array_combine($id,$name));
            }else{
                $this->set($field.'_sel',array());
            }
        }
    }
    
    //assign implementor page
    function imp($group_name){
        $this->Task->Behaviors->detach('MultiFile');
        $task_permission=$this->task_permission($group_name,$this->params['named']['task_id'],1);
        $curimp=$this->curimp;
        $this->set('can_add',in_array('tasks/additional',$task_permission));
        $this->set('role',$this->Task->Implementor->Role->find('list'));
        if(!empty($this->data)){
            if(!empty($this->data['Task']['head'])){$imp[1]=$this->data['Task']['head'];}
            if(isset($this->data['imp2']))$imp[2]=$this->data['imp2'];
            if(isset($this->data['imp3']))$imp[3]=$this->data['imp3'];
            if(isset($this->data['imp4']))$imp[4]=$this->data['imp4'];
            if(isset($imp)){
                $this->Task->Implementor->AssignImplementor($this->params['named']['task_id'],$imp);
            }
            $this->Task->bindmodel(array('hasMany'=>array('Notification')));
            $data=$this->Task->find('first',array('conditions'=>array('Task.id'=>$this->params['named']['task_id'])));
            $data['Task']['group_name']=$group_name;
            $this->Task->Notification->sendImpEmail($data['Task']);
            $this->Session->setFlash(__('The Task had been assigned', true));
            
            
            if(in_array('tasks/additional',$task_permission)){
                $this->redirect(array('action'=>'additional',$group_name,'task_id'=>$this->params['named']['task_id']));
            }elseif(!empty($curimp) || !empty($this->curmember['Membership']['head']) || !empty($this->curmember['Membership']['admin'])){
                $this->redirect(array('action'=>'view',$group_name,'task_id'=>$this->params['named']['task_id']));
            }else{
                $this->redirect(array('action'=>'calendar',$group_name));
            }
        }
        
        $this->Task->unbindModel(array('hasMany'=>array('Notification','Comment','Status')));
        $this->Task->unbindModel( array('hasAndBelongsToMany' => array('Client','Meeting','Project','Category')) );

        $this->data=$this->Task->find('first',array('conditions'=>array('Task.id'=>$this->params['named']['task_id'])));
        
        //implementor
        $implementor=$this->Task->Implementor->AssignAs($this->data);
		$this->set('implementor',$implementor);
		
		//options for implementor 
        $this->Task->Group->Membership->recursive=0;

		$this->set('head',$this->Task->Group->Membership->lists2($this->Task->Group->Membership->find('all',array('conditions'=>array('group_id'=>$this->curgroup['Group']['id'],'Membership.head'=>1))),'Membership'));
        $umembers=$this->Task->Group->Membership->lists($this->Task->Group->Membership->find('all',array('conditions'=>array('group_id'=>$this->curgroup['Group']['id'],'Membership.model'=>'User','Membership.head'=>0))),'Membership');
        $gmembers=$this->Task->Group->Membership->lists($this->Task->Group->Membership->find('all',array('conditions'=>array('group_id'=>$this->curgroup['Group']['id'],'Membership.model'=>'Group2','Membership.head'=>0))),'Membership');
		$selected[2]=$selected[3]=$selected[4]=array();
		$m_selected=array();
		$g_selected=array();
		foreach($implementor as $i=>$data){
			if($i<=$this->curimp['highest'] && $i>1){
				//unset the selected member in options
				if(!empty($data['User'])){
					foreach($data['User'] as $u=>$udata){
						unset($umembers[$u]);
					}
				}
				if(!empty($data['Group2'])){
					foreach($data['Group2'] as $g=>$gdata){
						unset($gmembers[$g]);
					}
				}
			}
			if($i>=$this->curimp['highest']){
				//selected value
				foreach($data as $dmodel=>$d){
					foreach($d as $dkey=>$ddata){
						if($dmodel=='User'){
							$m_selected[$dkey]=$ddata;
						}
						if($dmodel=='Group2'){
							$g_selected[$dkey]=$ddata;
						}
						$selected[$i][$dmodel.$dkey]=$ddata;
					}
				}
			}
            
		}
        if($this->curimp['highest']==1){
            foreach($implementor[1] as $imodel=>$i){
                foreach($i as $id=>$idata){
                    $this->data['Task']['head']=$imodel.$id;
                }
            }
        }
		$this->set('umembers',$umembers);
		$this->set('gmembers',$gmembers);
		$this->set('m_selected',$m_selected);
		$this->set('g_selected',$g_selected);
		$this->set('selected',$selected);
		
    }
    
    //function to search keyword
    function getmultidata() {
        Configure::write('debug', 0); // dont want debug in ajax returned html
        if ($this->RequestHandler->isAjax()) {
            $this->set('multi_data',$this->Task->keyword_search($this->data['Search']['text'],$this->Auth->user('id')));
            $this->set('dtext',$this->data['Search']['text']);
            $this->render('getmultidata','ajax');
        }
    }
    
    //keyword search page
    function keyword(){
        $this->set('dtext',$this->data['Search']['text']);
        $this->set('multi',$this->Task->keyword_search($this->data['Search']['text'],$this->Auth->user('id')));
    }
    
    //function to copy task to another group
    function copy($group_name){
        Configure::write('debug', 0);
        if(empty($this->data)){
            
            //group selection
            $this->Task->recursive=-1;
            $task=$this->Task->read(null,$this->params['named']['task_id']);
            
            $this->Task->Group->Membership->recursive=0;
            $head_group=$this->Task->Group->Membership->head_group($this->Auth->user('id'),set::extract($this->curmember,'Group.{n}.id'),$task);
            $group_id=set::extract($head_group['available'],'{n}.Group.id');
            $group_names=set::extract($head_group['available'],'{n}.Group.group_name');
            $this->set('agroup',array_combine($group_id,$group_names));
        }else{
            //copy task
            $task=$this->Task->find('first',array('conditions'=>array('Task.id'=>$this->params['named']['task_id'])));
            unset($task['Task']['id']);
            $this->Task->create();
            $task['Task']['group_id']=$this->data['Task']['group_id'];
            $task['Task']['parent_id']=$this->params['named']['task_id'];
            $this->Task->save($task);
            
            $task['Task']['id']=$this->Task->getLastInsertId();
            $task['Task']['group_name']= $group_name;
            
            $this->loadModel('Template');
            $this->Template->duplicate(array('Template.model'=>'Group','Template.foreign_key'=>$task['Task']['group_id']),'Task',$task['Task']['id']);
            
            $this->Task->Implementor->AutoHead($task,$this->Auth->user('id'),set::extract($this->curmember['Group'],'{n}.id'));

            $this->Session->setFlash(__('The Task has been copied', true));
            $group=$this->Task->Group->find('first',array('conditions'=>array('Group.id'=>$this->data['Task']['group_id'])));
            $this->redirect(array('action'=>'basic',$group['Group']['name'],'task_id'=>$task['Task']['id']));    
        }
        $this->set('task_id',$this->params['named']['task_id']);
        
    }
    
    //function to go child task (if have >1 child task)
    function childtask($group_name,$task_id){
        Configure::write('debug', 0);
        if(empty($this->data)){
            //group selection
            $this->Task->recursive=0;
            $task=$this->Task->read(null,$task_id);
            
            $this->Task->Group->Membership->recursive=-1;
            $head_group=$this->Task->Group->Membership->head_group($this->Auth->user('id'),set::extract($this->curmember,'Group.{n}.id'),$task);
            $task_id=set::extract($head_group['subtask'],'{n}.Task.id');
            $group_name=set::extract($head_group['subtask'],'{n}.Group.group_name');
            $this->set('agroup',array_combine($task_id,$group_name));
        }else{
            //redirect
            if($this->data['Task']['id']){
                $sub=$this->Task->read(null,$this->data['Task']['id']);
                $this->redirect(array('action'=>'view',$sub['Group']['name'],'task_id'=>$sub['Task']['id']));  
            }   
        }
        $this->set('task_id',$task_id);
    }
}
?>
