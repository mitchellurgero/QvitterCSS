# QvitterCSS Plugin for GNU Social + Qvitter

Allows a user to set their own CSS theme (from a list of admin approved themes) in qvitter.

## Install

1. ```git clone https://github.com/mitchellurgero/QvitterCSS /var/www/html/plugins/QvitterCSS``` (Change path to your plugin path!)
2. Add any CSS themes for Qvitter in QvitterCSS/css/ folder
3. enable in config.php: ```addPlugin('QvitterCSS');```
4. Set a default theme(Make sure it exists in the css folder of the QvitterCSS plugin, or set to null for no theme): ```$config['site']['qvittercss']['default'] = null;```
