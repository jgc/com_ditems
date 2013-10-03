<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_ditems
 * @file        site\views\ditem.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 */

defined('_JEXEC') or die;

/**
 * HTML View class for the trainingforms component
 *
 * @package     Joomla.Site
 * @subpackage  com_trainingforms
 * @since       1.5
 */
class ditemsViewditem extends JViewLegacy
{
	protected $state;

	protected $item;

	public function display($tpl = null)
	{
		// Get some data from the models
		$item = $this->get('Item');

		if ($this->getLayout() == 'edit')
		{
			$this->_displayEdit($tpl);
			return;
		}

		if ($item->url)
		{
			// redirects to url if matching id found
			JFactory::getApplication()->redirect($item->url);
		}
		else
		{
			//TODO create proper error handling
			JFactory::getApplication()->redirect(JRoute::_('index.php'), JText::_('COM_DITEMSS_ERROR_DITEM_NOT_FOUND'), 'notice');
		}
	}
}