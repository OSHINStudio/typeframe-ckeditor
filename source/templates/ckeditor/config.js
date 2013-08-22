<pm:template>
<![CDATA[
CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';	
	config.toolbar_Typeframe =
	[
		['Maximize'],
		['Source'],
		['Cut','Copy','Paste','PasteFromWord','SpellChecker'],
		['Undo','Redo','-','Find','Replace','-','RemoveFormat'],
		['Link','Unlink','Anchor'],
		['Image','Table','HorizontalRule'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['Format','FontSize']
	];
	config.toolbar = 'Typeframe';
};
]]>
</pm:template>