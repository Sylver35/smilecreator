<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Smilie Creator Extension
 * @copyright	(c) 2019-2025 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\smilecreator\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\language\language;
use phpbb\auth\auth;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * Listener constructor
	 */
	public function __construct(config $config, helper $helper, template $template, language $language, auth $auth, $php_ext)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->language = $language;
		$this->auth = $auth;
		$this->php_ext = $php_ext;
	}

	/**
	 * Function that returns the subscribed events
	 *
	 * @return array Array with the subscribed events
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.generate_smilies_after'				=> 'load_smilies_creator',
			'core.modify_format_display_text_after'		=> 'parse_bbcodes_after',
			'core.modify_text_for_display_after'		=> 'parse_bbcodes_after',
			'core.permissions'							=> 'permissions',
		];
	}

	/**
	 * @param \phpbb\event\data $event
	 */
	public function load_smilies_creator($event)
	{
		if ($event['mode'] === 'inline' && $this->auth->acl_get('u_creator_use'))
		{
			$this->language->add_lang('smilie_creator', 'sylver35/smilecreator');
			$this->template->assign_var('U_SMILIE_CREATOR', $this->helper->route('sylver35_smilecreator_controller'));
		}
	}

	/**
	 * @param \phpbb\event\data $event
	 */
	public function parse_bbcodes_after($event)
	{
		if (strpos($event['text'], 'S_CREATOR_BBCODE') !== false)
		{
			$app = (!$this->config['enable_mod_rewrite']) ? '/app.' . $this->php_ext : '';
			$event['text'] = str_replace('%7CS_CREATOR_BBCODE%7Capp.php', generate_board_url() . $app, $event['text']);
		}
	}

	/**
	 * @param array $event
	 */
	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_creator_use'] = ['lang'	=> 'ACL_U_CREATOR_USE',	'cat'	=> 'misc'];
		$event['permissions'] = $permissions;
	}
}
