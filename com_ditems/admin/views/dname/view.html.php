<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @file        admin\views\dname\view.html.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('DitemsHelper', JPATH_COMPONENT.'/helpers/ditems.php');

/**
 * View to edit a dname.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @since       1.5
 */
class DitemsViewDname extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$canDo		= DitemsHelper::getActions();

		JToolbarHelper::title($isNew ? JText::_('COM_DITEMS_MANAGER_DNAME_NEW') : JText::_('COM_DITEMS_MANAGER_DNAME_EDIT'), 'ditems-dnames.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit')||$canDo->get('core.create')))
		{
			JToolbarHelper::apply('dname.apply');
			JToolbarHelper::save('dname.save');
		}
		if (!$checkedOut && $canDo->get('core.create')) {

			JToolbarHelper::save2new('dname.save2new');
		}
		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			JToolbarHelper::save2copy('dname.save2copy');
		}

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('dname.cancel');
		}
		else
		{
			JToolbarHelper::cancel('dname.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_COMPONENTS_DITEMS_DNAMES_EDIT');
	}
}
