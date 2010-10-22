<?php
class MultiFileComponent extends Object
{
/**
 * Define $controller
 *
 */
    var $controller;
/**
 * Define $args
 *
 */
    var $args=array('action'=>null);

/**
 * Describe startup
 *
 * @param $controller
 * @return null
 */
    function startup(&$controller){
        $args=$controller->passedArgs;
        $this->controller=$controller;
        if($controller->action=="attachment"){
            if($args[0]){
                return $this->downloadfile($args[0]);
            }
        }
    }

/**
 * Describe downloadfile
 *
 * @param $id
 * @return null
 */
    function downloadfile($id){
        $this->mfile=ClassRegistry::init('Attachment','model');
        $dfile=$this->mfile->find('first',array('conditions'=>array('id' => $id)));
        App::import('Component', 'Session');
        $Session = new SessionComponent(); 
        $user = $Session->read('Auth.User'); 
        //check whether the current user have permission to access the file
        if($this->mfile->viewPermission($dfile,$user['id'])==0){
            $Session->setFlash(__('You don\'t have permission to view this file', true));
            $url=$Session->read('history');
            if($url=='getmultidata'){
                $url='committees/find';
            }
            $this->controller->redirect('/'.$url);
        }
        elseif($dfile){
            header("Last-Modified: ".$dfile['Attachment']['modified']);
            header("Content-Type: " .$dfile['Attachment']['type']);
            header("Content-Length: " .$dfile['Attachment']['size']);
            header("Content-disposition: attachment; filename=\"".$dfile['Attachment']['filename']."\"");
            readfile($dfile['Attachment']['file']);
            exit();
        }
        else{
            return false;
        }
    }
}
?>
