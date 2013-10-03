<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @file        admin\views\dnames\view.html.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of dnames.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @since       1.6
 */
class DitemsViewDnames extends JViewLegacy
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

		DitemsHelper::addSubmenu('dnames');

		$this->addToolbar();
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

		$canDo	= DitemsHelper::getActions();

		JToolbarHelper::title(JText::_('COM_DITEMS_MANAGER_DNAMES'), 'ditems-dnames.png');
		if ($canDo->get('core.create'))
		{
			JToolbarHelper::addNew('dname.add');
		}
		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('dname.edit');
		}
		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('dnames.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('dnames.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::archiveList('dnames.archive');
			JToolbarHelper::checkin('dnames.checkin');
		}
		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'dnames.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('dnames.trash');
		}

		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_ditems');
		}

		JToolbarHelper::help('JHELP_COMPONENTS_DITEMS_DNAMES');

		JHtmlSidebar::setAction('index.php?option=com_ditems&view=dnames');

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_state',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
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
			'a.status' => JText::_('JSTATUS'),
			'a.name' => JText::_('COM_DITEMS_HEADING_DNAME'),
			'contact' => JText::_('COM_DITEMS_HEADING_CONTACT'),
			'dname_name' => JText::_('COM_DITEMS_HEADING_DNAME'),
			'nditems' => JText::_('COM_DITEMS_HEADING_ACTIVE'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
