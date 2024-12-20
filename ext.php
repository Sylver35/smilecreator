<?php
/**
*
 * @package		Breizh Smilie Creator Extension
 * @copyright	(c) 2018-2024 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace sylver35\smilecreator;

/**
* @ignore
*/

/**
 * Class ext
 *
 */
class ext extends \phpbb\extension\base
{
	/**
	 * Check whether or not the extension can be enabled.
	 * The current phpBB version should meet or exceed
	 * the minimum version required by this extension:
	 *
	 * Requires phpBB 3.3.13 and PHP 7.2
	 *
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');

		return phpbb_version_compare($config['version'], '3.3.13', '>=') && version_compare(PHP_VERSION, '7.2', '>=');
	}
}
