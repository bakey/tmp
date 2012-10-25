<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

//get current school from url and save to $currentschoolid variable
$currntschoolid = 1;
$currntschoolname = '中国人民大学附属中学';

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'励博教育',

	// preloading 'log' component
	'preload'=>array(
		'log',
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
		'application.modules.teach.models.*',
		'application.modules.app.models.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'libedu',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'user'  => array() ,
		'teach' => array() ,
		'app'   => array(),		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
		),

		 'clientScript' => array(
    'class' => 'application.components.NLSClientScript',
    'excludePattern' => '/\.tpl/i', //js regexp, files with matching paths won't be filtered is set to other than 'null'
    //'includePattern' => '/\.php/' //js regexp, only files with matching paths will be filtered if set to other than 'null'
  		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=libedu',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			'enableParamLogging'=> true,
			'enableProfiling'=>true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, trace, info,debug',
					'categories'=>'application.*',
					'logFile' => 'libedu.log',
					'logPath' => 'logs/',
					'maxFileSize' => 50000,
					'enabled' => true,
				),
				// uncomment the following to show log messages on web pages
				
				/*array(
					'class'=>'CWebLogRoute',
					'levels'=>'error , warning , trace , info',
				),*/
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'					=> 'chengchao@libedu.com',
		'uploadFolder'					=> 'bin_data',
		'currentSchoolID'				=> $currntschoolid,
		'currentSchoolName'             => $currntschoolname,
		'user_role_school_admin' 		=> 0,
		'user_role_student' 			=> 1,
		'user_role_teacher' 			=> 2,
		'course_post_status_draft' 		=> 0,
		'course_post_status_published' 	=> 1,
		'max_column_show_post_num'      => 5,
		'web_host'                      => '192.168.1.101',
		'index_path'					=> '/dev/libedu/index.php',  //首页的路径
		'ppt_convert_command'		    => '"E:\OpenOffice.org 3\program\python" "E:\wamp\www\py_convert\DocumentConverter.py" '
	),
	'timeZone'=>"Asia/Shanghai",
	'language'=>"zh_cn",
	'sourceLanguage'=>"zh_cn",
);