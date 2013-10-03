<?php
/**
  * @package     Joomla.Administrator
 * @subpackage  com_ditems
 * @file        admin\views\download\tmpl\default.php
 * @version	3.1.5
 *
 * @copyright   (C) 2013 FalcoAccipiter / bloggundog.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<form
	action="<?php echo JRoute::_('index.php?option=com_ditems&task=tracks.display&format=raw');?>"
	method="post"
	name="adminForm"
	id="download-form"
	class="form-validate">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_DITEMS_TRACKS_DOWNLOAD');?></legend>

		<?php foreach ($this->form->getFieldset() as $field) : ?>
			<?php if (!$field->hidden) : ?>
				<?php echo $field->label; ?>
			<?php endif; ?>
			<?php echo $field->input; ?>
		<?php endforeach; ?>
		<div class="clr"></div>
		<button type="button" onclick="this.form.submit();window.top.setTimeout('window.parent.SqueezeBox.close()', 700);"><?php echo JText::_('COM_DITEMS_TRACKS_EXPORT');?></button>
		<button type="button" onclick="window.parent.SqueezeBox.close();"><?php echo JText::_('COM_DITEMS_CANCEL');?></button>

	</fieldset>
</form>
