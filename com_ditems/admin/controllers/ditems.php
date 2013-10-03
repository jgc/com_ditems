<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @file        admin\controllers\ditems.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Ditems list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ditems
 */
class DitemsControllerDitems extends JControllerAdmin
{
	/**
	 * @var	string	The prefix to use with controller messages.
	 */
	protected $text_prefix = 'COM_DITEMS_DITEMS';

	/**
	 * Constructor.
	 *
	 * @param   array An optional associative array of configuration settings.
	 * @see     JController
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('sticky_unpublish',	'sticky_publish');
	}

	/**
	 * Proxy for getModel.
	 * @since   1.6
	 */
	public function getModel($name = 'Ditem', $prefix = 'DitemsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	/**
	 * @since   1.6
	 */
	public function sticky_publish()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$ids    = $this->input->get('cid', array(), 'array');
		$values = array('sticky_publish' => 1, 'sticky_unpublish' => 0);
		$task   = $this->getTask();
		$value  = JArrayHelper::getValue($values, $task, 0, 'int');

		if (empty($ids))
		{
			JError::raiseWarning(500, JText::_('COM_DITEMS_NO_DITEMS_SELECTED'));
		}
		else
		{
			// Get the model.
			$model	= $this->getModel();

			// Change the state of the records.
			if (!$model->stick($ids, $value))
			{
				JError::raiseWarning(500, $model->getError());
			} else {
				if ($value == 1)
				{
					$ntext = 'COM_DITEMS_N_DITEMS_STUCK';
				} else {
					$ntext = 'COM_DITEMS_N_DITEMS_UNSTUCK';
				}
				$this->setMessage(JText::plural($ntext, count($ids)));
			}
		}

		$this->setRedirect('index.php?option=com_ditems&view=ditems');
	}
}
