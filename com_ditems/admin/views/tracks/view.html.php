<?php
/**
  * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @file        admin\views\tracks\view.html.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of tracks.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @since       1.6
 */
class DitemsViewTracks extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		DitemsHelper::addSubmenu('tracks');

		$this->addToolbar();
		require_once JPATH_COMPONENT .'/models/fields/ditemdname.php';
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/ditems.php';

		$canDo	= DitemsHelper::getActions($this->state->get('filter.category_id'));

		JToolbarHelper::title(JText::_('COM_DITEMS_MANAGER_TRACKS'), 'ditems-tracks.png');

		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton('Slider', 'export', 'JTOOLBAR_EXPORT', 'index.php?option=com_ditems&amp;view=download&amp;tmpl=component', 600, 300);
		if ($canDo->get('core.delete'))
		{
			$bar->appendButton('Confirm', 'COM_DITEMS_DELETE_MSG', 'delete', 'COM_DITEMS_TRACKS_DELETE', 'tracks.delete', false);
			JToolbarHelper::divider();
		}
		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_ditems');
			JToolbarHelper::divider();
		}
		JToolbarHelper::help('JHELP_COMPONENTS_DITEMS_TRACKS');

		JHtmlSidebar::setAction('index.php?option=com_ditems&view=tracks');

		JHtmlSidebar::addFilter(
			JText::_('COM_DITEMS_SELECT_DNAME'),
			'filter_dname_id',
			JHtml::_('select.options', DitemsHelper::getDnameOptions(), 'value', 'text', $this->state->get('filter.dname_id'))
		);

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_CATEGORY'),
			'filter_category_id',
			JHtml::_('select.options', JHtml::_('category.options', 'com_ditems'), 'value', 'text', $this->state->get('filter.category_id'))
		);

		JHtmlSidebar::addFilter(
			JText::_('COM_DITEMS_SELECT_TYPE'),
			'filter_type',
			JHtml::_('select.options', array(JHtml::_('select.option', 1, JText::_('COM_DITEMS_IMPRESSION')), JHtml::_('select.option', 2, JText::_('COM_DITEMS_CLICK'))), 'value', 'text', $this->state->get('filter.type'))
		);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'b.name' => JText::_('COM_DITEMS_HEADING_NAME'),
			'cl.name' => JText::_('COM_DITEMS_HEADING_DNAME'),
			'track_type' => JText::_('COM_DITEMS_HEADING_TYPE'),
			'count' => JText::_('COM_DITEMS_HEADING_COUNT'),
			'track_date' => JText::_('JDATE')
		);
	}
}
