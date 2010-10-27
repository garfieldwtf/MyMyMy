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

class User extends AppModel {

	var $name = 'User';
	var $validate = array(
        'username'=>array('length'=>array('rule'=>array('minLength',4)),'isUnique'=>array('rule'=>'isUnique'),'notEmpty'=>array('rule'=>'notEmpty'),'character'=>array('rule' => array('custom', '/^[\da-zA-Z_]+$/'))),
        'name'=>array('notEmpty'=>array('rule'=>'notEmpty')),
        'email'=>array(
            'format'=>array(
                'rule' => 'email',
            ),
            'email Unique'=>array(
                'rule' => array(
                    'isUnique',
                    'email'
                ),
            )
        ),'telephone'=> array(
            'format'=>array(
                'rule' => array(
                    'custom',
                    '/[0-9]{2}[- ]?[0-9]{6,8}$/i'
                ),
                //'required' => true,
                //'message' => 'Telephone required eg: 03-12345213',
                'allowEmpty'=>true
            )
        ),
        'mobile'=> array(
            'format'=>array(
                'rule' => array(
                    'custom','/[0-9]{3}[- ]?[0-9]{7}$/i'
                ),
                //'message' => 'Please supply valid mobile number eg: 013-1234521312',
                'allowEmpty'=>true
            )
        ),
        'fax'=> array(
            'format'=>array(
                'rule' => array(
                    'custom','/[0-9]{2}[- ]?[0-9]{6,8}$/i'
                ),
                //'message' => 'Please supply valid fax number eg: 013-1234521312',
                'allowEmpty'=>true
            )
        )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Grade' => array(
			'className' => 'Grade',
			'foreignKey' => 'grade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Title' => array(
			'className' => 'Title',
			'foreignKey' => 'title_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Scheme' => array(
			'className' => 'Scheme',
			'foreignKey' => 'scheme_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Implementor' => array(
			'className' => 'Implementor',
			'foreignKey' => 'foreign_key',
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
		
		'Membership' => array(
			'className' => 'Membership',
			'foreignKey' => 'foreign_key',
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
        'Group2sUser' => array(
			'className' => 'Group2sUser',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
    
    function afterSave($created) {
        if ($created && !isset($this->data['User']['dontsend'])) {
            // send notification email to user
            App::import('Model',array('Notification','Template'));
            $notify = &new Notification();
            $template = &new Template();
            $templ=$template->find(array('model'=>'SystemOnly','type'=>'new account'));
            $this->data['User']['newpassword']=$this->data['User']['username'];
            $this->data['User']['Link']['newaccount']=array('controller'=>'users','action'=>'login');
            $this->Title->recursive=-1;
            $title=$this->Title->find('first',array('conditions'=>array('id'=>$this->data['User']['title_id'])));
            $this->data['Title']=$title['Title'];
            $notify->sendEmail(0,$templ,$this->data,null);
        }
    }
    
    //create newpassword
    function newpassword(){
        $rand_id = "";
        $char = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','x','y','z',
                '1','2','3','4','5','6','7','8','9',
                'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','X','Y','Z'
                );
        for($i=1; $i<=6; $i++) {
            $rand_id .= $char[mt_rand(0,count($char)-1)];
        }
        return $rand_id;
    }
    
    
    //create ics
    function create_cal($user){
        require_once('vendors/iCalcreator.class.php');
        $name='Task Manager -'.$user['User']['name'];
        
        //find group2 involved
        $group=$this->Group2sUser->find('all',array('conditions'=>array('Group2sUser.user_id'=>$user['User']['id'])));
        //find all task involved
        $this->Implementor->recursive=-1;
        $imp_task=$this->Implementor->find('all',array('conditions'=>array('or'=>array(array('Implementor.foreign_key'=>$user['User']['id'],'Implementor.model'=>'User'),array('Implementor.foreign_key'=>set::extract($group,'{n}.Group2sUser.group2_id'),'Implementor.model'=>'Group2')))));
        $tasks=$this->Implementor->Task->find('all',array('conditions'=>array('Task.id'=>set::extract($imp_task,'{n}.Implementor.task_id'))));

        $folder = WWW_ROOT . 'upload' . DS . 'ics'. DS;
        if (!is_dir($folder)) {
            $f = new Folder;
            $f->create(WWW_ROOT . 'upload' . DS . 'ics');
        }
        
        $dfile = WWW_ROOT . 'upload' . DS . 'ics'. DS . 'sequence.txt';
        if (file_exists($dfile)) {
            $handle = fopen($dfile, "r");
            $contents = fread($handle, filesize($dfile));
            fclose($handle);
            $sequence = $contents + 1;
        } else { 
            $sequence = 0;
        }
        $f = new File($dfile);
        $f->create($dfile);
        $f->write($sequence);
        
        $v = new vcalendar();
        $v->setConfig('URL',Router::url('/'.$name.'.ics'));
        $v->setProperty('method', 'PUBLISH');
        $v->setProperty('x-wr-calname', 'Task Manager Calendar');
        $v->setProperty("X-WR-CALDESC", 'tasks');
        $v->setProperty("X-WR-TIMEZONE", 'Asia/Kuala_Lumpur');
        $this->calendar = $v;
        
        foreach($tasks as $task){
            $start = strtotime($task['Task']['start_date']);
            $end = strtotime($task['Task']['end_date']);
        
            $vevent = new vevent();
            $start = getdate($start);
            $a_start['year'] = $start['year'];
            $a_start['month'] = $start['mon'];
            $a_start['day'] = $start['mday'];
            $a_start['hour'] = $start['hours'];
            $a_start['min'] = $start['minutes'];
            $a_start['sec'] = $start['seconds'];
            $vevent->setProperty('dtstart', $a_start);
            
            $end = getdate($end);
            $e_start['year'] = $end['year'];
            $e_start['month'] = $end['mon'];
            $e_start['day'] = $end['mday'];
            $e_start['hour'] = $end['hours'];
            $e_start['min'] = $end['minutes'];
            $e_start['sec'] = $end['seconds'];
            
            $vevent->setProperty('dtend', $e_start);
            $vevent->setProperty('summary', $task['Group']['name'].' - '.$task['Task']['task_name']);
            $vevent->setProperty('description', 'More detail: http://'.$_SERVER['SERVER_NAME'].Router::url('/tasks/view/'.$task['Group']['name'].'/'.$task['Task']['id']));
            $vevent->setProperty('sequence',$sequence);
            $extra=array('UID'=>'/tasks/view/'.$task['Group']['name'].'/'.$task['Task']['id'], 'location'=>Configure::read('agency_address'));
            foreach($extra as $key=>$value){
                $vevent->setProperty($key, $value);
            }
        
            $this->calendar->setComponent($vevent);
        }
        
        $this->calendar->saveCalendar($folder ,$name.'.ics',false);
        
        return false;
    }
}
?>
