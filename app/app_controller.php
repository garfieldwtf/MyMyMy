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
class AppController extends Controller {

    var $components = array('Auth','RequestHandler');
    var $uses = array('Task','User');  
    var $helpers = array('Html','Javascript','Form','Ajax','CurLink');
    var $dtasks = null;
    
    function beforeFilter(){
        $this->Auth->allow(array('browser'));
        if($this->params['action']!='browser' && strpos($_SERVER['HTTP_USER_AGENT'],'IE 6')){
           
            $this->redirect(array('controller'=>'users','action'=>'browser'));
        }
        
        //check whether the installation is done
        $dfile= ROOT . DS . 'app/config/tm.php';
        $file = new File($dfile);
        $tm=$file->exists();
        
        if(empty($tm)){
             $this->Auth->allow(array('install','dircheck','database','language','syssettings','success'));
             if($this->params['controller']!='installers'){
                 $this->redirect(array('controller'=>'installers','action'=>'install'));
             }

        }else{
            if($this->params['controller']=='installers' && !in_array($this->params['action'],array('success','syssettings'))){
                $this->notallow(1);
            }
        }

        if(!empty($this->data['User']['username'])){
            $duser=$this->User->find('first',array('conditions'=>array('username'=>$this->data['User']['username'])));
            if(!empty($duser) && date('Y-m-d H:i:s',strtotime($duser['User']['locked']))>date('Y-m-d H:i:s')){
                $this->data['User']['password']=null;
            }
        }

        $this->Auth->loginAction=array('controller'=>'users','action'=>'login');
        $this->Auth->loginRedirect=array('controller'=>'users','action'=>'afterlogin');
        $this->Auth->logoutRedirect=array('controller'=>'users','action'=>'login');
        $this->Auth->loginError=(__('Invalid username or password',true));
        $this->Auth->authorize='controller';
        $this->Auth->allow(array('captcha','forgotpass','forgotuser','syssettings','success'));

        // check captcha
        if($this->Session->read('trylogin')>3){       
            if ($this->Session->check('securitycode') && $this->params['url']['url'] != 'logout' && $this->params['url']['url'] != 'users/captcha') {
                if (!empty($this->data['User']['captcha'])  && $this->data['User']['captcha'] == $this->Session->read('securitycode')) {
                    $this->Session->write('passcaptcha',1);
                    $this->Session->write('redirected',0);
                    $this->Session->del('securitycode');
                } else {
                    $this->Session->SetFlash(__('You have entered wrong code',true));
                    $this->Session->write('passcaptcha',0);
                    $this->Session->write('redirected',1);
                    $this->Session->del('securitycode');
                    $this->data['User']['password']='';
                }
            } 
        }

        // set the page user will be redirected to after captcha & changing password
        if ((!in_array($this->params['url']['url'],array('','login','/','Users/login','Users/logout','users/forcechangepassword','users/afterlogin','users/forgotpass','users/forgotuser','user/login','users/captcha'))) && !in_array($this->params['controller'],array('installers')) ){
            $this->Session->write('lastvisitedpage',$this->params['url']['url']);
        }
        
        //check the permission
        if($this->Auth->user()){
            
            $this->set('curuser',$this->Auth->user());
            
            //group
            if(!empty($this->params['pass'][0])){
                $this->loadModel('Group');
                $this->Group->recursive=-1;
                $this->curgroup=$this->Group->find('first',array('conditions'=>array('Group.name'=>$this->params['pass'][0])));
                $this->set('curgroup',$this->curgroup);
                if(!empty($this->curgroup)){
                	$this->curmember=$this->curmembership($this->curgroup['Group']['id'],1);
                	$this->set('curmember',$this->curmember);
                	
                	if(!empty($this->params['named']['task_id'])){
                		$this->curimp=$this->curimp($this->curgroup['Group']['name'],$this->params['named']['task_id']);
                		$this->set('curimp',$this->curimp);
                		if($this->params['controller'].'/'.$this->params['action'] =='tasks/view'){
            				if(!(isset($this->curmember['Membership']['head']) ||  !empty($this->curimp) )){
                                
            					$this->notallow(1);
							}
						}else{
							$this->task_permission=$this->task_permission($this->curgroup['Group']['name'],$this->params['named']['task_id'],1);
							if(!in_array($this->params['controller'].'/'.$this->params['action'],$this->task_permission)){
                                $this->notallow(1);
							}
							$this->set('task_permission',$this->task_permission);
						}
					}else{
						$this->group_permission=$this->group_permission($this->curgroup['Group']['id'],1);
						if(!in_array($this->params['controller'].'/'.$this->params['action'],$this->group_permission)){
                            $this->notallow(1);
						}
						$this->set('group_permission',$this->group_permission);
					}
				}
				
            }else{
            	$this->SUpermission($this->params['controller'],$this->params['action'],1);
			}
        }
        
    }
    
