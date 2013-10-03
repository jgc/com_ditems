<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_ditems
 * @file        site/models/ditem.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

/**
 * Ditem model for the Joomla Ditems component.
 *
 * @package     Joomla.Site
 * @subpackage  com_ditems
 * @since       1.5
 */
class DitemsModelDitem extends JModelLegacy
{
	protected $_item;

	/**
	 * Clicks the URL, incrementing the counter
	 *
	 * @return  void
	 *
	 * @since   1.5
	 */
	public function click()
	{
		$id = $this->getState('ditem.id');

		// update click count
		$db = $this->getDbo();
		$query = $db->getQuery(true)
			->update('#__ditems')
			->set('clicks = (clicks + 1)')
			->where('id = ' . (int) $id);

		$db->setQuery($query);

		try
		{
			$db->execute();
		}
		catch (RuntimeException $e)
		{
			JError::raiseError(500, $e->getMessage());
		}

		// track clicks

		$item = $this->getItem();

		$trackClicks = $item->track_clicks;

		if ($trackClicks < 0 && $item->cid)
		{
			$trackClicks = $item->dname_track_clicks;
		}

		if ($trackClicks < 0)
		{
			$config = JComponentHelper::getParams('com_ditems');
			$trackClicks = $config->get('track_clicks');
		}

		if ($trackClicks > 0)
		{
			$trackDate = JFactory::getDate()->format('Y-m-d H');

			$query->clear()
				->select($db->quoteName('count'))
				->from('#__ditem_tracks')
				->where('track_type=2')
				->where('ditem_id=' . (int) $id)
				->where('track_date=' . $db->quote($trackDate));

			$db->setQuery($query);

			try
			{
				$db->execute();
			}
			catch (RuntimeException $e)
			{
				JError::raiseError(500, $e->getMessage());
			}

			$count = $db->loadResult();

			$query->clear();

			if ($count)
			{
				// update count
				$query->update('#__ditem_tracks')
					->set($db->quoteName('count') . ' = (' . $db->quote('count') . ' + 1)')
					->where('track_type=2')
					->where('ditem_id=' . (int) $id)
					->where('track_date=' . $db->quote($trackDate));
			}
			else
			{
				// insert new count
				//sqlsrv change
				$query->insert('#__ditem_tracks')
					->columns(
						array(
							$db->quoteName('count'), $db->quoteName('track_type'),
							$db->quoteName('ditem_id'), $db->quoteName('track_date')
						)
					)
					->values('1, 2,' . (int) $id . ',' . $db->quote($trackDate));
			}

			$db->setQuery($query);

			try
			{
				$db->execute();
			}
			catch (RuntimeException $e)
			{
				JError::raiseError(500, $e->getMessage());
			}
		}
	}

	/**
	 * Get the data for a ditem.
	 *
	 * @return  object
	 */
	public function &getItem()
	{
		if (!isset($this->_item))
		{
			$cache = JFactory::getCache('com_ditems', '');

			$id = $this->getState('ditem.id');

			$this->_item = $cache->get($id);

			if ($this->_item === false)
			{
				// redirect to ditem url
				$db = $this->getDbo();
				$query = $db->getQuery(true)
					->select(
						'a.clickurl as clickurl,' .
							'a.cid as cid,' .
							'a.track_clicks as track_clicks'
					)
					->from('#__ditems as a')
					->where('a.id = ' . (int) $id)

					->join('LEFT', '#__ditem_dnames AS cl ON cl.id = a.cid')
					->select('cl.track_clicks as dname_track_clicks');

				$db->setQuery($query);

				try
				{
					$db->execute();
				}
				catch (RuntimeException $e)
				{
					JError::raiseError(500, $e->getMessage());
				}

				$this->_item = $db->loadObject();
				$cache->store($this->_item, $id);
			}
		}

		return $this->_item;
	}

	/**
	 * Get the URL for a ditem
	 *
	 * @return  string
	 *
	 * @since   1.5
	 */
	public function getUrl()
	{
		$item = $this->getItem();
		$url = $item->clickurl;

		// check for links
		if (!preg_match('#http[s]?://|index[2]?\.php#', $url))
		{
			$url = "http://$url";
		}

		return $url;
	}
}
