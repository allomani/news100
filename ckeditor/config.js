/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

config.toolbar = 'Full';

config.toolbar_Full =
[
    ['Source','-','Templates'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-', 'SpellChecker', 'Scayt'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat']
    ['BidiLtr', 'BidiRtl'],
   
    
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    
    '/',
    ['Styles','Format','Font','FontSize'],['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    '/',
    ['TextColor','BGColor'], ['BidiLtr', 'BidiRtl'],
    
    ['Link','Unlink'],
    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    ['Maximize', 'ShowBlocks','About']
];

config.toolbar_Basic =
[
    ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
];

      
};
