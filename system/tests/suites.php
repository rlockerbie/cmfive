<?php
/****
 * This file contains configuration of test suites in dev and test environments
 * and a mapping of test request url to determine environment.
 */
 
/*
 * Return an array of paths to tests with basePath prepended
 * Add test suites here
 */ 
function getSuitePaths($basePath) {
	return array(
		'staff'=>$basePath.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'staff' ,
		'tasks'=>$basePath.''.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'task'
		//'crm'=>$basePath.''.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'crm'
		/*'staff1'=>$basePath.'\modules\staff',
		'tasks1'=>$basePath.'\system\modules\tasks',
		'staff2'=>$basePath.'\modules\staff',
		'tasks2'=>$basePath.'\system\modules\tasks',
		'staff3'=>$basePath.'\modules\staff',
		'tasks3'=>$basePath.'\system\modules\tasks',
		'staff4'=>$basePath.'\modules\staff',
		'tasks4'=>$basePath.'\system\modules\tasks',*/
	);
} 
// CONFIG TO BE COPIED AND MODIFIED
$windowsConfig=array(
	'basepath' => 'c:\wamp\www\2picrm',
	'paths' =>getSuitePaths('c:\wamp\www\2picrm'),
	'codeception' =>'C:\wamp\www\2picrm\system\composer\vendor\codeception\codeception\codecept',
	'env'=>'dev'
);
$linuxConfig=array(
	'basepath'=>'/var/www/projects/crm/dev',
	'paths' =>getSuitePaths('/var/www/projects/crm/dev'),
	'codeception' =>'/var/www/webception/webception/vendor/codeception/codeception/codecept',
	'env'=>'test'
);
// hack from base config here	
$steveCRMDevConfig=array_merge(array('basepath'=>'c:\wamp\www\2picrmplus','paths'=>getSuitePaths('c:\wamp\www\2picrmplus')),$windowsConfig);

$testCMFIVEConfig=array_merge(array('basepath'=>'/var/www/projects/cmfive/dev','paths'=>getSuitePaths('/var/www/projects/cmfive/dev')),$linuxConfig);
$testCRMConfig=array_merge(array('basepath'=>'/var/www/projects/crm/dev','paths'=>getSuitePaths('/var/www/projects/crm/dev')),$linuxConfig);

// MAPPING OF URLS TO TEST CONFIGS
$suites=array(
	// dev steve
	'http://2picrm.local'=>$steveCRMDevConfig,
	// test site
	'http://cmfive.dev.code.2pisoftware.com/' =>$testCMFIVEConfig,
	'http://crm.dev.code.2pisoftware.com'=>$testCRMConfig
);
