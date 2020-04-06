<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Smilie Creator Extension
 * @copyright	(c) 2018-2020 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\smilecreator\migrations;

use phpbb\db\migration\migration;

class smilecreator_1_1_0 extends migration
{
	static public function depends_on()
	{
		return array('\sylver35\smilecreator\migrations\release_1_0_0_add_bbcode');
	}

	public function update_data()
	{
		return array(
			// Config
			array('config.add', array('smiliecreator_count', 0)),
		);
	}
}
