<?php

/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/* marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>
<?php if (($this->params->get('address_check') > 0) &&  ($this->contact->address || $this->contact->suburb  || $this->contact->state || $this->contact->country || $this->contact->postcode)) : ?>

<div class="contact-address" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
          <?php if ($this->params->get('address_check') > 0) : ?>
          <span class="<?php echo $this->params->get('marker_class'); ?>" > <?php echo $this->params->get('marker_address'); ?> </span>
          <address>
          <?php endif; ?>
          <?php if ($this->contact->address && $this->params->get('show_street_address')) : ?>
          <span class="contact-street" itemprop="streetAddress"> <?php echo nl2br($this->contact->address); ?> </span>
          <?php endif; ?>
          <?php if ($this->contact->suburb && $this->params->get('show_suburb')) : ?>
          <span class="contact-suburb" itemprop="addressLocality"> <?php echo $this->contact->suburb; ?> </span>
          <?php endif; ?>
          <?php if ($this->contact->state && $this->params->get('show_state')) : ?>
          <span class="contact-state" itemprop="addressRegion"> <?php echo $this->contact->state; ?> </span>
          <?php endif; ?>
          <?php if ($this->contact->postcode && $this->params->get('show_postcode')) : ?>
          <span class="contact-postcode" itemprop="postalCode"> <?php echo $this->contact->postcode; ?> </span>
          <?php endif; ?>
          <?php if ($this->contact->country && $this->params->get('show_country')) : ?>
          <span class="contact-country" itemprop="addressCountry"> <?php echo $this->contact->country; ?> </span>
          <?php endif; ?>
          <?php endif; ?>
          <?php if ($this->params->get('address_check') > 0) : ?>
          </address>
</div>
<?php endif; ?>
<?php if($this->params->get('show_email') || $this->params->get('show_telephone')||$this->params->get('show_fax')||$this->params->get('show_mobile')|| $this->params->get('show_webpage') ) : ?>
<div class="contact-contactinfo">
          <?php if ($this->contact->email_to && $this->params->get('show_email')) : ?>
          <div><span class="<?php echo $this->params->get('marker_class'); ?>"  itemprop="email"> <?php echo $this->params->get('marker_email'); ?> </span> <span class="contact-emailto"> <?php echo $this->contact->email_to; ?> </span></div>
          <?php endif; ?>
          <?php if ($this->contact->telephone && $this->params->get('show_telephone')) : ?>
          <div><span class="<?php echo $this->params->get('marker_class'); ?>" > <?php echo $this->params->get('marker_telephone'); ?> </span> <span class="contact-telephone" itemprop="telephone"> <?php echo nl2br($this->contact->telephone); ?> </span></div>
          <?php endif; ?>
          <?php if ($this->contact->fax && $this->params->get('show_fax')) : ?>
          <div> <span class="<?php echo $this->params->get('marker_class'); ?>" > <?php echo $this->params->get('marker_fax'); ?> </span> <span class="contact-fax" itemprop="faxNumber"> <?php echo nl2br($this->contact->fax); ?> </span></div>
          <?php endif; ?>
          <?php if ($this->contact->mobile && $this->params->get('show_mobile')) :?>
          <div><span class="<?php echo $this->params->get('marker_class'); ?>" > <?php echo $this->params->get('marker_mobile'); ?> </span> <span class="contact-mobile" itemprop="telephone"> <?php echo nl2br($this->contact->mobile); ?> </span></div>
          <?php endif; ?>
          <?php if ($this->contact->webpage && $this->params->get('show_webpage')) : ?>
          <div> <span class="<?php echo $this->params->get('marker_class'); ?>" > </span> <span class="contact-webpage"> <a href="<?php echo $this->contact->webpage; ?>" target="_blank" itemprop="url"> <?php echo $this->contact->webpage; ?></a> </span></div>
          <?php endif; ?>
          <?php if($this->params->get('show_email') || $this->params->get('show_telephone')||$this->params->get('show_fax')||$this->params->get('show_mobile')|| $this->params->get('show_webpage') ) : ?>
</div>
<?php endif; ?>
<?php endif; ?>
