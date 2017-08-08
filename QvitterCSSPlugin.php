<?php
if (!defined('GNUSOCIAL')) { exit(1); }
class QvitterCSSPlugin extends Plugin {
	public function initialize()
    {
    	return true;
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
		$user;
		try{
			$user = common_current_user();
		} catch(Exception $e){
			return true;
		}
		if($user === null || user == ""){
			return true;
		}
		$default = Profile_prefs::getData($user->getProfile(), 'stitchxd', 'qvittertheme');
		$dir = realpath(dirname(__FILE__)."/css/");
		if(!file_exists($dir."/$default")){
			$default = "default.css"; //Also make sure the theme exists first :3
		}
		if($default == "default.css"){
			return true;
		} else {
			$styles = file_get_contents($dir."/$default");
		}
		print "<style>";
		print $styles;
		print "</style>";
		//$action->style($styles);
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