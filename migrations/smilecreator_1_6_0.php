<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Smilie Creator Extension
 * @copyright	(c) 2019-2025 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\smilecreator\migrations;

use phpbb\db\migration\migration;

class smilecreator_1_6_0 extends migration
{
	static public function depends_on()
	{
		return ['\sylver35\smilecreator\migrations\smilecreator_1_1_0'];
	}

	public function update_data()
	{
		return [
			['permission.add', ['u_creator_use', true]],

			// Groups permissions
			['permission.permission_set', ['ADMINISTRATORS', ['u_creator_use'], 'group']],
			['permission.permission_set', ['GLOBAL_MODERATORS', ['u_creator_use'], 'group']],
			['permission.permission_set', ['REGISTERED', ['u_creator_use'], 'group']],
			['permission.permission_set', ['NEWLY_REGISTERED', ['u_creator_use'], 'group']],

			// Roles permissions
			['if', [
				['permission.role_exists', ['ROLE_USER_FULL']],
				['permission.permission_set', ['ROLE_USER_FULL', ['u_creator_use'], 'role']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_STANDARD']],
				['permission.permission_set', ['ROLE_USER_STANDARD', ['u_creator_use'], 'role']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_LIMITED']],
				['permission.permission_set', ['ROLE_USER_LIMITED', ['u_creator_use'], 'role']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_NEW_MEMBER']],
				['permission.permission_set', ['ROLE_USER_NEW_MEMBER', ['u_creator_use'], 'role']],
			]],
		];
	}
}
