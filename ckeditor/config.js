/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
	config.extraPlugins = 'stylesheetparser,link,codemirror,filetools';
	config.contentsCss = '/css/css_styles.css';
	config.stylesheetParser_skipSelectors = /(^body)/i;
	config.enterMode = CKEDITOR.ENTER_BR;

	config.filebrowserBrowseUrl = '/ckfinder/ckfinder.html';
	config.filebrowserUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageBrowseUrl = '/ckfinder/ckfinder.html?type=Images';
	config.filebrowserImageUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

	//config.filebrowserBrowseUrl = '/kcfinder/browse.php?type=files';
   	//config.filebrowserImageBrowseUrl = '/kcfinder/browse.php?type=images';
   	//config.filebrowserUploadUrl = '/kcfinder/upload.php?type=files';
   	//config.filebrowserImageUploadUrl = '/kcfinder/upload.php?type=images';

   	config.styleSet = [];
	config.disableNativeSpellChecker = false;
	config.removePlugins = 'elementspath,image';
	config.height = '300px';
	config.toolbarCanCollapse = true;

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
