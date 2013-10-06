<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_ditens
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * This is the entry point to the component
 * It creates a controller via the JControllerLegacy class
 * It looks at the parameters and loads a fle called controller.php and execute the appropriate task
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/helpers/route.php';

$controller = JControllerLegacy::getInstance('ditems');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
