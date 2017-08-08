<?php

if (!defined('GNUSOCIAL')) { exit(1); }

class QvitterCSSSettingsAction extends SettingsAction
{
	function title()
	{
		return _m('Qvitter Theme Settings');
	}

	function getInstructions()
	{
		return _m('Please select a theme for Qvitter:');
	}

	function showContent()
	{

		$user = common_current_user();

		$this->elementStart('form', array('method' => 'post',
			'id' => 'qvittertheme',
			'class' => 'form_settings',
			'action' => common_local_url('qvittercsssettings')));

		$this->elementStart('fieldset');
		$this->hidden('token', common_session_token());
		$this->elementStart('div');
		try {
			$default = Profile_prefs::getData($user->getProfile(), 'stitchxd', 'qvittertheme');
			$dir = realpath(dirname(__FILE__)."/../css/");
			if(!file_exists($dir."/$default")){
				$default = "default.css"; //Also make sure the theme exists first :3
			}
		} catch (NoResultException $e) {
			$default = "default.css";
		}
		$this->raw("<p><b>Current Theme: $default</b></p>");
		$this->elementEnd('div');
		$this->elementStart('ul', 'form_data');

		$this->elementStart('li');
			$dir = realpath(dirname(__FILE__)."/../css/");
			$files = glob($dir."/*.css");
			$options = "";
			foreach($files as $file){
				$file = explode("/",$file);
				$file = $file[(count($file) - 1)];
				$options .= '<option name="'.$file.'" value="'.$file.'">'.$file.'</option>';
			}
			$html = '<select name="qvitterthemes" id="qvitterthemes" selected="'.$default.'">'.$options.'</select>';
			$this->raw($html."<br>");
		$this->elementEnd('li');


		$this->elementEnd('ul');
		$this->submit('save', _m('BUTTON','Save'));

		$this->elementEnd('fieldset');
		$this->elementEnd('form');
	}

	function doPost()
	{
		$user = common_current_user();
		//echo "<br><br><br><br><br>".json_encode($this);
		Profile_prefs::setData($user->getProfile(), 'stitchxd', 'qvittertheme', $_POST['qvitterthemes']);
		return _('Settings saved!');
	}
}
