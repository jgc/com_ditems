<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_ditems
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * ditems Component Category Tree
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_ditems
 * @since       1.6
 */
class ditemsCategories extends JCategories
{
	public function __construct($options = array())
	{
		$options['table'] = '#__ditems';
		$options['extension'] = 'com_ditems';
		parent::__construct($options);
	}
}
