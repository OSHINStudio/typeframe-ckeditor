<?php
$extensions = null;
$type = '';
if (isset($_REQUEST['type'])) {
	$type = $_REQUEST['type'];
	// TODO: Check if file types are being enforced for uploads.
	switch ($_REQUEST['type']) {
		case 'image':
			$extensions = array('jpg', 'jpeg', 'gif', 'png');
			break;
		case 'flash':
			$extensions = array('swf');
			break;
	}
}
$base = TYPEF_DIR . '/files/public/userfiles/' . Typeframe::User()->get('userid');
if (!file_exists($base)) {
	mkdir($base);
}
$folder = (isset($_REQUEST['folder']) ? $_REQUEST['folder'] : '');
$currentFolder = "{$base}/{$folder}";
if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['newfolder'])) ) {
	if (!preg_match('/[^a-z0-9\-_]/i', $_POST['newfolder'])) {
		mkdir("{$currentFolder}/{$_POST['newfolder']}");
		$folder = ($folder ? $folder . '/' : '') . $_POST['newfolder'];
		$currentFolder = "{$currentFolder}/{$_POST['newfolder']}";
	}
}
if ($dh = opendir("{$currentFolder}")) {
	while (($file = readdir($dh)) !== false) {
		if ( ($file != ".") && ($file != "..") ) {
			if (is_dir("{$currentFolder}/{$file}")) {
				$pm->addLoop('folders', array("name" => $file));
			} else {
				if ( (is_null($extensions)) || FileManager::HasExtension("{$currentFolder}/{$file}", $extensions) ) {
					$pm->addLoop('files', array("name" => $file, "size" => number_format((filesize("{$currentFolder}/{$file}") / 1024), 2)));
				}
			}
		}
	}
}
closedir($dh);
$pm->setVariable('type', $type);
$pm->setVariable('folder', $folder);
$pm->sortLoop('folders', 'name');
$pm->sortLoop('files', 'name');
