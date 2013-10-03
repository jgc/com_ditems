<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_ditems
 * @file        site\controller.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Ditems Controller
 *
 * @package     Joomla.Site
 * @subpackage  com_ditems
 */
class DitemsController extends JControllerLegacy
{
	public function click()
	{
		$id = $this->input->getInt('id', 0);

		if ($id)
		{
			$model = $this->getModel('Ditem', 'DitemsModel', array('ignore_request' => true));
			$model->setState('ditem.id', $id);
			$model->click();
			$this->setRedirect($model->getUrl());
		}
	}
}
