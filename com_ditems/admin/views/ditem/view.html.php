<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @file        admin\views\ditem\view.html.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('DitemsHelper', JPATH_COMPONENT.'/helpers/ditems.php');

/**
 * View to edit a ditem.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 */
class DitemsViewDitem extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
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
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		// Since we don't track these assets at the item level, use the category id.
		$canDo		= DitemsHelper::getActions($this->item->catid, 0);

		JToolbarHelper::title($isNew ? JText::_('COM_DITEMS_MANAGER_DITEM_NEW') : JText::_('COM_DITEMS_MANAGER_DITEM_EDIT'), 'ditems.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_ditems', 'core.create')) > 0))
		{
			JToolbarHelper::apply('ditem.apply');
			JToolbarHelper::save('ditem.save');

			if ($canDo->get('core.create'))
			{
				JToolbarHelper::save2new('ditem.save2new');
			}
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			JToolbarHelper::save2copy('ditem.save2copy');
		}

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('ditem.cancel');
		}
		else
		{
			JToolbarHelper::cancel('ditem.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_COMPONENTS_DITEMS_DITEMS_EDIT');
	}
}
