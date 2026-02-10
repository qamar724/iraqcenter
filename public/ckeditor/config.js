/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
 


CKEDITOR.editorConfig = function( config ) {
   

    config.extraPlugins = 'colordialog,font,format';

    config.toolbar = [
        // ... other toolbar items ...
        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike',   'RemoveFormat',  ] },
        { name: 'paragraph', items: [ 'BulletedList','NumberedList', '-',   'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
        { name: 'links', items: [ 'Link', 'Unlink'  ] },
        { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule',  'PageBreak' ] },
        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
      
    
    
    ];

	config.filebrowserUploadMethod  = "form";
	config.filebrowserUploadUrl = 'fileupload.php?CKEditorFuncNum=1'
};
