<?php 
class AppSchema extends CakeSchema {
	var $name = 'App';

       	function before($event = array()) {
		return true;
       	}

       	function after($event = array()) {
       	}

	var $attachments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'file' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'filename' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'checksum' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'field' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'size' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        'private' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
	);
	var $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'description' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'group2_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'group_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
    	'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
    var $group2s = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
    var $group2s_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'group2_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $implementors = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'assign_as' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $memberships = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'admin' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'head' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $notifications = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'message_title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'notification_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'notification_sent' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'message' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'to' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'recipient' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'info' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $grades = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'rank' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'grade' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
    var $schemes = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
	var $tasks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ref_no' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'priority' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'task_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500),
		'task_desc' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'start_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'end_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
    var $taskinfos =array(
     	'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'task_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
	var $templates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'template' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $titles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'long_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'superuser' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'scheme_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'grade_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'job_title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 80),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'telephone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'mobile' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'fax' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'address' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'title_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'bahagian' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        'locked' => array('type' => 'datetime', 'null' => true, 'default' => NULL)
	);
	var $statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		//'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'task_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'group2_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'updater' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'task_status' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'percent' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'status_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'closed' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'date_closed' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
    var $clients = array( 
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'), 
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100), 
        'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)) 
    );
    var $meetings = array( 
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'), 
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100), 
        'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)) 
    );
    var $categories = array( 
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'), 
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100), 
        'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)) 
    );
    var $projects = array( 
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'), 
        'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100), 
        'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)) 
    );
    var $reminders =array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'task_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'note' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'remind_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'before' => array('type' => 'integer', 'null' => true, 'default' =>'0'),
        'repeated' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
        'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)) 
    );
}
?>
