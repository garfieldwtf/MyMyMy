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

class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form','Javascript');
	var $uses = array('User', 'Group', 'Notification','Template');
	var $paginate = array(
          'order'=>array(
            'User.id'=>'asc'));
    

	function index() {
        $this->layout='tab';
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
        $this->layout='tab';
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('User',true)));
			$this->redirect(array('action'=>'index'));
		}
        $user=$this->User->read(null, $id);
        $membership_group=set::extract($user['Membership'],'{n}.group_id');
        $user['Group']=$this->User->Membership->Group->find('all',array('conditions'=>array('Group.id'=>$membership_group)));
        foreach($user['Group'] as $g=>$group){
            $no=array_search($group['Group']['id'],$membership_group);
            $user['Group'][$g]['Membership']['head']=$user['Membership'][$no]['head'];
            $user['Group'][$g]['Membership']['admin']=$user['Membership'][$no]['admin'];
        }
		$this->set('user', $user);
	}

	function add($group_name=null) {
        $this->layout='tab';
		if (!empty($this->data)) {
			$this->User->create();
            $this->data['User']['password']=$this->Auth->password($this->data['User']['username']);
			if ($this->User->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('User',true)));
                if($group_name==null){
                    $this->redirect(array('action'=>'index'));
                }else{
                    $this->User->Membership->Create();
                    $membership['Membership']['head']=$this->data['User']['head'];
                    $membership['Membership']['admin']=$this->data['User']['admin'];
                    $membership['Membership']['group_id']=$this->curgroup['Group']['id'];
                    $membership['Membership']['foreign_key']=$this->User->getLastInsertId();
                    $membership['Membership']['model']='User';
                    $this->User->Membership->save($membership);
                    $this->redirect(array('controller'=>'memberships','action'=>'index',$group_name,'User'));
                }
			} else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('User',true)).__('Please try again.', true));
			}
		}

		$schemes=$this->User->Scheme->find('list');
		$grades = $this->User->Grade->find('list');
		$titles = $this->User->Title->find('list');
		$this->set(compact('schemes','grades','titles'));
	}

	function edit($id = null) {
        $this->layout='tab';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('User',true)));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('User',true)));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('User',true)).__('Please try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
        $schemes=$this->User->Scheme->find('list');
		$grades = $this->User->Grade->find('list');
		$titles = $this->User->Title->find('list');
		$this->set(compact('schemes','grades','titles'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('User',true)));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
            $this->Session->setFlash(sprintf(__('%s deleted', true),__('User',true)));
			$this->redirect(array('action'=>'index'));
		}
	}
	    
    function login(){
        $this->pageTitle = __("Login",true);
        $this->set('displaycaptcha',0);
        if (!empty($this->data['User'])) {
            $this->Session->write('trylogin',$this->Session->read('trylogin')+1);
            
            if(!$this->Auth->user('id')){ // wrong username/password
                $this->Session->SetFlash(__('Invalid username or password',true));
                
                //Check whether the account is locked
                $this->User->recursive=-1;
                $duser=$this->User->find('first',array('conditions'=>array('username'=>$this->data['User']['username'])));
                if(!empty($duser) && date('Y-m-d H:i:s',strtotime($duser['User']['locked']))>date('Y-m-d H:i:s')){
                    $this->Session->SetFlash(__('Your account is locked, please contact admin or superadmin to unlock',true));
                    $this->set('displaycaptcha',1);
                }elseif ($this->Session->read('trylogin') > 6){
                    if(!empty($duser)){
                        $duser['User']['locked']=date('Y-m-d H:i:s',mktime(date("H"),date("i")+configure::read('locked_period'),date("s"),date("m"),date("d"),date("Y")));
                        $this->User->save($duser);
                        $this->set('displaycaptcha',1);
                        $this->Session->SetFlash(__('Your account is locked, please contact admin or superadmin to unlock',true));
                    }
                }elseif ($this->Session->read('trylogin') > 4){
                    $this->set('displaycaptcha',1);
                    $this->Session->SetFlash(__('You have entered wrong code',true));
                }
                elseif ($this->Session->read('trylogin') > 3){
                    $this->set('displaycaptcha',1);
                } else {
                    $this->set('displaycaptcha',0);
                }
            }
        } elseif ($this->Auth->user('id')) {
            $this->Session->write('trylogin',0);
            $this->Session->del('securitycode');
            $this->redirect(array('controller'=>'users','action'=>'afterlogin'));
        }
    }
    
    function logout(){
        $this->Auth->logout();
        //$this->writelog(get_class($this),__FUNCTION__,"LOGGED OUT");
        $this->Session->del('lastvisitedpage');
        $this->Session->del('trylogin');
        $this->Session->SetFlash(__('Successfully logged out',true));
       
        $this->redirect(array('action'=>'login'));
    }
       
    /**
     * Describe profile
     *
     * @return null
     */
    function profile() {
        if (!$this->Auth->user('id')) {
            $this->Session->setFlash(sprintf(__('Invalid %s.',true),__('User',true)));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('profile',true)));
                $this->redirect(array('controller'=>'groups','action'=>'mainpage'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('profile',true)).__('Please try again.', true));
            }
        }
        if (empty($this->data)) {
			$this->data = $this->User->read(null, $this->Auth->user('id'));
		}
        $schemes=$this->User->Scheme->find('list');
		$grades = $this->User->Grade->find('list');
		$titles = $this->User->Title->find('list');
		$this->set(compact('schemes','grades','titles'));
        $this->set('data',$this->data);
    }
    
    function forgotpass(){
      if (!empty($this->data)) {
            $user = $this->User->find('first',array('conditions'=>array('email'=>$this->data['User']['email']),'contain'=>array('Title'),'fields'=>'User.*,Title.*'));
            if($user){
                $t = $this->Template->find('first',array('conditions'=>array('type'=>'reset password','model'=>'SystemOnly')));
                if($t){
                    $user['User']['newpassword']=$this->User->newpassword();
                    $user['User']['password']=$this->Auth->password($user['User']['newpassword']);
                    $this->User->save($user);
                    $this->Notification->sendEmail(null,$t,$user,null);
                    $this->Session->setFlash(__('Your request has been generated. Please check your email.', true));
                    $this->redirect(array('action'=>'login'));
                } 
            }else {
                $this->Session->setFlash(__('The email is not registered in the system.', true));
            }
        }    
    }
    
    function forgotuser() {
        if (!empty($this->data)) {
            $user = $this->User->find('first',array('conditions'=>array('email'=>$this->data['User']['email']),'contain'=>array('Title'),'fields'=>'User.*,Title.*'));
            if ($user) {
                $t = $this->Template->find('first',array('conditions'=>array('type'=>'forgot username','model'=>'SystemOnly')));
                $this->Notification->sendEmail(null,$t,$user,null);
                $this->Session->setFlash(__('Your username has been sent to your email.', true));
                $this->redirect(array('action'=>'login'));
            } else {
                $this->Session->setFlash(__('The email is not registered in the system.', true));
            }
        }
    }
    
    function captcha(){
        App::import('vendor','captcha');
        $captcha = new CaptchaSecurityImages();
        $code=$captcha->render();
        $this->Session->write('securitycode',$code);
    }
    
    //force to change password if user have the password which same with username
    function forcechangepassword() {
        if (!empty($this->data)) {
            if ($this->data['User']['newpassword'] !=$this->data['User']['confirmpassword']){
                $this->Session->setFlash(__('Your password does not match.', true));
            }elseif(strlen($this->data['User']['newpassword'])<4){
                $this->Session->setFlash(__('Password', true).': '.__('minimum length should be 4.', true));
            } else {
                $this->data['User']['id'] = $this->Auth->user('id');
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['newpassword']);
                if ($this->User->save($this->data,false)){
                    $this->Session->setFlash(__('Your password has been changed',true));
                    $a=$this->Session->read('lastvisitedpage');
                    if (!empty($a) && $a!='/') { // if user not coming from root url
                        $this->redirect('/'.$this->Session->read('lastvisitedpage'));
                    } else {
                        $this->redirect(array('action'=>'mainpage','controller'=>'groups'));
                    }
                }
            }
        }
    }
    
    //decide where to go after login
    function afterlogin(){
        $duser=$this->User->find('first',array('conditions'=>array('username'=>$this->Auth->user('username'))));
        if($duser['User']['password']==$this->Auth->password($this->Auth->user('username'))){
            $this->redirect(array('controller'=>'users','action'=>'forcechangepassword'));
        }else{
            $a=$this->Session->read('lastvisitedpage');
            if(!empty($a) && $a!='/' && $a!='/Array'){
                $this->redirect('/'.$this->Session->read($a));
            }else{
                $this->redirect(array('action'=>'mainpage','controller'=>'groups'));
            }
        }
    }
    
    //change own password by user
    function changepassword(){
        if (!empty($this->data)) {
            $someone = $this->User->findById($this->Auth->user('id'));
            if(($this->Auth->password($this->data['User']['oldpassword'])) != $someone['User']['password']) {
                $this->Session->setFlash(__('Your old password is invalid.', true));
            }elseif(strlen($this->data['User']['newpassword'])<4){
                $this->Session->setFlash(__('Password', true).': '.__('minimum length should be 4.', true));
            }elseif($this->data['User']['newpassword'] !=$this->data['User']['confirmpassword']){
                $this->Session->setFlash(__('Your password does not match.', true));
            } else {

                $this->data['User']['id'] = $this->Auth->user('id');
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['newpassword']);
                if ($this->User->save($this->data,false)){
                    $this->Session->setFlash(__('Your password has been changed',true));
                    $this->redirect(array('action'=>'profile'));
                }
            }
        }
    }
    
    function resetpass($id = null) {
        $this->data['User']['id'] = $id;
        $someone = $this->User->findById($id);
        $someone['User']['password'] = $this->Auth->password($someone['User']['username']);
        $someone['User']['locked'] =null;
        if ($this->User->save($someone,false)){
            $someone['User']['newpassword'] = $someone['User']['username']; 
            $t = $this->Template->find('first',array('conditions'=>array('type'=>'reset password','model'=>'SystemOnly')));
            $this->Notification->sendEmail(null,$t,$someone,null);
            $this->Session->setFlash(sprintf(__('Password for %s has been reset and emailed',true),$someone['User']['username']));
            $this->redirect(array('action'=>'index'));
        }
    }
    
    function unlock($id,$group=null){
        $user=$this->User->findById($id);
        $user['User']['locked'] =null;
        if($this->data['User']['reset']==1){
            $user['User']['password'] = $this->Auth->password($user['User']['username']);
            if ($this->User->save($user,false)){
                $user['User']['newpassword'] = $user['User']['username']; 
                $t = $this->Template->find('first',array('conditions'=>array('type'=>'reset password','model'=>'SystemOnly')));
                $this->Notification->sendEmail(null,$t,$user,null);
                $this->Session->setFlash(sprintf(__('Password for %s has been reset and emailed',true),$user['User']['username']));
            }
        }else{
            if ($this->User->save($user,false)){
                $this->Session->setFlash(sprintf(__('Account for %s has been unlocked',true),$user['User']['username']));
            }
        }
        if(!empty($group)){
            $this->redirect(array('controller'=>'memberships','action'=>'index',$group,'User'));
        }
        $this->redirect(array('action'=>'index'));
    }
    
    
    //ical
    function cal(){
        $name='Task Manager -'.$this->Auth->user('name');
        $this->User->create_cal($this->Auth->user());
        
        header( 'Content-Type: text/calendar; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename="'.$name.'.ics"' );
        header( 'Cache-Control: max-age=10' );
        readfile(WWW_ROOT . 'upload' . DS . 'ics'. DS . $name.'.ics');
        exit();
    }
    
    function browser(){
    }
    
}  

?>
