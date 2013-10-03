<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_ditems
 * @file        site\ditems.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/helpers/route.php';

$user =& JFactory::getUser();
$userId = $user->get( 'id' );

if (!JFactory::getUser()->authorise('core.manage', 'com_ditems'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$controller = JControllerLegacy::getInstance('Ditems');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
