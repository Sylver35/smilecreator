<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Smilie Creator Extension
 * @copyright	(c) 2018-2020 Sylver35  https://breizhcode.com
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
	'SHIELDTEXT'			=> 'Schildtext',
	'FONTCOLOR'				=> 'Textfarbe',
	'COLOR_DEFAULT'			=> 'Standard-Farbe',
	'COLOR_SILVER'			=> 'Grau',
	'COLOR_DARKRED'			=> 'Dunkelrot',
	'COLOR_RED'				=> 'Rot',
	'COLOR_ORANGE'			=> 'Orange',
	'COLOR_BROWN'			=> 'Braun',
	'COLOR_YELLOW'			=> 'Gelb',
	'COLOR_GREEN'			=> 'Grün',
	'COLOR_OLIVE'			=> 'Olive',
	'COLOR_CYAN'			=> 'Cyan',
	'COLOR_BLUE'			=> 'Blau',
	'COLOR_DARKBLUE'		=> 'Dunkelblau',
	'COLOR_INDIGO'			=> 'Indigo',
	'COLOR_VIOLET'			=> 'Violett',
	'COLOR_WHITE'			=> 'Weiss',
	'COLOR_BLACK'			=> 'Schwarz',
	'SHADOWCOLOR'			=> 'Schattenfarbe',
	'SHADOWCOLOR_NO'		=> 'Kein Textschatten',
	'SHIELDSHADOW'			=> 'Schildschatten',
	'SHIELDSHADOW_ON'		=> 'Aktivieren',
	'SHIELDSHADOW_OFF'		=> 'Deaktivieren',
	'SMILIECHOOSER'			=> 'Smilieauswahl',
	'RANDOM_SMILIE'			=> 'Zufalls-Smilie',
	'DEFAULT_SMILIE'		=> 'Standard-Smilie',
	'CREATE_SMILIE'			=> 'Erstellen',
	'STOP_CREATING'			=> 'Abbrechen',
	'CREATE_ERROR'			=> 'Bild kann nicht erstellt werden',
	'SC_ERROR'				=> 'Hier ist dein Schild… du hast den Text vergessen…',
	'SC_COPY'				=> 'Breizh Smilie Creator By Sylver35',
));
