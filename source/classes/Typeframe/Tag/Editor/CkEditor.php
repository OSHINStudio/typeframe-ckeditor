<?php
class Typeframe_Tag_Editor_CkEditor extends Typeframe_Tag_Editor {
	public function output(Pagemill_Data $data, Pagemill_Stream $stream) {
		$id = $data->parseVariables($this->getAttribute('id'));
		if (!$id) $id = self::EditorId();
		$name = $data->parseVariables($this->getAttribute('name'));
		if ($this->getAttribute('config')) {
			$config = $this->getAttribute('config');
		} else {
			$config = TYPEF_WEB_DIR . '/fckeditor/config.js';
		}
		$data = $data->fork();
		$data->set('id', $id);
		$data->set('name', $name);
		$data->set('config', $config);
		$data->set('toolbarset', $data->parseVariables($this->getAttribute('toolbarset')));
		$data->set('stylesheets', $data->parseVariables($this->getAttribute('stylesheets')));
		$data->set('bodyclass', $data->parseVariables($this->getAttribute('bodyclass')));
		$data->set('bodyid', $data->parseVariables($this->getAttribute('bodyid')));
		$data->set('editselector', $data->parseVariables($this->getAttribute('editselector')));
		$include = new Typeframe_Tag_Include('', array('template' => '/ckeditor/ckeditor.inc.html'), $this, $this->doctype());
		$include->process($data, $stream);
	}
}
