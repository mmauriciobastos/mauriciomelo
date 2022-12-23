<?php

// No direct access.
defined('_JEXEC') or die;

?>

<footer id="gkFooter">
     <div class="gkPage">
          <?php if($this->API->get('copyrights', '') !== '') : ?>
          <p id="gkCopyrights">
               <?php echo $this->API->get('copyrights', ''); ?>
          </p>
          <?php else : ?>
          <?php
    $app    = JFactory::getApplication();
    $menu   = $app->getMenu();
    $lang   = JFactory::getLanguage();
    if ($menu->getActive() == $menu->getDefault($lang->getTag())) : 
?>
          <p id="gkCopyrights">
               Joomla Template designed by
               <a href="https://www.gavick.com/joomla-templates" title="Joomla template designed by GavickPro" rel="nofollow">GavickPro</a>
          </p>
          <?php else : ?>
          <p id="gkCopyrights">
               Joomla Templates designed by GavickPro
          </p>
          <?php endif; ?>
          <?php endif; ?>
          <?php if($this->API->get('stylearea', '0') == '1') : ?>
          <div id="gkStyleArea">
               <a href="#" id="gkColor1"><?php echo JText::_('TPL_GK_LANG_COLOR_1'); ?></a>
               <a href="#" id="gkColor2"><?php echo JText::_('TPL_GK_LANG_COLOR_2'); ?></a>
               <a href="#" id="gkColor3"><?php echo JText::_('TPL_GK_LANG_COLOR_3'); ?></a>
               <a href="#" id="gkColor4"><?php echo JText::_('TPL_GK_LANG_COLOR_4'); ?></a>
               <a href="#" id="gkColor5"><?php echo JText::_('TPL_GK_LANG_COLOR_5'); ?></a>
               <a href="#" id="gkColor6"><?php echo JText::_('TPL_GK_LANG_COLOR_6'); ?></a>
          </div>
          <?php endif; ?>
          <?php if($this->API->get('framework_logo', '0') == '1') : ?>
          <a href="//gavick.com" rel="nofollow" id="gkFrameworkLogo" title="Gavern Framework">Gavern Framework</a>
          <?php endif; ?>
     </div>
</footer>
