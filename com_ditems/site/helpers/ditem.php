<?php
/**
 * @package     Joomla.Site
* @subpackage  	com_ditems
 * @file        site\helpers\ditem.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * @package     Joomla.Site
 * @subpackage  com_ditems
 */
abstract class DitemHelper
{
	/**
	 * Checks if a URL is an image
	 *
	 * @param string
	 * @return URL
	 */
	public static function isImage($url)
	{
		$result = preg_match('#\.(?:bmp|gif|jpe?g|png)$#i', $url);
		return $result;
	}

	/**
	 * Checks if a URL is a Flash file
	 *
	 * @param string
	 * @return URL
	 */
	public static function isFlash($url)
	{
		$result = preg_match('#\.swf$#i', $url);
		return $result;
	}
}
