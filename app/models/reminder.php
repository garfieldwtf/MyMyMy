<?php
class Reminder extends AppModel {

	var $name = 'Reminder';
    
    var $validate=array(
        'remind_date'=>array('notEmpty'=>array('rule'=>'notEmpty')),
    );
    
}
?>
