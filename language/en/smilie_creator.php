<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Smilie Creator Extension
 * @copyright	(c) 2019-2024 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'SMILIE_CREATOR'		=> 'Smilie Creator',
	'SHIELDTEXT'			=> 'Sign text',
	'FONTCOLOR'				=> 'Text colour',
	'COLOR_DEFAULT'			=> 'Default colour',
	'COLOR_SILVER'			=> 'Silver',
	'COLOR_DARKRED'			=> 'Dark red',
	'COLOR_RED'				=> 'Red',
	'COLOR_ORANGE'			=> 'Orange',
	'COLOR_BROWN'			=> 'Brown',
	'COLOR_YELLOW'			=> 'Yellow',
	'COLOR_GREEN'			=> 'Green',
	'COLOR_OLIVE'			=> 'Olive',
	'COLOR_CYAN'			=> 'Cyan',
	'COLOR_BLUE'			=> 'Blue',
	'COLOR_DARKBLUE'		=> 'Dark blue',
	'COLOR_INDIGO'			=> 'Indigo',
	'COLOR_VIOLET'			=> 'Purple',
	'COLOR_WHITE'			=> 'White',
	'COLOR_BLACK'			=> 'Black',
	'SHADOWCOLOR'			=> 'Shadow colour',
	'SHADOWCOLOR_NO'		=> 'No text shadow',
	'SHIELDSHADOW'			=> 'Sign shadow',
	'SHIELDSHADOW_ON'		=> 'Enabled',
	'SHIELDSHADOW_OFF'		=> 'Disabled',
	'SMILIECHOOSER'			=> 'Smilie selection',
	'RANDOM_SMILIE'			=> 'Random smilie',
	'DEFAULT_SMILIE'		=> 'Default smilie',
	'CREATE_SMILIE'			=> 'Create',
	'STOP_CREATING'			=> 'Cancel',
	'CREATE_ERROR'			=> 'Unable to create image',
	'SC_ERROR'				=> 'Here is your sign… you have forgotten the text…',
	'SC_COPY'				=> 'Breizh Smilie Creator By Sylver35',
));
