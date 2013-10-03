<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @file        admin\models\ditemdname.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

require_once __DIR__ . '/../../helpers/ditems.php';

/**
 * Ditemdname Field class for the Joomla Framework.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @since       1.6
 */
class JFormFieldDitemDname extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since   1.6
	 */
	protected $type = 'DitemDname';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 * @since   1.6
	 */
	public function getOptions()
	{
		return DitemsHelper::getDnameOptions();
	}
}