    function beforeRender(){
        $this->set('img_path',$this->getLogo());
	}
    
    /**
     * Describe isAuthorized
     *
     * @return null
     */
    function isAuthorized(){
        return true;
    }
    
    /*find the current role in group
     * ['Membership']['head'],
     * ['User']['head'],['User']['admin']
     * ['Group']
     */
    function curmembership($group_id,$app=null){
    	//find user membership
        $curmember=$this->Group->Membership->find('first',array('fields'=>array('Membership.head','Membership.admin'),'conditions'=>array('Membership.group_id'=>$this->curgroup['Group']['id'],'Membership.foreign_key'=>$this->Auth->user('id'),'Membership.model'=>'User')));
        $curmember['User']=$curmember['Membership'];
        
        //find group2 membership
        $curmember['Group']=$this->groupmember($this->curgroup['Group']['id']);
        
        if(empty($curmember['Membership']['head']) && !empty($curmember['Group'])){
            $head=array_sum(set::extract($curmember['Group'],'{n}.head'));
            if($head>0){
                $curmember['Membership']['head']=1;
            }else{
                $curmember['Membership']['head']=0;
            }
        }
        if(!isset($curmember['Membership']['head'])){
        	$this->notallow($app);	
		}
        return $curmember;
    }
    
    /*task implementor role
     * [$assign_as][n]['id']  ---user id started with * ,[$assign_as][n]['name']
     * ['highest'] ---highest task role
     */
    function curimp($group_name,$task_id,$app=null){
    	$imp=array();
        
        $this->Task->recursive=0;
    	$task=$this->Task->find('first',array('conditions'=>array('Task.id'=>$task_id)));
        if(empty($task)){
            $this->notallow($app);
        }else{
            $groupmember=array();
            if($task['Group']['name']!=$group_name){
                $this->notallow();
            }elseif($task['Group']['name']!=$this->curgroup['Group']['name']){
                $group=$this->User->Membership->Group->find('first',array('conditions'=>array('Group.name'=>$task['Group']['name'])));
                if(!empty($group)){
                    $groupmember=$this->groupmember($group['Group']['id']);
                }else{
                    $this->notallow($app);
                }
            }else{
                $groupmember=$this->curmember['Group'];
            }
            $group2_id=set::extract($groupmember,'{n}.id');
            $this->User->Implementor->recursive=0;
            $implementor=$this->User->Implementor->find('all',array('conditions'=>array(
                'Implementor.task_id'=>$task_id,
                'or'=>array(
                    array('Implementor.model'=>'User','Implementor.foreign_key'=>$this->Auth->user('id')),
                    array('Implementor.model'=>'Group2','Implementor.foreign_key'=>$group2_id)
                )
            )));
            if(empty($implementor)){
                $this->notallow($app);
            }
            
            
            //by role
            foreach($implementor as $i){
                if($i['Implementor']['model']=='User'){
                    $list['id']='*'.$i['Implementor']['foreign_key'];
                }else{
                    $list['id']=$i['Implementor']['foreign_key'];
                }
                $list['name']=$i[$i['Implementor']['model']]['name'];
                $imp[$i['Implementor']['assign_as']][]=$list;
            }
            if(!empty($imp)){
                $imp['highest']=min(array_keys($imp));
            }
        }
        return $imp;
	}
	
	/*find user's group2 in the group
     */
	function groupmember($group_id){
		 //find group's group2
        $this->Group->Membership->unbindmodel(array('belongsTo'=>array('User')));
        $groupmember=$this->Group->Membership->find('all',array('conditions'=>array('Membership.group_id'=>$group_id,'Membership.model'=>'Group2')));
        $group2_id=set::extract($groupmember,'{n}.Membership.foreign_key');
     
     	//find group2 membership
		$this->User->Group2sUser->unbindmodel(array('belongsTo'=>array('User')));
        $this->User->Group2sUser->bindmodel(array('belongsTo'=>array('Group2')));
        $group=$this->User->Group2sUser->find('all',array('conditions'=>array('Group2sUser.user_id'=>$this->Auth->user('id'),'Group2sUser.group2_id'=> $group2_id)));
	
		$gmember=array();
		foreach($group as $g){
            $g['Group2']['head']=$groupmember[array_search($g['Group2']['id'],$group2_id)]['Membership']['head']; 
            $gmember[]=$g['Group2'];
        }
        return $gmember;

	}
	
