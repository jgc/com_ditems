<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_ditems
 * @file        site\router.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * @return  array  A named array
 * @return  array
 */
function DitemsBuildRoute(&$query)
{
	$segments = array();

	if (isset($query['task']))
	{
		$segments[] = $query['task'];
		unset($query['task']);
	}
	if (isset($query['id']))
	{
		$segments[] = $query['id'];
		unset($query['id']);
	}

	return $segments;
}

/**
 * @return  array  A named array
 * @param   array
 *
 * Formats:
 *
 * index.php?/ditems/task/id/Itemid
 *
 * index.php?/ditems/id/Itemid
 */
function DitemsParseRoute($segments)
{
	$vars = array();

	// view is always the first element of the array
	$count = count($segments);

	if ($count)
	{
		$count--;
		$segment = array_shift($segments);
		if (is_numeric($segment))
		{
			$vars['id'] = $segment;
		}
		else
		{
			$vars['task'] = $segment;
		}
	}

	if ($count)
	{
		$segment = array_shift($segments);
		if (is_numeric($segment))
		{
			$vars['id'] = $segment;
		}
	}

	return $vars;
}
