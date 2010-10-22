<?php
// following swiftmailer here: http://bakery.cakephp.org/articles/view/updated-swiftmailer-4-xx-component-with-attachments-and-plugins

class CronShell extends Shell {
    //var $tasks = array('Email');
    var $tasks = array('SwiftMailer');
    var $uses = array('Notification');
        
    function emails(){
        $this->out("Executing Mail command");
        $notifications=$this->Notification->find('all',array('conditions'=>array('notification_date<=now()','notification_sent'=>'0')));
        
        $this->SwiftMailer->instance->sendAs = 'both'; // html, text or both
        $this->SwiftMailer->instance->from = Configure::read('email_from');
        $this->SwiftMailer->instance->fromName = Configure::read('email_from_name');
        
        foreach($notifications as $notification){
            $this->SwiftMailer->instance->to = $notification['Notification']['to'];
            $this->SwiftMailer->set('message', $notification['Notification']['message']);
            $this->SwiftMailer->instance->registerPlugin('LoggerPlugin', new Swift_Plugins_Loggers_EchoLogger());  
            
            switch (Configure::read('email_method')){
                case 'smtp':
                    $this->SwiftMailer->instance->smtpHost = Configure::read('smtp_host');
                    $this->SwiftMailer->instance->smtpPort = Configure::read('smtp_port');
                    $this->SwiftMailer->instance->smtpUsername = Configure::read('smtp_username');
                    $this->SwiftMailer->instance->smtpPassword = Configure::read('smtp_password');
                    $this->SwiftMailer->instance->setTimeout = 30;
                    break;
                case 'sendmail':
                    $this->SwiftMailer->instance->sendmailCmd = Configure::read('sendmail');
                    break;
                case 'native': default:
                    break;
            }
            
            try {
                // using app/views/elemets/email/html/default.ctp + app/views/elemets/email/text/default.ctp
                if(!$this->SwiftMailer->instance->send('default', $notification['Notification']['message_title'],Configure::read('email_method'))) {
                    foreach($this->SwiftMailer->instance->postErrors as $failed_send_to) {
                        $this->log("Failed to send email to: $failed_send_to");
                        $this->out("Failed to send email to: $failed_send_to");
                    }
                }else{
                    $data['id']=$notification['Notification']['id'];
                    $data['notification_sent']=1;
                    $data['notification_date']=date('Y-m-d h:i:s');
                    $this->Notification->save($data);
                }
            }
            catch(Exception $e) {
                  $this->log("Failed to send email: ".$e->getMessage());
                  $this->out("Failed to send email: ".$e->getMessage());
            }
            $this->out("Finished Mail command");  

        }
    }
}
?>
