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
            if (!$file->writable()) return false;
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
            
            $this->installData();
            
            $this->Session->setFlash("Language is set.");
            $this->set('languageset',true);
        } 
        
    }
    
    //install default data
    function installData(){
        App::import('ConnectionManager');
        $db= ConnectionManager :: getDataSource('default');
        $a['grades']="REPLACE INTO `grades` (`id`, `grade`, `rank`) VALUES
            (1,'KSN', '1'),
            (2,'Turus I', '2'),
            (3,'Turus II', '3'),
            (4,'Turus III', '4'),
            (5,'Jusa A', '5'),
            (6,'Jusa B', '6'),
            (7,'Jusa C', '7'),
            (8,'54', '8'),
            (9,'52', '9'),
            (10,'48', '10'),
            (11,'44', '11'),
            (12,'41', '12'),
            (13,'36', '13'),
            (14,'32', '14'),
            (15,'27', '15'),
            (16,'22', '16'),
            (17,'17', '17'),
            (18,'14', '18'),
            (19,'11', '19'),
            (20,'1', '20')
            ;";
            $a['schemes']="REPLACE INTO `schemes` (`id`,`name`) VALUES
            (1,'F'),
            (2,'L'),
            (3,'I'),
            (4,'J'),
            (5,'S'),
            (6,'E'),
            (7,'U'),
            (8,'N'),
            (9,'W'),
            (10,'KP'),
            (11,'KX'),
            (12,'KB'),
            (13,'A'),
            (14,'G'),
            (15,'C'),
            (16,'M'),
            (17,'LS'),
            (18,'P'),
            (19,'UD'),
            (20,'DG'),
            (21,'Q'),
            (22,'X');
            ";
            
        if(DEFAULT_LANGUAGE=='eng'){
            $a['roles']="REPLACE INTO `roles` (`id`, `name`, `description`) VALUES
                (1, 'Head', 'Head'),
                (2, 'Supervisor', 'Supervisor'),
                (3, 'Desk Officer', 'Desk Officer'),
                (4, 'Implementor', 'Implementor')";
            $a['templates']="REPLACE INTO `templates` (`id`, `model`, `foreign_key`, `type`, `title`, `description`, `template`) VALUES
                (1, 'SystemOnly', 0, 'new account', 'New Account', 'Email which be send to new system user', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>New Account<br /></span></strong></p><p>This is to inform you that there is a new account which had been created for you in Task Manager System. The login details are shown below:</p><p>Username: %username<br />Password: %newpassword</p><p>You are adviced to change the password immediately. Please login %Link.newaccount:here to update your profile.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>'),
                (2, 'SystemOnly', 0, 'reset password', 'New Password', 'Email which be send when a user''s password had been reset', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>NEW PASSWORD<br /></span></strong></p><p>This is to inform you that your reset password request in Task Manager system had been processed. A new password had been made for you. The new password is %newpassword.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>'),
                (3, 'SystemOnly', 0, 'forgot username', 'Retrieve Username', 'Email which be send when a user had forgotten username', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>RETRIEVE USERNAME<br /></span></strong></p><p>This is to inform you that your retrieve username request in Task Manager system had been processed.&nbsp; Your username is %username</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>'),
                (4, 'System', 0, 'assign task', 'Notification of Task Assignation', 'Email which be send as notification of task assignation', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>NOTIFICATION OF TASK ASSIGNATION<br /></span></strong></p><p>This is to inform you that %you had been assigned as %Implementor.as for a task. The task is shown below:</p><p>================<br /> Task Name : %Task.task_name<br /> ================</p><p>More detail: %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>'),
                (5, 'System', 0, 'deassign task', 'Notification of Task Deassignation', 'Email which be send as notification of task deassignation', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>NOTIFICATION OF TASK DEASSIGNATION<br /></span></strong></p><p>This is to inform you that %your name was removed from implementor list. In previous, you were assigned as %Implementor.as. The related task is shown below:</p><p>================<br /> Task Name : %Task.task_name<br />================</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>'),
                (6, 'System', 0, 'change role', 'Notification of Change of Role', 'Email which be send as notification of change of role', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>NOTIFICATION OF CHANGE OF ROLE<br /></span></strong></p><p>This is to inform you that %your role in task %Task.task_name had been changed from %oldImplementor.as to %Implementor.as. </p><p>&nbsp;</p><p>More detail: %Link.task:here.</p><p><b>%slogan</b></p><p>Thank you.</p>'),
                (7, 'System', 0, 'delete task', 'Notification of Task Cancellation', 'Email which be send as notification of task cancellation', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>NOTIFICATION OF TASK CANCELLATION<br /></span></strong></p><p>This is to inform you that the task %Task.task_name had been cancelled.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>'),
                (8, 'System', 0, 'task comment', 'Task Comment', 'Email which be send if there are comment on a task', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>NOTIFICATION OF COMMENT ON TASK<br /></span></strong></p><p>This is to inform you that %Comment.user had commented task %Task.task_name. The comment is shown below:</p><p>================<br /> %Comment.description<br /> ================</p><p>For more detail on the related task, please click %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>'),
                (9, 'System', 0, 'update status', 'Updating of Status', 'Email which be send if there are a updating of status', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>NOTIFICATION OF UPDATING OF STATUS<br /></span></strong></p><p>This is to inform you that %Updater had updated %Status.user''s status for the task %Task.task_name. The status is shown below:</p><p>================<br /> %Status.description<br /> ================</p><p>More detail about the task: %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>'),
                (10, 'System', 0, 'reminder', 'Reminder', 'Email which be send as reminder', '<p>Dear %name,</p><p><strong><span style=''text-decoration: underline;''>REMINDER OF TASK<br /></span></strong></p><p>This is to inform you that you had activated the reminder for the task %Task.task_name.</p><p>Note:</p><p>================<br /> %Reminder.note<br /> ================</p><p>Reminder Date:</p><p>================<br /> %Reminder.remind_date<br /> ================</p><p>More detail about the task: %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Thank you.</p>');";
            $a['titles']="REPLACE INTO `titles` (`id`, `long_name`) VALUES
                (1, 'Y.Bhg Tan Sri'),
                (2, 'Y.Bhg Datuk'),
                (3, 'Y.Bhg Dato'''),
                (4, 'Y.Brs Dr.'),
                (5, 'Hj.'),
                (6, 'Mr.'),
                (7, 'Madam.'),
                (8, 'Miss');";
        }else{
            $a['roles']="REPLACE INTO `roles` (`id`, `name`, `description`) VALUES
                (1, 'Head', 'Head'),
                (2, 'Supervisor', 'Supervisor'),
                (3, 'Desk Officer', 'Desk Officer'),
                (4, 'Implementor', 'Implementor');";
            $a['templates']="REPLACE INTO `templates` (`id`, `model`, `foreign_key`, `type`, `title`, `description`, `template`) VALUES
                (1, 'SystemOnly', 0, 'new account', 'Akaun telah didaftarkan', 'Emel yang dihantar kepada pengguna sistem yang baru didaftarkan', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>AKAUN ANDA TELAH DIDAFTARKAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Pentadbir sistem Task Manager telah mendaftarkan nama anda sebagai pengguna sistem. Maklumat log masuk anda adalah seperti berikut:</p><p>Kata nama: %username<br />Kata laluan: %newpassword</p><p>Anda dinasihatkan untuk menukar kata laluan anda. Sila log masuk di %Link.newaccount:sini untuk mengemaskini profail anda.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>'),
                (2, 'SystemOnly', 0, 'reset password', 'Kata laluan baru', 'Emel yang dihantar apabila kata laluan disetkan semula', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>KATA LALUAN BARU<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di Task Manager untuk set semula kata laluan tuan/puan. Oleh yang demikian, kata laluan baru telah dijana untuk kegunaan tuan/puan. Kata laluan baru tuan/puan ialah %newpassword.</p><p>Harap maklum.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>'),
                (3, 'SystemOnly', 0, 'forgot username', 'Dapatkan semula kata nama', 'Emel yang dihantar apabila ahli terlupa kata nama', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MENDAPATKAN SEMULA KATA NAMA<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di Task Manager untuk mendapatkan semula kata nama tuan/puan.&nbsp; Kata nama tuan/puan ialah %username</p><p>Harap maklum.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>'),
                (4, 'System', 0, 'assign task', 'Makluman tentang penugasan', 'Emel untuk dihantar apabila terdapat penugasan tugas', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MAKLUMAN TENTANG PENUGASAN TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Dalam tugas %Task.task_name, %you telah ditugaskan sebagai %Implementor.as <br /> ================</p><p>Maklumat yang lebih terperinci boleh dilihat di %Link.task:sini.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>'),
                (5, 'System', 0, 'deassign task', 'Makluman tentang pembatalan pengagihan tugas', 'Emel untuk dihantar apabila terdapat pembatalan pengagihan tugas', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MAKLUMAN TENTANG PEMBATALAN PENGAGIHAN TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Penugasan %you sebagai  %oldImplementor.as sebelum ini telah dibatalkan. Tugas tersebut adalah seperti berikut:</p><p>================<br /> Nama Tugasan : %Task.task_name<br />================</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>'),
                (6, 'System', 0, 'change role', 'Makluman tentang penukaran peranan', 'Emel untuk dihantar apabila terdapat penukaran peranan', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MAKLUMAN TENTANG PENUKARAN PERANAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Peranan %you dalam tugas %Task.task_name telah ditukar daripada %oldImplementor.as kepada %Implementor.as.</p><p>Maklumat yang lebih terperinci boleh dilihat di %Link.task:sini.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>'),
                (7, 'System', 0, 'delete task', 'Makluman tentang pembatalan tugas', 'Emel untuk dihantar apabila terdapat pembatalan tugas', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MAKLUMAN TENTANG PEMBATALAN TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Tugas %Task.task_name telah dibatalkan.</p><p><b>%slogan</b></p><p>Terima kasih.</p>'),
                (8, 'System', 0, 'task comment', 'Komen Tugas', 'Emel yang dihantar jika terdapat komen yang ditinggalkan untuk tugas', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MAKLUMAN TENTANG KOMEN YANG DITINGGALKAN UNTUK TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Comment.user telah meninggalkan komen untuk tugas %Task.task_name. Komennya adalah seperti berikut:</p><p>================<br /> %Comment.description<br /> ================</p><p>Maklumat tugas boleh dilihat di %Link.task:sini.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>'),
                (9, 'System', 0, 'update status', 'Pengemaskinian status', 'Emel untuk dihantar apabila terdapat status yang dikemaskinikan', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MAKLUMAN TENTANG PENGEMASKINIAN STATUS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Updater telah mengemaskinikan status %Status.user untuk tugasan %Task.task_name. Statusnya adalah seperti berikut:</p><p>================<br /> %Status.description<br /> ================</p><p>Maklumat tugasan boleh dilihat di %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>'),
                (10, 'System', 0, 'reminder', 'Peringatan', 'Emel untuk dihantar sebagai peringatan', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>PERINGATAN TENTANG TUGAS<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Tuan/Puan telah mengaktifkan fungsi peringatan untuk tugasan %Task.task_name. </p><p>Catatan:</p><p>================<br /> %Reminder.note<br /> ================</p><p>Tarikh Peringatan:</p><p>================<br /> %Reminder.remind_date<br /> ================</p><p>Maklumat tugasan boleh dilihat di %Link.task:here.</p><p>&nbsp;</p><p><b>%slogan</b></p><p>Terima kasih.</p>');";
            $a['titles']="REPLACE INTO `titles` (`id`, `long_name`) VALUES
                (1, 'Y.Bhg Tan Sri'),
                (2, 'Y.Bhg Datuk'),
                (3, 'Y.Bhg Dato'''),
                (4, 'Y.Brs Dr.'),
                (5, 'Hj.'),
                (6, 'En.'),
                (7, 'Pn.'),
                (8, 'Cik');";
        }
       
        foreach($a as $query){
            $db->query($query);
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
