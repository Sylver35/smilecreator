<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Smilie Creator Extension
 * @copyright	(c) 2018-2019 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\smilecreator\migrations;

class release_1_0_0_add_bbcode extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [
			// custom function
			['custom', [[&$this, 'install_bbcode']]],
		];
	}

	public function revert_data()
	{
		return [
			['custom', [[&$this, 'remove_bbcode']]],
		];
	}

	public function install_bbcode()
	{
		$sql = 'SELECT bbcode_id FROM ' . $this->table_prefix . "bbcodes WHERE LOWER(bbcode_tag) = 'creator'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			// Create new BBCode
			$sql = 'SELECT MAX(bbcode_id) AS max_bbcode_id FROM ' . $this->table_prefix . 'bbcodes';
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($row)
			{
				$bbcode_id = $row['max_bbcode_id'] + 1;
				// Make sure it is greater than the core BBCode ids...
				if ($bbcode_id <= NUM_CORE_BBCODES)
				{
					$bbcode_id = NUM_CORE_BBCODES + 1;
				}
			}
			else
			{
				$bbcode_id = NUM_CORE_BBCODES + 1;
			}

			if ($bbcode_id <= BBCODE_LIMIT)
			{
				$sql_data = [
					'bbcode_tag'			=> 'creator',
					'bbcode_id'				=> (int) $bbcode_id,
					'bbcode_helpline'		=> '',
					'display_on_posting'	=> 0,
					'bbcode_match'			=> '[creator={SIMPLETEXT1},{NUMBER},{SIMPLETEXT2},{SIMPLETEXT3}]{TEXT}[/creator]',
					'bbcode_tpl'			=> '<img src="|S_CREATOR_BBCODE|app.php/smilecreate/display?smiley={SIMPLETEXT1}&shieldshadow={NUMBER}&fontcolor={SIMPLETEXT2}&shadowcolor={SIMPLETEXT3}&text={TEXT}" alt="{L_IMAGE}" title="{TEXT}" />',
					'first_pass_match'		=> '!\[creator\=([a-zA-Z0-9-+.,_ ]+),([0-9]+),([a-zA-Z0-9-+.,_ ]+),([a-zA-Z0-9-+.,_ ]+)\](.*?)\[/creator\]!iu',
					'first_pass_replace'	=> '\'[creator=${1},${2},${3},${4}:$uid]\' . str_replace(["  ", \'"\', "\'", "&amp;", "&", "$", "!", ",", ";"], [" ", "", "", "", "", "", "", "", ""], ${5}) . \'[/creator:$uid]\'',
					'second_pass_match'		=> '!\[creator\=([a-zA-Z0-9-+.,_ ]+),([0-9]+),([a-zA-Z0-9-+.,_ ]+),([a-zA-Z0-9-+.,_ ]+):$uid\](.*?)\[/creator:$uid\]!su',
					'second_pass_replace'	=> '<img src="|S_CREATOR_BBCODE|app.php/smilecreate/display?smiley=${1}&shieldshadow=${2}&fontcolor=${3}&shadowcolor=${4}&text=${5}" alt="{L_IMAGE}" title="${5}" />',
				];
				$sql = 'INSERT INTO ' . $this->table_prefix . 'bbcodes ' . $this->db->sql_build_array('INSERT', $sql_data);
				$this->db->sql_query($sql);
			}
		}
	}

	public function remove_bbcode()
	{
		$sql = 'DELETE FROM ' . BBCODES_TABLE . " WHERE bbcode_tag = 'creator'";
		$this->db->sql_query($sql);
	}
}
