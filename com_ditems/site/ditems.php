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

$controller = JControllerLegacy::getInstance('Ditems');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
