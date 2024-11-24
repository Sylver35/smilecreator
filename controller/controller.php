<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Smilie Creator Extension
 * @copyright	(c) 2019-2024 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\smilecreator\controller;
use phpbb\config\config;
use phpbb\request\request;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\language\language;
use phpbb\exception\http_exception;

class controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/** @var string ext path */
	protected $ext_path;

	/** @var string ext path web */
	protected $ext_path_web;

	/**
	 * Controller constructor
	 */
	public function __construct(config $config, request $request, helper $helper, template $template, language $language, $root_path, $php_ext)
	{
		$this->config = $config;
		$this->request = $request;
		$this->helper = $helper;
		$this->template = $template;
		$this->language = $language;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->ext_path = $root_path . 'ext/sylver35/smilecreator/';
		$this->ext_path_web = generate_board_url() . '/ext/sylver35/smilecreator/';
	}

	public function create_smiley()
	{
		$this->language->add_lang('smilie_creator', 'sylver35/smilecreator');
		//Get all available smilies ( *.png )
		if (!function_exists('filelist'))
		{
			include($this->root_path . 'includes/functions_admin.' . $this->php_ext);
		}
		$imglist = filelist($this->ext_path . 'images/', '', 'png');

		$j = $i = 0;
		foreach ($imglist as $key => $images)
		{
			natcasesort($images);
			foreach ($images as $img)
			{
				if ($img == 'schild.png')
				{
					continue;
				}
				//If we have more than 5 smilies in a row, create a new row
				$rows = false;
				if ($j === 5)
				{
					$rows = true;
					$j = 0;
				}
				$value = substr($img, 0, strrpos($img, '.'));
				$number = str_replace('smilie', '', $value);

				// Put the smileys into the table
				$this->template->assign_block_vars('smileys', [
					'NR'		=> $i,
					'SRC'		=> $img,
					'TITLE'		=> $value,
					'SELECT'	=> $number,
					'ROWS'		=> $rows,
				]);
				$i++;
				$j++;
			}
		}
		if ((int) $this->config['smiliecreator_count'] !== $i)
		{
			$this->config->set('smiliecreator_count', $i);
		}

		$this->template->assign_vars([
			'S_IN_CREATE_SMILEY'	=> true,
			'SMILEY_RANDOM'			=> $i + 1,
			'SELECT_FONTCOLOR'		=> $this->build_select(true),
			'SELECT_SHADOWCOLOR'	=> $this->build_select(false),
			'SMILEYS_SRC'			=> $this->ext_path_web . 'images/',
		]);

		return $this->helper->render('smilie_creator.html', $this->language->lang('SMILIE_CREATOR'));
	}

	public function display_smiley()
	{
		$text = (string) $this->request->variable('text', '', true);
		$smiley = (int) $this->request->variable('smiley', 0);
		$fontcolor = (string) $this->request->variable('fontcolor', '');
		$shadowcolor = (string) $this->request->variable('shadowcolor', '');
		$shieldshadow = (int) $this->request->variable('shieldshadow', 0);
		$fontwidth = 6;
		$fontheight = 11;
		$this->language->add_lang('smilie_creator', 'sylver35/smilecreator');

		// Smilie no exist ?
		if ($smiley > $this->config['smiliecreator_count'])
		{
			$smiley = 0;
		}
		// We have a random smilie ?
		if ($smiley === 0)
		{
			$smiley = mt_rand(1, (int) $this->config['smiliecreator_count'] - 1);
		}

		// See if the debug mode is wanted
		$debug = (strrpos($text, 'debug-mode') !== false) ? true : false;

		// Clean the text before
		$text = $this->clean_text($text);

		$output = [];
		$char_count = 40;
		$nb = mb_strlen($text);
		if ($nb > 40)
		{
			$output[0] = substr($text, 0, 40);
			if ($nb > 120)
			{
				$output[1] = substr($text, 40, 40);
				$output[2] = substr($text, 80, 37) . '...';
			}
			else if ($nb > 80)
			{
				$output[1] = substr($text, 40, 40);
				$output[2] = substr($text, 80, 40);
			}
			else
			{
				$output[1] = substr($text, 40, 40);
			}
		}
		else
		{
			$char_count = $nb;
			$output[0] = $text;
		}

		// Maybe we have to tweak here a bit. Depends on the font...
		$in = ($char_count * $fontwidth) + 14;
		$width = ($in < 60) ? 60 : $in;
		$out = sizeof($output);
		$height = ($out * $fontheight) + 35;

		// Main work here
		// Create image and send it to the browser
		$image = @imagepng($this->create_img($smiley, $width, $height, $fontcolor, $shadowcolor, $shieldshadow, $fontwidth, $fontheight, $output), NULL, -1, PNG_ALL_FILTERS);
		header('Pragma: public');
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
		header('Content-Disposition: inline; filename="smilecreator-' . $text . '.png"');
		header('Cache-Control: maxage=10');

		// A good place for debug here if wanted
		if ($debug !== false)
		{
			header('Content-Type: text/html');
		}
		else
		{
			header('Content-Type: image/png');
			header('Content-Length: ' . @filesize(/** @scrutinizer ignore-type */$image));
		}

		$this->template->assign_var('SMILEY', $image);

		$this->template->set_filenames([
			'body'	=> '@sylver35_smilecreator/smiley.html'
		]);

		garbage_collection();
		exit_handler();
	}

	private function build_select($type)
	{
		$list = [
			'silver'	=> 'C0C0C0',
			'darkred'	=> '8B0000',
			'red'		=> 'FF0000',
			'orange'	=> 'FFA500',
			'brown'		=> 'A52A2A',
			'green'		=> '00AA00',
			'olive'		=> '808000',
			'cyan'		=> '00FFFF',
			'blue'		=> '0000FF',
			'darkblue'	=> '00008B',
			'indigo'	=> '4B0082',
			'violet'	=> 'EE82EE',
			'black'		=> '000000',
			'yellow'	=> 'FFFF00',
			'white'		=> 'FFFFFF',
		];

		$select = '<option style="color: black;background-color: white;" value="' . (($type) ? '000000' : '0') . '">' . $this->language->lang($type ? 'COLOR_DEFAULT' : 'SHADOWCOLOR_NO') . '</option>';

		foreach ($list as $color => $code)
		{
			$background = ($color === 'white' || $color === 'yellow') ? 'black' : 'white';
			$select .= '<option name="' . $color . '" style="color: #' . $code . ';background-color: ' . $background . ';" value="' . $code . '">' . $this->language->lang('COLOR_' . strtoupper($color)) . '</option>';
		}

		return $select;
	}

	private function clean_text($text)
	{
		return  str_replace(
			['  ', 'é', 'ê', 'è', 'ë', 'É', 'Ê', 'È', 'Ë', 'à', 'â', 'ä', 'ã', 'À', 'Â', 'Ä', 'Ã', 'î', 'ï', 'Î', 'Ï', 'ó', 'ò', 'ô', 'ö', 'õ', 'Ó', 'Ò', 'Ô', 'Ö', 'Õ', 'ù', 'û', 'ü', 'Ù', 'Û', 'Ü', 'ç', 'Ç', 'ñ', 'Ñ'],
			[' ', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'i', 'i', 'I', 'I', 'o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O', 'u', 'u', 'u', 'U', 'U', 'U', 'c', 'c', 'n', 'n'],
			str_replace(["'", '"', ',', ';', '%', '€', '£', '?', '=', '&lt;', '&gt;', '&quot;', '&amp;', '<', '>', '&'], '', $text)
		);
	}

	private function clean_nb($nb, $range)
	{
		return (($nb + $range) > 255) ? 255 : $nb + $range;
	}

	private function create_img($smiley, $width, $height, $fontcolor, $shadowcolor, $shieldshadow, $fontwidth, $fontheight, $output)
	{
		$image = @imagecreate($width, $height);
		$smiley = @imagecreatefrompng($this->ext_path . 'images/smilie' . $smiley . '.png');
		$schild = @imagecreatefrompng($this->ext_path . 'images/schild.png');

		if ($image === false || $smiley === false || $schild === false)
		{
			throw new http_exception(400, 'CREATE_ERROR');
		}

		$r1 = (int) hexdec(substr($fontcolor, 0, 2));
		$g1 = (int) hexdec(substr($fontcolor, 2, 2));
		$b1 = (int) hexdec(substr($fontcolor, 4, 2));
		$r2 = (int) hexdec(substr($shadowcolor, 0, 2));
		$g2 = (int) hexdec(substr($shadowcolor, 2, 2));
		$b2 = (int) hexdec(substr($shadowcolor, 4, 2));
		$bgcolor = imagecolorallocate($image, 111, 252, 134);
		$txtcolor = imagecolorallocate($image, $r1, $g1, $b1);
		$txt2color = imagecolorallocate($image, $r2, $g2, $b2);
		$bocolor = imagecolorallocate($image, 0, 0, 0);
		$schcolor = imagecolorallocate($image, 255, 255, 255);
		$shadow1color = imagecolorallocate($image, 235, 235, 235);
		$shadow2color = imagecolorallocate($image, 219, 219, 219);
		$smileycolor = imagecolorsforindex($smiley, imagecolorat($smiley, 5, 14));

		imagesetpixel($schild, 1, 14, imagecolorallocate($schild, $this->clean_nb($smileycolor['red'], 52), $this->clean_nb($smileycolor['green'], 59), $this->clean_nb($smileycolor['blue'], 11)));
		imagesetpixel($schild, 2, 14, imagecolorallocate($schild, $this->clean_nb($smileycolor['red'], 50), $this->clean_nb($smileycolor['green'], 52), $this->clean_nb($smileycolor['blue'], 50)));
		imagesetpixel($schild, 1, 15, imagecolorallocate($schild, $this->clean_nb($smileycolor['red'], 50), $this->clean_nb($smileycolor['green'], 52), $this->clean_nb($smileycolor['blue'], 50)));
		imagesetpixel($schild, 2, 15, imagecolorallocate($schild, $this->clean_nb($smileycolor['red'], 22), $this->clean_nb($smileycolor['green'], 21), $this->clean_nb($smileycolor['blue'], 35)));
		imagesetpixel($schild, 1, 16, imagecolorat($smiley, 5, 14));
		imagesetpixel($schild, 2, 16, imagecolorat($smiley, 5, 14));
		imagesetpixel($schild, 5, 16, imagecolorallocate($schild, $this->clean_nb($smileycolor['red'], 22), $this->clean_nb($smileycolor['green'], 21), $this->clean_nb($smileycolor['blue'], 35)));
		imagesetpixel($schild, 6, 16, imagecolorat($smiley, 5, 14));
		imagesetpixel($schild, 5, 15, imagecolorallocate($schild, $this->clean_nb($smileycolor['red'], 52), $this->clean_nb($smileycolor['green'], 59), $this->clean_nb($smileycolor['blue'], 11)));
		imagesetpixel($schild, 6, 15, imagecolorallocate($schild, $this->clean_nb($smileycolor['red'], 50), $this->clean_nb($smileycolor['green'], 52), $this->clean_nb($smileycolor['blue'], 50)));

		if (@imagecopy($image, $schild, ($width / 2 - 3), 0, 0, 0, 6, 4) === false)
		{
			throw new http_exception(400, 'CREATE_ERROR');
		}
		if (@imagecopy($image, $schild, ($width / 2 - 3), ($height - 24), 0, 5, 9, 17) === false)
		{
			throw new http_exception(400, 'CREATE_ERROR');
		}
		if (@imagecopy($image, $smiley, ($width / 2 + 6), ($height - 24), 0, 0, 23, 23) === false)
		{
			throw new http_exception(400, 'CREATE_ERROR');
		}

		imagefilledrectangle($image, 0, 4, $width, ($height - 25), $bocolor);
		imagefilledrectangle($image, 1, 5, ($width - 2), ($height - 26), $schcolor);

		if ($shieldshadow)
		{
			imagefilledpolygon($image, [(($width - 2) / 2 + ((($width - 2) / 4) - 3)), 5, (($width - 2) / 2 + ((($width - 2) / 4) + 3)), 5, (($width - 2) / 2 - ((($width - 2) / 4) - 3)), ($height - 26), (($width - 2) / 2 - ((($width - 2) / 4) + 3)), ($height - 26)], 4, $shadow1color);
			imagefilledpolygon($image, [(($width - 2) / 2 + ((($width - 2) / 4) + 4)), 5, ($width - 2), 5, ($width - 2), ($height - 26), (($width - 2) / 2 - ((($width - 2) / 4) - 4)), ($height - 26)], 4, $shadow2color);
		}

		$i = 0;
		while ($i < sizeof($output))
		{
			if ($shadowcolor)
			{
				imagestring($image, 2, (($width - (strlen(trim($output[$i])) * $fontwidth) - 2) / 2 + 1), ($i * $fontheight + 6), trim($output[$i]), $txt2color);
			}
			imagestring($image, 2, (($width - (strlen(trim($output[$i])) * $fontwidth) - 2) / 2), ($i * $fontheight + 5), trim($output[$i]), $txtcolor);
			$i++;
		}

		imagecolortransparent($image, $bgcolor);
		imageinterlace($image, 1);

		return $image;
	}
}
