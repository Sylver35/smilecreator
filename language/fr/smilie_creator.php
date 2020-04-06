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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'SMILIE_CREATOR'		=> 'Créateur de smileys',
	'SHIELDTEXT'			=> 'Texte de la pancarte',
	'FONTCOLOR'				=> 'Couleur du texte',
	'COLOR_DEFAULT'			=> 'Couleur par défaut',
	'COLOR_SILVER'			=> 'Gris',
	'COLOR_DARKRED'			=> 'Rouge foncé',
	'COLOR_RED'				=> 'Rouge',
	'COLOR_ORANGE'			=> 'Orange',
	'COLOR_BROWN'			=> 'Marron',
	'COLOR_YELLOW'			=> 'Jaune',
	'COLOR_GREEN'			=> 'Vert',
	'COLOR_OLIVE'			=> 'Olive',
	'COLOR_CYAN'			=> 'Cyan',
	'COLOR_BLUE'			=> 'Bleu',
	'COLOR_DARKBLUE'		=> 'Bleu foncé',
	'COLOR_INDIGO'			=> 'Indigo',
	'COLOR_VIOLET'			=> 'Violet',
	'COLOR_WHITE'			=> 'Blanc',
	'COLOR_BLACK'			=> 'Noir',
	'SHADOWCOLOR'			=> 'Couleur de l’ombre texte',
	'SHADOWCOLOR_NO'		=> 'Aucune ombre texte',
	'SHIELDSHADOW'			=> 'Ombre de la pancarte',
	'SHIELDSHADOW_ON'		=> 'Activé',
	'SHIELDSHADOW_OFF'		=> 'Désactivé',
	'SMILIECHOOSER'			=> 'Sélection du smiley',
	'RANDOM_SMILIE'			=> 'Smiley au hasard',
	'DEFAULT_SMILIE'		=> 'Smiley par défaut',
	'CREATE_SMILIE'			=> 'Créer',
	'STOP_CREATING'			=> 'Annuler',
	'SC_ERROR'				=> 'ici se trouve votre pancarte… Vous avez oublié le texte…',
	'SC_COPY'				=> 'Breizh Smilie Creator By Sylver35',
));
