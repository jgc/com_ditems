<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @file        admin\helpers\ditems.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Ditems component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 */
class DitemsHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string	The name of the active view.
	 *
	 * @return  void
	 * @since   1.6
	 */
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_DITEMS_SUBMENU_DITEMS'),
			'index.php?option=com_ditems&view=ditems',
			$vName == 'ditems'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_DITEMS_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_ditems',
			$vName == 'categories'
		);
		if ($vName == 'categories')
		{
			JToolbarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_ditems')),
				'ditems-categories');
		}

		JHtmlSidebar::addEntry(
			JText::_('COM_DITEMS_SUBMENU_DNAMES'),
			'index.php?option=com_ditems&view=dnames',
			$vName == 'dnames'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_DITEMS_SUBMENU_TRACKS'),
			'index.php?option=com_ditems&view=tracks',
			$vName == 'tracks'
		);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   integer  The category ID.
	 *
	 * @return  JObject
	 * @since   1.6
	 */
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId))
		{
			$assetName = 'com_ditems';
			$level = 'component';
		}
		else
		{
			$assetName = 'com_ditems.category.'.(int) $categoryId;
			$level = 'category';
		}

		$actions = JAccess::getActions('com_ditems', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}

	/**
	 * @return  boolean
	 * @since   1.6
	 */
	public static function updateReset()
	{
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$nullDate = $db->getNullDate();
		$now = JFactory::getDate();
		$query = $db->getQuery(true)
			->select('*')
			->from('#__ditems')
			->where($db->quote($now) . ' >= ' . $db->quote('reset'))
			->where($db->quoteName('reset') . ' != ' . $db->quote($nullDate) . ' AND ' . $db->quoteName('reset') . '!=NULL')
			->where('(' . $db->quoteName('checked_out') . ' = 0 OR ' . $db->quoteName('checked_out') . ' = ' . (int) $db->quote($user->id) . ')');
		$db->setQuery($query);

		try
		{
			$rows = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
			return false;
		}

		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

		foreach ($rows as $row)
		{
			$purchase_type = $row->purchase_type;

			if ($purchase_type < 0 && $row->cid)
			{
				$dname = JTable::getInstance('Dname', 'DitemsTable');
				$dname->load($row->cid);
				$purchase_type = $dname->purchase_type;
			}

			if ($purchase_type < 0)
			{
				$params = JComponentHelper::getParams('com_ditems');
				$purchase_type = $params->get('purchase_type');
			}

			switch($purchase_type)
			{
				case 1:
					$reset = $nullDate;
					break;
				case 2:
					$date = JFactory::getDate('+1 year '.date('Y-m-d', strtotime('now')));
					$reset = $db->quote($date->toSql());
					break;
				case 3:
					$date = JFactory::getDate('+1 month '.date('Y-m-d', strtotime('now')));
					$reset = $db->quote($date->toSql());
					break;
				case 4:
					$date = JFactory::getDate('+7 day '.date('Y-m-d', strtotime('now')));
					$reset = $db->quote($date->toSql());
					break;
				case 5:
					$date = JFactory::getDate('+1 day '.date('Y-m-d', strtotime('now')));
					$reset = $db->quote($date->toSql());
					break;
			}

			// Update the row ordering field.
			$query->clear()
				->update($db->quoteName('#__ditems'))
				->set($db->quoteName('reset') . ' = ' . $db->quote($reset))
				->set($db->quoteName('impmade') . ' = ' . $db->quote(0))
				->set($db->quoteName('clicks') . ' = ' . $db->quote(0))
				->where($db->quoteName('id') . ' = ' . $db->quote($row->id));
			$db->setQuery($query);

			try
			{
				$db->execute();
			}
			catch (RuntimeException $e)
			{
				JError::raiseWarning(500, $db->getMessage());
				return false;
			}
		}

		return true;
	}

	public static function getDnameOptions()
	{
		$options = array();

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

		// Merge any additional options in the XML definition.
		//$options = array_merge(parent::getOptions(), $options);

		array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_DITEMS_NO_DNAME')));

		return $options;
	}
}
