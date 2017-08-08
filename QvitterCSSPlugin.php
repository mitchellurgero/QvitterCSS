<?php
if (!defined('GNUSOCIAL')) { exit(1); }
class QvitterCSSPlugin extends Plugin {
	public function initialize()
    {
    	return true;
    }
    static function settings($setting)
	{
		$settings['default'] = null; 
		$configphpsettings = common_config('site','qvittercss') ?: array();
		foreach($configphpsettings as $configphpsetting=>$value) {
			$settings[$configphpsetting] = $value;
		}

        // set linkify setting
        common_config_set('linkify', 'bare_domains', $settings['linkify_bare_domains']);

		if(isset($settings[$setting])) {
			return $settings[$setting];
		}
		else {
			return false;
		}
	}
    public function onPluginVersion(array &$versions)
    {
        $versions[] = array('name' => 'QvitterCSS',
            'version' => '1.0',
            'author' => 'Mitchell Urgero <info@urgero.org>',
            'homepage' => 'https://github.com/mitchellurgero/QvitterCSS',
            'rawdescription' => _m('Override Qvitter UI After login'), );

        return true;
    }
	public function onQvitterEndShowHeadElements(Action $action)
	{
		$profile = $action->getScoped();
		$styles = "";
		$user; //user object
		$default = "default.css"; //Blank css to use qvitter's default styles
		$user = common_current_user();
		if($user === null || $user === ""){
			//User is not logged in. Let's try for admin config, or Qvitter default.
			if(self::settings('default') !== null){
				$default = self::settings('default');
			}
		} else {
			//User is logged in - so let's try their theme instead.
			$default = $user->getPref('stitchxd', 'qvittertheme', "default.css");
				
		}
		$dir = realpath(dirname(__FILE__)."/css/");
		if(file_exists($dir."/$default") && $default !== "default.css"){
			$styles = file_get_contents($dir."/$default");
			print "<style>";
			print $styles;
			print "</style>";
		}
		return true;
	}
	public function onRouterInitialized(URLMapper $m)
	{
		$m->connect('settings/qvittertheme',
			array('action' => 'qvittercsssettings'));
	}
	function onEndAccountSettingsNav($action)
    {
        $action_name = $action->trimmed('action');
        $action->menuItem(common_local_url('qvittercsssettings'),
                          // TRANS: Poll plugin menu item on user settings page.
                          _m('MENU', 'QvitterCSS'),
                          // TRANS: Poll plugin tooltip for user settings menu item.
                          _m('Qvitter Theme'),
                          $action_name === 'qvittercsssettings');

        return true;
    }
}
?>