	//superadmin permission
    function SUpermission($controller,$action,$app=null){
        if($this->Auth->user('superuser')==1){
            return true;
        }else{    
            if(in_array($controller,array('grades','schemes','titles'))  ||in_array($controller.'/'.$action,array('users/edit','users/delete','users/resetpass'))){
               $this->notallow();
            }elseif(
                (in_array($controller,array('templates')) || in_array($controller.'/'.$action,array('groups/add','users/add','group2s/add')))
                && (empty($this->curgroup['Group']) && $app)
            ){
                $this->notallow();
            }else{
                return true;
            }
        }
        
    }
	
	//group permission -- return permitted action
    function group_permission($group_id,$app=null){
    	if(!empty($app)){
    		$curmember=$this->curmember;
		}else{
			$curmember=$this->curmembership($group_id);
		}
          
   
		$permit=array('tasks/calendar','tasks/sorting','tasks/childtask','memberships/index','memberships/view');
		if(!empty($curmember['Membership']['admin'])){
			$permit=array_merge($permit,array('groups/add','groups/edit','groups/delete','templates/index','templates/edit','templates/retrieve','memberships/add','memberships/edit','memberships/delete','users/add','group2s/add','users/unlock'));
		}
		if(!empty($curmember['Membership']['head'])){
			$permit=array_merge($permit,array('memberships/add','memberships/edit','memberships/delete','users/add','group2s/add','users/unlock','tasks/basic'));
		}
		return $permit;
	}
	
	//task permission -- return permitted action which have task_id
	function task_permission($group_name,$task_id,$app=null){
		if(!empty($app)){
    		$curimp=$this->curimp;
		}else{
			$curimp=$this->curimp($group_name,$task_id,$app);
		}
        $permit=array();
        if(!empty($curimp)){
            $permit['group_name']=$group_name;
            $permit['task_id']=$task_id;
            $permit=array('comments/add','reminders/add','statuses/index','tasks/copy');

            if(!empty($curimp[1]) || !empty($curimp[2])){
                $permit[]='tasks/basic';
                $permit[]='tasks/additional';
            }
            if(!empty($curimp[1]) || !empty($curimp[2]) || !empty($curimp[3])){
                $permit[]='tasks/imp';
            }
            if(!empty($curimp[3]) || !empty($curimp[4])){
                $permit[]='statuses/add';
            }
            if(!empty($curimp[1])){
                $permit[]='tasks/delete';
            }
        }

		return $permit;
	}
	
	//not allow
	function notallow($app=null){
		if($app){
			$this->Session->setFlash(__('You have entered the wrong url', true));
        	$this->redirect(array('controller'=>'groups','action'=>'mainpage'));
		}else{
			return null;
		}
	}
    
    //create table
    function createTables(){
        App::import('ConnectionManager');
        $db= ConnectionManager :: getDataSource('default');
        $prefix= $db->config['prefix'];
        $dfile= ROOT . DS . 'app/config/sql/tm_tables.sql';

        $sql= file_get_contents($dfile);
        $a=0;
        while($b=strpos($sql,'CREATE TABLE',$a)){
            $a=strpos($sql,';',$b);
            $db->query(substr($sql,$b,$a-$b+1));
        }
        return $sql;
    }
    
    function changelanguage($lang){
        if(!empty($lang)){
            $dfile= APP . 'config' . DS . 'bootstrap.php';
            $file = new File($dfile);
            $content=$file->read($file->open('rw'));
            $file->close();
            $content=substr_replace($content,$lang,strpos($content,"define('DEFAULT_LANGUAGE','")+27,3);
            $file->write($content);    
            $file->close();
            Cache::clear();
        }
    }
    
     /**
     * Describe getLogo
     *
     * @return string path to logo
     */
    function getLogo() {
        $found = array();
        $folder = new Folder(WWW_ROOT . 'img' . DS . 'logo');
        $found = $folder->find();

        if (count($found)) {
            return 'logo'. DS . $found[0];
        } else {
            return 'tm2logo.png'; 
        }
        
    }
    
}
?>
