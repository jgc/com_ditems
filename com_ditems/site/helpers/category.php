<?php
/**
 * @package     Joomla.Site
* @subpackage  com_ditems
 * @file        site\helpers\category.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Banners Component Category Tree
 *
 * @package     Joomla.Site
 * @subpackage  com_ditems
 */
class DitemsCategories extends JCategories
{
	public function __construct($options = array())
	{
		$options['table'] = '#__ditems';
		$options['extension'] = 'com_ditems';
		parent::__construct($options);
	}
}
