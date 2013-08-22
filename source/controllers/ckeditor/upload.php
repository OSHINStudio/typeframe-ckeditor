<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$base = TYPEF_DIR . '/files/public/userfiles/' . Typeframe::User()->get('userid');
	if (!file_exists($base)) {
		mkdir($base);
	}
	$folder = (isset($_REQUEST['folder']) ? $_REQUEST['folder'] : '');
	$currentFolder = "{$base}/{$folder}";
	$moved = FileManager::MoveUpload($_FILES['upload']['tmp_name'], "{$currentFolder}/{$_FILES['upload']['name']}");
	$message = '';
	if ($moved) {
		$moved = basename($moved);
	} else {
		$moved = '';
		$message = 'Upload failed.';
	}
	if ( (!empty($_REQUEST['command'])) && ($_REQUEST['command'] == 'BrowserUpload') ) {
		Typeframe::Redirect('File uploaded.', TYPEF_WEB_DIR . '/ckeditor/browse?type=' . $_REQUEST['type'] . '&folder=' . $_REQUEST['folder'] . '&CKEditorFuncNum=' . $_REQUEST['CKEditorFuncNum']);
	} else {
		if ($moved) {
			$pm->setVariable('file', TYPEF_WEB_DIR . '/files/public/userfiles/' . Typeframe::User()->get('userid') . ($folder ? '/' . $folder : '') . '/' . $moved);
		}
		$pm->setVariable('funcnum', $_REQUEST['CKEditorFuncNum']);
		$pm->setVariable('message', $message);
	}
}
