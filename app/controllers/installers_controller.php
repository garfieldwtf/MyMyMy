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

class InstallersController extends AppController {

/**
 * Define $name
 *
 */
    var $name = 'Installers';
/**
 * Define $helpers
 *
 */
    var $helpers = array('Html', 'Form','Javascript');
    
    var $uses = null;
    
    var $layout = 'install';
    var $pageTitle = 'Install';
        
    //license
    function install(){
        $dfile= APP . 'LICENSE.txt';
        $file = new File($dfile);
        $this->set('license',$file->read($file->open('r')));
        $file->close();
        if (!empty($this->data)) {
                
            if(!empty($this->data['agree'])){
                //$this->testFileSystem(); 
                $this->redirect(array('action'=>'dircheck'));
            } else {
                $this->Session->setFlash('You have to accept the license to proceed');
            }
        }
    }
    
    
    //check the file permission
   function dircheck(){
        $writableDirs= array (
            ROOT . '/app/config/',
            ROOT . '/app/config/bootstrap.php',
            ROOT . '/app/tmp',
            ROOT . '/app/tmp' . DS . 'sessions',
            ROOT . '/app/tmp' . DS . 'logs',
            ROOT . '/app/tmp' . DS . 'cache',
            ROOT . '/app/tmp' . DS . 'tests',
            ROOT . '/app/webroot' . DS . 'upload',
            ROOT . '/app/webroot' . DS . 'img' . DS . 'logo',
        );
        $areNotWriteable= array ();
        $areWritable= array ();
        foreach ($writableDirs as $dir){
            if(!is_dir($dir)){
                mkdir($dir);
            }
            if (!is_writable($dir)){
                $areNotWriteable[]= $dir;
            } else { $areWritable[] = $dir; }
            unset($dir);
        }
        $this->set('areNotWriteable', $areNotWriteable);
        $this->set('areWritable', $areWritable);
        if (count($areNotWriteable)){
            $this->set(compact('areNotWriteable'));
            unset($areNotWriteable);
        } 
  }
  
    //database setting
    function database(){
        $dfile= APP . 'config' . DS . 'database.php';
        $file = new File($dfile);
        
        If($this->data){

            if (!($file->exists())) {
                $file->create();
            }
            $output="<?php\n";
            $output.="class DATABASE_CONFIG {\n\n";
            $output.="\tvar ".'$default'." = array(\n\n";
            $output.="\t\t'driver' => 'mysql',\n";
            foreach ($this->data as $key=>$ins){
                $output.="\t\t'".$key."' => '".$ins."',\n";
            }
            $output.="\t\t'persistent' => false,\n";
            $output.="\t\t'schema' => '',\n";
            $output.="\t\t'encoding' => ''\n";
            $output.="\t);\n";
            $output.="}\n";
            $output.="?>\n";
            if (!$file->writable()) {$this->Session->setFlash("Please make /app/config/database.php writable");return false;}
            else {
                $file->open('w');
                $file->write($output);    
                $file->close();
            }
        }
        if ($file->exists()) {
            App::import('Model','ConnectionManager');
            $db= & ConnectionManager :: getDataSource('default');
            if ($db->isConnected()) {
                $this->set('host',$db->config['host']);
                $this->set('password',$db->config['password']);
                $this->set('port',$db->config['port']);
                $this->set('database',$db->config['database']);
                $this->set('login',$db->config['login']);
                $this->set('driver',$db->config['driver']);
                
                $this->set('connected',true);
                $this->createTables();
                $this->Session->setFlash("Database is set.");
            } else {
                $this->set('connected',false);
                $this->Session->setFlash("Error connecting to database. Please make sure the database exist and username/password are correct.");
            }
        }
    }
    
    //language
    function language(){
        $this->set('languageset',false);
        
        if(!empty($this->data['language'])){
            $this->changelanguage($this->data['language']);
            $this->installData(1);
            
            $this->Session->setFlash("Language is set.");
            $this->set('languageset',true);
        } 
        
    }
    
    
    //setting the agency detail
    function syssettings(){
        
        $saved_field=array('agency_name','agency_address','agency_slogan','email_method','email_from','email_from_name','smtp_host','smtp_port','smtp_username','smtp_password','sendmail','locked_period');
        $dfile= APP . 'config' . DS . 'tm.php';
        $file = new File($dfile);
        if (!($file->exists())) $file->create();
        
        foreach($saved_field as $s){
            $this->set($s,Configure::read($s));
        }
        
        $this->set('syssettingset',false);
        if (!empty($this->data)) {
            $output="<?php\n";
            foreach($saved_field as $s){
                if(isset($this->data[$s])){
                    $d=$this->data[$s];
                    $output.="\tConfigure::write('$s','$d');\n";
                }
            }
            $output.="?>\n";
            
            if (!$file->writable()) return false;
            else {
                $file->open('w');
                $file->write($output);    
                $file->close();
                $this->Session->setFlash("System settings are set.");
                $this->set('syssettingset',true);
            }
        }
        
        if ($this->addUser()) {
            $this->redirect(array('action'=>'success'));
        }
    }
    

