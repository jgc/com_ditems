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
 * ditem Component HTML Helper
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_ditems
 * @since       1.5
 */
class JHtmlIcon
{
	public static function create($ditem, $params)
	{
		JHtml::_('bootstrap.tooltip');

		$uri = JUri::getInstance();
		$url = JRoute::_(ditemsHelperRoute::getFormRoute(0, base64_encode($uri)));
		$text = JHtml::_('image', 'system/new.png', JText::_('JNEW'), null, true);
		$button = JHtml::_('link', $url, $text);
		$output = '<span class="hasTooltip" title="' . JHtml::tooltipText('COM_DITEMS_FORM_CREATE_DITEM') . '">' . $button . '</span>';
		return $output;
	}

	public static function edit($ditem, $params, $attribs = array())
	{
		$uri = JUri::getInstance();

		if ($params && $params->get('popup'))
		{
			return;
		}

		if ($ditem->state < 0)
		{
			return;
		}

		JHtml::_('bootstrap.tooltip');

		$url	= ditemsHelperRoute::getFormRoute($ditem->id, base64_encode($uri));
		$icon	= $ditem->state ? 'edit.png' : 'edit_unpublished.png';
		$text	= JHtml::_('image', 'system/'.$icon, JText::_('JGLOBAL_EDIT'), null, true);

		if ($ditem->state == 0)
		{
			$overlib = JText::_('JUNPUBLISHED');
		}
		else
		{
			$overlib = JText::_('JPUBLISHED');
		}

		$date = JHtml::_('date', $ditem->created);
		$author = $ditem->created_by_alias ? $ditem->created_by_alias : $ditem->author;

		$overlib .= '&lt;br /&gt;';
		$overlib .= $date;
		$overlib .= '&lt;br /&gt;';
		$overlib .= htmlspecialchars($author, ENT_COMPAT, 'UTF-8');

		$button = JHtml::_('link', JRoute::_($url), $text);

		$output = '<span class="hasTooltip" title="' . JHtml::tooltipText('COM_DITEMS_EDIT') . ' :: ' . $overlib . '">' . $button . '</span>';

		return $output;
	}
}
