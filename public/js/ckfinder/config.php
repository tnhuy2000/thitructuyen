<?php
	session_start();
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
	ini_set('display_errors', 0);
	$config = array();
	$config['authentication'] = function()
	{
		return isset($_SESSION['ckAuth']);
	};
	$config['licenseName'] = 'nhoangtung';
	$config['licenseKey'] = '*B?D-*1**-U**8-*U**-*6**-G*S*-2**L';
	$config['privateDir'] = array(
		'backend' => 'default',
		'tags' => '.ckfinder/tags',
		'logs' => '.ckfinder/logs',
		'cache' => '.ckfinder/cache',
		'thumbs' => '.ckfinder/thumbs'
	);
	$config['images'] = array(
		'maxWidth' => 1600,
		'maxHeight' => 1200,
		'quality' => 100,
		'sizes' => array(
			'small' => array(
				'width' => 480,
				'height' => 320,
				'quality' => 80
			),
			'medium' => array(
				'width' => 600,
				'height' => 480,
				'quality' => 80
			),
			'large' => array(
				'width' => 800,
				'height' => 600,
				'quality' => 100
			)
		)
	);
	$config['backends'][] = array(
		'name' => 'default',
		'adapter' => 'local',
		'baseUrl' => $_SESSION['baseUrl'],
		'chmodFiles' => 0777,
		'chmodFolders' => 0755,
		'filesystemEncoding' => 'UTF-8'
	);
	$config['defaultResourceTypes'] = '';
	$config['resourceTypes'][] = array(
		'name' => 'Files',
		'directory' => '',
		'maxSize' => 0,
		'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
		'deniedExtensions' => '',
		'backend' => 'default'
	);
	$config['resourceTypes'][] = array(
		'name' => 'Images',
		'directory' => '',
		'maxSize' => 0,
		'allowedExtensions' => 'bmp,gif,jpeg,jpg,png',
		'deniedExtensions' => '',
		'backend' => 'default'
	);
	$config['roleSessionVar'] = 'CKFinder_UserRole';
	$resourceType = isset($_SESSION['resourceType']) ? $_SESSION['resourceType'] : 'Images';
	$config['accessControl'][] = array(
		'role' => '*',
		'resourceType' => $resourceType,
		'folder' => '/',
		'FOLDER_VIEW' => true,
		'FOLDER_CREATE' => false,
		'FOLDER_RENAME' => false,
		'FOLDER_DELETE' => false,
		'FILE_VIEW' => true,
		'FILE_CREATE' => true,
		'FILE_RENAME' => true,
		'FILE_DELETE' => true,
		'IMAGE_RESIZE' => true,
		'IMAGE_RESIZE_CUSTOM' => true
	);
	
	$config['overwriteOnUpload'] = false;
	$config['checkDoubleExtension'] = true;
	$config['disallowUnsafeCharacters'] = false;
	$config['secureImageUploads'] = true;
	$config['checkSizeAfterScaling'] = true;
	$config['htmlExtensions'] = array(
		'html',
		'htm',
		'xml',
		'js'
	);
	$config['hideFolders'] = array(
		'.*',
		'CVS',
		'__thumbs'
	);
	$config['hideFiles'] = array(
		'.*'
	);
	$config['forceAscii'] = false;
	$config['xSendfile'] = false;
	$config['debug'] = false;
	$config['pluginsDirectory'] = __DIR__ . '/plugins';
	$config['plugins'] = array();
	$config['cache'] = array(
		'imagePreview' => 24 * 3600,
		'thumbnails' => 24 * 3600 * 365,
		'proxyCommand' => 0
	);
	$config['tempDirectory'] = sys_get_temp_dir();
	$config['sessionWriteClose'] = true;
	$config['csrfProtection'] = true;
	$config['headers'] = array();
	return $config;
