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
            
            if(!empty($this->params['pass'][0])){
                $this->loadModel('Group');
                
                //check committee
                if($this->params['pass'][0]!=$this->Session->read('committee')){
                    
                    //once $this->params['pass'][0] change
                    $this->Session->write('committee',$this->params['pass'][0]);
                    $this->Session->delete('curmember');
                    $this->Group->recursive=-1;
                    $this->curgroup=$this->Group->find('first',array('conditions'=>array('Group.name'=>$this->params['pass'][0])));
                    $this->Session->write('curgroup',$this->curgroup);
                    
                    if(!empty($this->curgroup)){
                        $this->curmember=$this->curmembership($this->curgroup['Group']['id'],1);
                        $this->Session->write('curmember',$this->curmember);
                    }
                    
                }
                $this->curgroup=$this->Session->read('curgroup');
                $this->curmember=$this->Session->read('curmember');
                $this->set('curgroup',$this->curgroup);
                $this->set('curmember',$this->curmember);
                
                if(!empty($this->params['named']['task_id'])){
                    
                    //check relationship between task and current user  
                    if($this->params['named']['task_id'] != $this->Session->read('task_id')){
                        //once $this->params['named']['task_id'] change
                        $this->Session->write('task_id',$this->params['named']['task_id']);
                        $this->curimp=$this->curimp($this->curgroup['Group']['name'],$this->params['named']['task_id']);
                        $this->Session->write('curimp',$this->curimp);
                    }else{
                        $this->curimp=$this->Session->read('curimp');
                    }
                    $this->set('curimp',$this->curimp);
                }
            }
            
            //start to check permission
            if(!empty($this->curgroup)){
                 if(!empty($this->params['named']['task_id'])){
                    
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
            $this->User->Implementor->unbindmodel(array('belongsTo'=>array('Role')));
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
            if(strpos(' '.$this->Session->read('lastvisitedpage'),'memberships/delete')){
                $this->Session->setFlash(__('You have removed yourself from the committee membership list', true));
            }
			
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
        $sql=str_replace('CREATE TABLE IF NOT EXISTS `','CREATE TABLE IF NOT EXISTS `'.$prefix,$sql);
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

            
            //Configure::write('Config.language', $this->lang)
    
            Cache::clear();
            if(DEFAULT_LANGUAGE!=$lang){
                $this->changelanguage($lang);
            }
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
    
    //restore initial data function
    function initial_data($model,$compulsory,$extra=array(),$replace=0){
        $this->loadModel($model);
        $this->{$model}->recursive=-1;
        foreach($compulsory as $c=>$cdata){
            $got=$this->{$model}->find('first',array('conditions'=>$cdata));
            if(empty($got) || !empty($replace)){
                
                if(!empty($extra[$c])){
                    $data=array_merge($cdata,$extra[$c]);
                }else{
                    $data=$cdata;
                }
                
                if(empty($got)){
                    $this->{$model}->create();
                }else{
                    $data['id']=$got[$model]['id'];
                }
                
                $this->{$model}->save($data);
            }
        }
    }
    
    //restore schemes initial data
    function schemes_data(){
        $this->initial_data(
            'Scheme',
            array(
                array('name'=>'F'),
                array('name'=>'L'),
                array('name'=>'I'),
                array('name'=>'J'),
                array('name'=>'S'),
                array('name'=>'E'),
                array('name'=>'U'),
                array('name'=>'N'),
                array('name'=>'W'),
                array('name'=>'KP'),
                array('name'=>'KX'),
                array('name'=>'KB'),
                array('name'=>'A'),
                array('name'=>'G'),
                array('name'=>'C'),
                array('name'=>'M'),
                array('name'=>'LS'),
                array('name'=>'P'),
                array('name'=>'UD'),
                array('name'=>'DG'),
                array('name'=>'Q'),
                array('name'=>'X')
            )
        );
    }
    
    //restore titles initial data
    function titles_data($replace=0){
        
        if(DEFAULT_LANGUAGE=='eng'){
            $data=array(
                array('long_name'=>'Y.Bhg Tan Sri'),
                array('long_name'=>'Y.Bhg Datuk'),
                array('long_name'=>"Y.Bhg Dato'"),
                array('long_name'=>'Y.Brs Dr.'),
                array('long_name'=>'Hj.'),
                array('long_name'=>'Mr.'),
                array('long_name'=>'Madam.'),
                array('long_name'=>'Miss')
            );
        }else{
            $data=array(
                array('long_name'=>'Y.Bhg Tan Sri'),
                array('long_name'=>'Y.Bhg Datuk'),
                array('long_name'=>"Y.Bhg Dato'"),
                array('long_name'=>'Y.Brs Dr.'),
                array('long_name'=>'Hj.'),
                array('long_name'=>'En.'),
                array('long_name'=>'Pn.'),
                array('long_name'=>'Cik')
            );
        }
        
        $this->initial_data('Title',$data,$replace);
    }
    
    //restore roles initial data
    function roles_data($replace=0){
        
        if(DEFAULT_LANGUAGE=='eng'){
            $data=array(
                array('name'=>'Head'),
                array('name'=>'Supervisor'),
                array('name'=>'Desk Officer'),
                array('name'=>'Implementor')
            );
        }else{
            $data=array(
                array('name'=>'Ketua'),
                array('name'=>'Supervisor'),
                array('name'=>'Desk Officer'),
                array('name'=>'Pelaksana')
            );
        }
        
        $this->initial_data(
            'Role',
            array(array('id'=>1),array('id'=>2),array('id'=>3),array('id'=>4)),
            $data,
            $replace
        );
    }
        
    //restore templates initial data
    function restore_grades_data(){
        $compulsory=array('KSN','Turus I','Turus II','Turus III','Jusa A','Jusa B','Jusa C','54','52','48','44','41','36','32','27','22','17','14','11','1');
        $this->loadModel('Grade');
        $this->Grade->recursive=-1;
        $all=$this->Grade->find('all');
        $all_grade=set::extract($all,'{n}.Grade.grade');
        $all_rank=set::extract($all,'{n}.Grade.rank');
        if(empty($all_rank)){
            $max=0;
        }else{
            $max=max($all_rank);
        }
        foreach($compulsory as $c=>$cdata){
            if(!in_array($cdata,$all_grade)){
                $this->Grade->create();
                $data['Grade']['grade']=$cdata;
                $data['Grade']['rank']=++$max;
                $this->Grade->save($data);
            }
        }
    }
    
    //systemOnly template data
    function SystemOnly_template($replace=0){
        
        if(DEFAULT_LANGUAGE=='eng'){
            $data=array(
                array('title'=>'New Account', 'description'=>'Email which be send to new system user', 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>New Account<br /></span></strong></p><p>This is to inform you that there is a new account which had been created for you in Task Manager System. The login details are shown below:</p><p>Username: %username<br />Password: %newpassword</p><p>You are adviced to change the password immediately. Please login %Link.newaccount:here to update your profile.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>"),
                array('title'=>'New Password', 'description'=>"Email which be send when a user's password had been reset", 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>NEW PASSWORD<br /></span></strong></p><p>This is to inform you that your reset password request in Task Manager system had been processed. A new password had been made for you. The new password is %newpassword.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>"),
                array('title'=>'Retrieve Username', 'description'=>'Email which be send when a user had forgotten username', 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>RETRIEVE USERNAME<br /></span></strong></p><p>This is to inform you that your retrieve username request in Task Manager system had been processed.&nbsp; Your username is %username</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>")
            );
        }else{
            $data=array(
                array('title'=>'Akaun telah didaftarkan', 'description'=>'Emel yang dihantar kepada pengguna sistem yang baru didaftarkan', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>AKAUN ANDA TELAH DIDAFTARKAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Pentadbir sistem Task Manager telah mendaftarkan nama anda sebagai pengguna sistem. Maklumat log masuk anda adalah seperti berikut:</p><p>Kata nama: %username<br />Kata laluan: %newpassword</p><p>Anda dinasihatkan untuk menukar kata laluan anda. Sila log masuk di %Link.newaccount:sini untuk mengemaskini profail anda.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>"),
                array('title'=>'Kata laluan baru', 'description'=>'Emel yang dihantar apabila kata laluan disetkan semula', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>KATA LALUAN BARU<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di Task Manager untuk set semula kata laluan tuan/puan. Oleh yang demikian, kata laluan baru telah dijana untuk kegunaan tuan/puan. Kata laluan baru tuan/puan ialah %newpassword.</p><p>Harap maklum.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>"),
                array('title'=>'Dapatkan semula kata nama', 'description'=>'Emel yang dihantar apabila ahli terlupa kata nama', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MENDAPATKAN SEMULA KATA NAMA<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di Task Manager untuk mendapatkan semula kata nama tuan/puan.&nbsp; Kata nama tuan/puan ialah %username</p><p>Harap maklum.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>")
            );
        }
        
        $this->initial_data(
            'Template',
            array(
                array('model'=>'SystemOnly','foreign_key'=>'0','type'=>'new account'),
                array('model'=>'SystemOnly','foreign_key'=>'0','type'=>'reset password'),
                array('model'=>'SystemOnly','foreign_key'=>'0','type'=>'forgot username')
            ),
            $data,
            $replace
        );
    }
        
    //system template data
    function System_template($replace=0){
        
        if(DEFAULT_LANGUAGE=='eng'){
            $data=array(
                array('title'=>'Notification of Task Assignation', 'description'=>'Email which be send as notification of task assignation', 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>NOTIFICATION OF TASK ASSIGNATION<br /></span></strong></p><p>This is to inform you that %you had been assigned as %Implementor.as for a task. The task is shown below:</p><p>================<br /> Task Name : %Task.task_name<br /> ================</p><p>More detail: %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>"),
                array('title'=>'Notification of Task Deassignation', 'description'=>'Email which be send as notification of task deassignation', 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>NOTIFICATION OF TASK DEASSIGNATION<br /></span></strong></p><p>This is to inform you that %your name was removed from implementor list. In previous, you were assigned as %Implementor.as. The related task is shown below:</p><p>================<br /> Task Name : %Task.task_name<br />================</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>"),
                array('title'=>'Notification of Change of Role', 'description'=>'Email which be send as notification of change of role', 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>NOTIFICATION OF CHANGE OF ROLE<br /></span></strong></p><p>This is to inform you that %your role in task %Task.task_name had been changed from %oldImplementor.as to %Implementor.as. </p><p>&nbsp;</p><p>More detail: %Link.task:here.</p><p><b>%slogan</b></p><p>Thank you.</p>"),
                array('title'=>'Notification of Task Cancellation', 'description'=>'Email which be send as notification of task cancellation', 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>NOTIFICATION OF TASK CANCELLATION<br /></span></strong></p><p>This is to inform you that the task %Task.task_name had been cancelled.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>"),
                array('title'=>'Task Comment', 'description'=>'Email which be send if there are comment on a task', 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>NOTIFICATION OF COMMENT ON TASK<br /></span></strong></p><p>This is to inform you that %Comment.user had commented task %Task.task_name. The comment is shown below:</p><p>================<br /> %Comment.description<br /> ================</p><p>For more detail on the related task, please click %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>"),
                array('title'=>'Updating of Status', 'description'=>'Email which be send if there are a updating of status', 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>NOTIFICATION OF UPDATING OF STATUS<br /></span></strong></p><p>This is to inform you that %Updater had updated %Status.user''s status for the task %Task.task_name. The status is shown below:</p><p>================<br /> %Status.description<br /> ================</p><p>More detail about the task: %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>"),
                array('title'=>'Reminder', 'description'=>'Email which be send as reminder', 'template'=>"<p>Dear %name,</p><p><strong><span style='text-decoration: underline;'>REMINDER OF TASK<br /></span></strong></p><p>This is to inform you that you had activated the reminder for the task %Task.task_name.</p><p>Note:</p><p>================<br /> %Reminder.note<br /> ================</p><p>Reminder Date:</p><p>================<br /> %Reminder.remind_date<br /> ================</p><p>More detail about the task: %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>")
            );
        }else{
            $data=array(
                array('title'=>'Makluman tentang penugasan', 'description'=>'Emel untuk dihantar apabila terdapat penugasan tugas', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MAKLUMAN TENTANG PENUGASAN TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Dalam tugas %Task.task_name, %you telah ditugaskan sebagai %Implementor.as <br /> ================</p><p>Maklumat yang lebih terperinci boleh dilihat di %Link.task:sini.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>"),
                array('title'=>'Makluman tentang pembatalan pengagihan tugas', 'description'=>'Emel untuk dihantar apabila terdapat pembatalan pengagihan tugas', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MAKLUMAN TENTANG PEMBATALAN PENGAGIHAN TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Penugasan %you sebagai  %oldImplementor.as sebelum ini telah dibatalkan. Tugas tersebut adalah seperti berikut:</p><p>================<br /> Nama Tugasan : %Task.task_name<br />================</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>"),
                array('title'=>'Makluman tentang penukaran peranan', 'description'=>'Emel untuk dihantar apabila terdapat penukaran peranan', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MAKLUMAN TENTANG PENUKARAN PERANAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Peranan %you dalam tugas %Task.task_name telah ditukar daripada %oldImplementor.as kepada %Implementor.as.</p><p>Maklumat yang lebih terperinci boleh dilihat di %Link.task:sini.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>"),
                array('title'=>'Makluman tentang pembatalan tugas', 'description'=>'Emel untuk dihantar apabila terdapat pembatalan tugas', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MAKLUMAN TENTANG PEMBATALAN TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Tugas %Task.task_name telah dibatalkan.</p><p><b>%slogan</b></p><p>Terima kasih.</p>"),
                array('title'=>'Komen Tugas', 'description'=>'Emel yang dihantar jika terdapat komen yang ditinggalkan untuk tugas', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MAKLUMAN TENTANG KOMEN YANG DITINGGALKAN UNTUK TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Comment.user telah meninggalkan komen untuk tugas %Task.task_name. Komennya adalah seperti berikut:</p><p>================<br /> %Comment.description<br /> ================</p><p>Maklumat tugas boleh dilihat di %Link.task:sini.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>"),
                array('title'=>'Pengemaskinian status', 'description'=>'Emel untuk dihantar apabila terdapat status yang dikemaskinikan', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MAKLUMAN TENTANG PENGEMASKINIAN STATUS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Updater telah mengemaskinikan status %Status.user untuk tugasan %Task.task_name. Statusnya adalah seperti berikut:</p><p>================<br /> %Status.description<br /> ================</p><p>Maklumat tugasan boleh dilihat di %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>"),
                array('title'=>'reminder', 'Peringatan', 'description'=>'Emel untuk dihantar sebagai peringatan', 'template'=>"<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>PERINGATAN TENTANG TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Tuan/Puan telah mengaktifkan fungsi peringatan untuk tugasan %Task.task_name. </p><p>Catatan:</p><p>================<br /> %Reminder.note<br /> ================</p><p>Tarikh Peringatan:</p><p>================<br /> %Reminder.remind_date<br /> ================</p><p>Maklumat tugasan boleh dilihat di %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>")
            );
        }
        
        $this->initial_data(
            'Template',
            array(
                array('model'=>'System','foreign_key'=>0,'type'=>'assign task'),
                array('model'=>'System','foreign_key'=>0,'type'=>'deassign task'),
                array('model'=>'System','foreign_key'=>0,'type'=>'change role'),
                array('model'=>'System','foreign_key'=>0,'type'=>'delete task'),
                array('model'=>'System','foreign_key'=>0,'type'=>'task comment'),
                array('model'=>'System','foreign_key'=>0,'type'=>'update status'),
                array('model'=>'System','foreign_key'=>0,'type'=>'reminder')
            ),
            $data,
            $replace
        );
    }
    
    //install default data
    function installData($replace=0){
        $this->restore_grades_data();
        $this->schemes_data();       
        $this->titles_data($replace); 
        $this->roles_data($replace);      
        $this->System_template($replace);
        $this->SystemOnly_template($replace);
    }
}
?>
