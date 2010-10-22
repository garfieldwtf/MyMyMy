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


class SystemsController extends AppController {

/**
 * Define $name
 *
 */
    var $name = 'Systems';
/**
 * Define $helpers
 *
 */
    var $helpers = array('Html', 'Form', 'Javascript');
/**
 * Define $components
 *
 */
    var $components = array('ImageUpload');
    
/**
 * Define $uses
 */
    var $uses = null;

/**
 * Describe edit
 *
 * @param $id
 * @return null
 */
    function setting($id = null) {
        
        if (!empty($this->data)) {
            if ($this->_set($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Global Settings',true)));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Global Settings',true)).__('Please try again.', true));
            }
        }
        $settings=array('server_url','agency_name','agency_address','agency_slogan','date_format','time_format','email_method','email_from','email_from_name','smtp_host','smtp_port','smtp_username','smtp_password','sendmail','days_to_remind','days_to_confirm_attendance');
        foreach($settings as $s){
            $this->set($s,Configure::read($s));
        }
    }
    
    
/**
 * Describe setmymeeting
 *
 * @return null
 */
    function _set($data) {
                
        foreach($data['Systems'] as $d=>$dvalue){
            $tm[$d]=$dvalue;
        }
        
        $output="<?php\n";
        foreach($tm as $mid=>$mdata){
            $output.="\tConfigure::write('$mid','$mdata');\n";
        }
        $output.="?>\n";
        $dfile= APP . 'config' . DS . 'tm.php';
        
        $file = new File($dfile);
        if ($file->exists())  $file->delete(); 
        $file->create();
        
        if (!$file->writable()) return false;
        else {
            $file->open('w');
            $file->write($output);    
            $file->close();
            return true;
        }
    }
    
/**
 * Describe logo
 *
 * @return null
 */
    function logo() {
        
        $logo_uploaded = WWW_ROOT . 'img' . DS . 'logo';
            
        if (!empty($this->data)) {
                
            $logos = array();
            $logo_folder = new Folder($logo_uploaded);
            $logos = $logo_folder->find();
            // one image at a time in this folder
            if (count($logos)) {
                foreach($logos as $logo) {
                    $img = new File($logo_uploaded . DS . $logo);  
                    $img->delete();  
                }
            }
            
            // set the upload destination folder
            $destination = realpath($logo_uploaded) . '/';

            // grab the file
            $file = $this->data['Image']['upload_logo'];

            // upload the image using the image_upload component
            $result = $this->ImageUpload->upload($file, $destination, null, array('type' => 'resizecrop', 'size' => array('155', '80'), 'output' => 'jpg'));

            if (!$result){
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Logo',true)));
            } else {
                // display error
                $errors = $this->ImageUpload->errors;
   
                // piece together errors
                if(is_array($errors)){ $errors = implode("<br />",$errors); }
   
                $this->Session->setFlash($errors);
                
                $this->Session->setFlash(__('Please correct errors below.',true));
                unlink($destination.$this->Upload->result);
            }
        }
        
        $this->set('img_path',$this->getLogo());
    }
    
    function index(){
        if($this->data['type']=='Database'){
            $this->_fixupdatabase();
            $this->Session->setFlash(__("Database Structure had been updated to latest copy",true));
        }elseif($this->data['type']=='language'){
            if(!empty($this->data['language'])){
                $this->changelanguage($this->data['language']);
                $this->Session->setFlash(__("The system language had been changed.",true));
            }
            $this->redirect(array('controller'=>'systems','action'=>'index'));
        }elseif($this->data['type']=='setting'){
            $this->redirect(array('action'=>'setting'));
        }elseif($this->data['type']=='logo'){
            $this->redirect(array('action'=>'logo'));
        }
    }
    
    function _fixupdatabase(){
        $file=$this->createTables();
        
        App::import('ConnectionManager');
        $db= ConnectionManager :: getDataSource('default');
        
        $queries=(explode(';',$file));
        foreach($queries as $qdata){
            $c=strpos($qdata,'CREATE');
            $d=strrpos($qdata,')');
            if($c){
                $ddata= substr($qdata,$c+28,$d-$c-28);
                $f=strpos($ddata,'`');
                $table=substr($ddata,0,$f);
                $fields=set::extract($db->query("Describe ".$table.";"),'{n}.COLUMNS.Field');
                $fdata=explode(',',substr($ddata,$f+3));
                foreach($fdata as $fkey=>$field_detail){
                    if($fkey != count($fdata)-1){
                        $g=strpos($field_detail,'`');
                        $h=strpos($field_detail,'`',$g+1);
                        $field=substr($field_detail,$g+1,$h-$g-1);
                        if(in_array($field,$fields)){
                            $db->query("ALTER TABLE `".$table."` CHANGE `".$field."` ".$field_detail.";" );
                        }else{
                            $db->query("ALTER TABLE `".$table."` ADD ".$field_detail.";" );
                        }
                    }
                }
            }
        }
    }
    
}
?>
