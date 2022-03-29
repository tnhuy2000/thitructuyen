/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'vi';
	config.uiColor = '#aadc6e';
	config.skin = 'office2013';
	config.height = 500;
	config.removePlugins = 'elementspath';
	config.resize_enabled = false;
	
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'bidi', 'blocks', 'align', 'paragraph' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
	config.removeButtons = 'Save,Print,Paste,PasteFromWord,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,Language,Anchor,Flash,SpecialChar,PageBreak,About';
	
	// config.filebrowserBrowseUrl			= 'http://127.0.0.1/fit/public/vendor/ckfinder/3.5.1.1/ckfinder.html?type=Files';
	// config.filebrowserImageBrowseUrl	= 'http://127.0.0.1/fit/public/vendor/ckfinder/3.5.1.1/ckfinder.html?type=Images';
	// config.filebrowserUploadUrl			= 'http://127.0.0.1/fit/public/vendor/ckfinder/3.5.1.1/core/connector/php/connector.php?command=QuickUpload&type=Files';
	// config.filebrowserImageUploadUrl	= 'http://127.0.0.1/fit/public/vendor/ckfinder/3.5.1.1/core/connector/php/connector.php?command=QuickUpload&type=Images';
	
	config.filebrowserBrowseUrl		= 'https://fit.agu.edu.vn/public/vendor/ckfinder/3.5.1.1/ckfinder.html?type=Files';
	config.filebrowserImageBrowseUrl	= 'https://fit.agu.edu.vn/public/vendor/ckfinder/3.5.1.1/ckfinder.html?type=Images';
	config.filebrowserUploadUrl		= 'https://fit.agu.edu.vn/public/vendor/ckfinder/3.5.1.1/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl	= 'https://fit.agu.edu.vn/public/vendor/ckfinder/3.5.1.1/core/connector/php/connector.php?command=QuickUpload&type=Images';
};