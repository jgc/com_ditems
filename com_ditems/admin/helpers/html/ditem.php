<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @file        admin\helpers\ditem.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

/**
 * Ditem HTML class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 */
abstract class JHtmlDitem
{
	/**
	 * Display a batch widget for the dname selector.
	 *
	 * @return  string  The necessary HTML for the widget.
	 *
	 * @since   2.5
	 */
	public static function dnames()
	{
		JHtml::_('bootstrap.tooltip');

		// Create the batch selector to change the dname on a selection list.
		$lines = array(
			'<label id="batch-dname-lbl" for="batch-dname" class="hasTooltip" title="' . JHtml::tooltipText('COM_DITEMS_BATCH_DNAME_LABEL', 'COM_DITEMS_BATCH_DNAME_LABEL_DESC') . '">',
			JText::_('COM_DITEMS_BATCH_DNAME_LABEL'),
			'</label>',
			'<select name="batch[dname_id]" class="inputbox" id="batch-dname-id">',
			'<option value="">' . JText::_('COM_DITEMS_BATCH_DNAME_NOCHANGE') . '</option>',
			'<option value="0">' . JText::_('COM_DITEMS_NO_DNAME') . '</option>',
			JHtml::_('select.options', static::dnamelist(), 'value', 'text'),
			'</select>'
		);

		return implode("\n", $lines);
	}

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 * @since   1.6
	 */
	public static function dnamelist()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('id As value, name As text')
			->from('#__ditem_dnames AS a')
			->order('a.name');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		return $options;
	}

	/**
	 * Returns a pinned state on a grid
	 *
	 * @param   integer       $value			The state value.
	 * @param   integer       $i				The row index
	 * @param   boolean       $enabled		An optional setting for access control on the action.
	 * @param   string        $checkbox		An optional prefix for checkboxes.
	 *
	 * @return  string        The Html code
	 *
	 * @see JHtmlJGrid::state
	 *
	 * @since   2.5.5
	 */
	public static function pinned($value, $i, $enabled = true, $checkbox = 'cb')
	{
		$states = array(
			1 => array(
				'sticky_unpublish',
				'COM_DITEMS_DITEMS_PINNED',
				'COM_DITEMS_DITEMS_HTML_PIN_DITEM',
				'COM_DITEMS_DITEMS_PINNED',
				true,
				'publish',
				'publish'
			),
			0 => array(
				'sticky_publish',
				'COM_DITEMS_DITEMS_UNPINNED',
				'COM_DITEMS_DITEMS_HTML_UNPIN_DITEM',
				'COM_DITEMS_DITEMS_UNPINNED',
				true,
				'unpublish',
				'unpublish'
			),
		);

		return JHtml::_('jgrid.state', $states, $value, $i, 'ditems.', $enabled, true, $checkbox);
	}

}