    //admin detail
    function addUser(){
        App::import('Model','User');
        $this->User=&new User;
        
        if (!empty($this->data)) {
            
            //validation
            if($this->User->find('count',array('conditions'=>array('username'=>$this->data['username'])))){
                $this->Session->setFlash('Username already exist');
                return false;
            }
            if($this->User->find('count',array('conditions'=>array('email'=>$this->data['email'])))){
                $this->Session->setFlash('Email already exist');
                return false;
            }
            
            $errormsg=null;
            $minlength=array(__('Username',true)=>$this->data['username'],__('Password','true')=>$this->data['password']);
            foreach($minlength as $field=>$data){
                if(strlen($data)<4){
                    $errormsg.=$field." : ".'Minimum length 4';
                    $errormsg.='<br/>';
                }elseif(!preg_match('/^([a-zA-Z0-9])+$/', $data)){
                    $errormsg.=$field." : ".'Alphabets and numbers only';
                    $errormsg.='<br/>';
                }
            }
            $notempty=array(__('Name',true)=>$this->data['name'],__('Email',true)=>$this->data['email']);
            foreach($notempty as $nfield=>$ndata){
                if(empty($ndata)){
                    $errormsg.=$nfield." : ".'This field cannot be left blank';
                    $errormsg.='<br/>';
                }
            }
            $emailfield=array('Email'=>$this->data['email']);
            
            foreach($emailfield as $efield=>$uemail){
                if((!preg_match('/^([_a-zA-Z0-9.]+@[-a-zA-Z0-9]+(\.[-a-zA-Z0-9]+)+)*$/', $uemail))){
                    $errormsg.=$efield." : ".'Invalid email format';
                    $errormsg.='<br/>';
                }
            }
            if ($this->data['password'] != $this->data['password_confirm']) {
                $errormsg.="Password are not identical.";
                $errormsg.='<br/>';
            }
                
            if ($errormsg ==null) {
                $this->data['password']=$this->Auth->password($this->data['password']);
                $this->User->create();
                if ($this->User->save($this->data)) {
                    return true;
                }else{
                    $this->Session->setFlash('Administrator could not be created. Please try again.');
                    return false;
                }
            }else {
                $this->Session->setFlash($errormsg);
                return false;
            }
        }
        
    }
   
   //success and register
    function success(){
        if(!empty($this->data['purpose'])){
            if($this->data['purpose']=='production'){
                $message=
                    "<p>An agency ".configure::read('agency_name')." has successfully installed MTask Manager for PRODUCTION. 
                    Below is the detail of the agency:</p>
                    <p><br/>
                    Agency name: ".configure::read('agency_name')."<br/>
                    Email: ".$this->data['email']."<br/>
                    </p>";
                App::import('ConnectionManager');
                $db= ConnectionManager :: getDataSource('default');
                $db->query("
                    INSERT INTO `notifications` (`foreign_key`, `type`, `message_title`, `notification_date`, `notification_sent`, `message`, `to`) VALUES
                    (0, 'register','Task Manager New Installation','".date('Y-m-d H:m:s')."', 0, '".$message."', 'helpdesk@oscc.org.my');
                  ");
            } else {
                if ($this->data['contactme'] == 'Yes') {
                    
                    "<p>An agency ".configure::read('agency_name')." has successfully installed Task Manager for REVIEW and they wish for OSCC to contact them.  
                    Below is the detail of the agency:</p>
                    <p><br/>
                    Agency name: ".configure::read('agency_name')."<br/>
                    Contact: ".$this->data['name']."<br/>
                    Email: ".$this->data['email']."<br/>
                    Phone: ".$this->data['phone']."<br/>
                    Has intention to deploy for production: ".$this->data['intent']."
                    ";
                }
            }
          
            $this->redirect(array('controller'=>'groups','action'=>'mainpage'));
        }
    }
    
}
?>
