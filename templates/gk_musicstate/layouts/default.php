<?php

/**
 *
 * Default view
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;
//
$app = JFactory::getApplication();
$user = JFactory::getUser();
// getting User ID
$userID = $user->get('id');
// getting params
$option = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');
// defines if com_users
define('GK_COM_USERS', $option == 'com_users' && ($view == 'login' || $view == 'registration'));
// other variables
$btn_login_text = ($userID == 0) ? JText::_('TPL_GK_LANG_LOGIN') : JText::_('TPL_GK_LANG_MY_ACCOUNT');
// make sure that the modal will be loaded
JHTML::_('behavior.modal');
//
$page_suffix_output .= $this->page_suffix;
$page_suffix_output .= ' style' . $this->layout->getTemplateStyle('style');

$tpl_page_suffix = $page_suffix_output != '' ? ' class="'.$page_suffix_output.'" ' : '';

?>
<!DOCTYPE html>
<html lang="<?php echo $this->APITPL->language; ?>">
<head>
	<?php $this->layout->addTouchIcon(); ?>
	<?php if(
			$this->browser->get('browser') == 'ie6' || 
			$this->browser->get('browser') == 'ie7' || 
			$this->browser->get('browser') == 'ie8' || 
			$this->browser->get('browser') == 'ie9'
		) : ?>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<?php endif; ?>
    <?php if($this->API->get('rwd', 1)) : ?>
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
	<?php else : ?>
		<meta name="viewport" content="width=<?php echo $this->API->get('template_width', 1020)+80; ?>">
	<?php endif; ?>
    <jdoc:include type="head" />
    <?php $this->layout->loadBlock('head'); ?>
	<?php $this->layout->loadBlock('cookielaw'); ?>
</head>
<body
	<?php echo $tpl_page_suffix; ?>
	<?php if($this->browser->get("tablet") == true) echo ' data-tablet="true"'; ?>
	<?php if($this->browser->get("mobile") == true) echo ' data-mobile="true"'; ?>
	<?php if($this->browser->get("tablet") == false && $this->browser->get("mobile") == false) echo ' data-desktop="true"'; ?>
	<?php $this->layout->generateLayoutWidths(); ?>
	data-smoothscroll="<?php echo $this->API->get('use_smoothscroll', '1'); ?>"
>	
	<?php
	     // put Google Analytics code
	     echo $this->social->googleAnalyticsParser();
	?>
	<?php if ($this->browser->get('browser') == 'ie7' || $this->browser->get('browser') == 'ie6') : ?>
	<!--[if lte IE 7]>
	<div id="ieToolbar"><div><?php echo JText::_('TPL_GK_LANG_IE_TOOLBAR'); ?></div></div>
	<![endif]-->
	<?php endif; ?>
	
	<?php if(count($app->getMessageQueue())) : ?>
	<jdoc:include type="message" />
	<?php endif; ?>
	
	<div id="gkBg">
	    <header id="gkHeader">
	    	<div>
		    	<div id="gkHeaderNav">                    	
				    <?php $this->layout->loadBlock('logo'); ?>
				    
					 <?php if($this->API->get('menu_type', 'aside') == 'classic') : ?>
		                 <?php if($this->API->get('show_menu', 1)) : ?>
	                     <div id="gkMobileMenu"> <i id="mobile-menu-toggler" class="fa fa-reorder"></i>
	                         <select id="mobileMenu" onChange="window.location.href=this.value;" class="chzn-done">
	                             <?php 
	                 		    	$this->mobilemenu->loadMenu($this->API->get('menu_name','mainmenu')); 
	                 		    	$this->mobilemenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
	                 			?>
	                         </select>
	                     </div>
	                     <?php endif; ?>
	                     
	                     <?php if($this->API->get('show_menu', 1)) : ?>
	                     <div id="gkMainMenu">
	                             <?php
	                     		$this->mainmenu->loadMenu($this->API->get('menu_name','mainmenu')); 
	                     	    $this->mainmenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
	                     	?>
	                     </div>
	                     <?php endif; ?>
	                 <?php else : ?>
	                 <i id="aside-menu-toggler" class="fa fa-reorder"></i>
	                 <?php endif; ?>
	                 
	                 <?php if($this->API->modules('login')) : ?>
	                 <a href="<?php echo $this->API->get('login_url', 'index.php?option=com_users&view=login'); ?>" id="gkLogin"><?php echo ($userID == 0) ? JText::_('TPL_GK_LANG_LOGIN') : JText::_('TPL_GK_LANG_MY_ACCOUNT'); ?></a>
	                 <?php endif; ?>
		    	</div>
	    	</div>
	    	
	   		<?php if($this->API->modules('header')) : ?>
	   		<div id="gkHeaderMod">
	   			<jdoc:include type="modules" name="header" style="<?php echo $this->module_styles['header']; ?>" />
	   		</div>
	   		<?php endif; ?>
	    </header>
	
		<div id="gkPageContent"<?php if(stripos($tpl_page_suffix, 'dark-bottom') !== FALSE) : ?> class="gkDarkBottom"<?php endif; ?>>
	    	<div class="gkPage">
		    	<section id="gkContent">					
					<div id="gkContentWrap"<?php if($this->API->get('sidebar_position', 'right') == 'left') : ?> class="gkSidebarLeft"<?php endif; ?>>
						<?php if($this->API->modules('top1')) : ?>
						<section id="gkTop1" class="gkCols3<?php if($this->API->modules('top1') > 1) : ?> gkNoMargin<?php endif; ?>">
							<div>
								<jdoc:include type="modules" name="top1" style="<?php echo $this->module_styles['top1']; ?>"  modnum="<?php echo $this->API->modules('top1'); ?>" modcol="3" />
							</div>
						</section>
						<?php endif; ?>
						
						<?php if($this->API->modules('top2')) : ?>
						<section id="gkTop2" class="gkCols3<?php if($this->API->modules('top2') > 1) : ?> gkNoMargin<?php endif; ?>">
							<div>
								<jdoc:include type="modules" name="top2" style="<?php echo $this->module_styles['top2']; ?>" modnum="<?php echo $this->API->modules('top2'); ?>" modcol="3" />
							</div>
						</section>
						<?php endif; ?>
						
						<?php if($this->API->modules('breadcrumb') || $this->getToolsOverride()) : ?>
						<section id="gkBreadcrumb">
							<?php if($this->API->modules('breadcrumb')) : ?>
							<jdoc:include type="modules" name="breadcrumb" style="<?php echo $this->module_styles['breadcrumb']; ?>" />
							<?php endif; ?>
							
							<?php if($this->getToolsOverride()) : ?>
								<?php $this->layout->loadBlock('tools/tools'); ?>
							<?php endif; ?>
						</section>
						<?php endif; ?>
						
						<?php if($this->API->modules('mainbody_top')) : ?>
						<section id="gkMainbodyTop">
							<jdoc:include type="modules" name="mainbody_top" style="<?php echo $this->module_styles['mainbody_top']; ?>" />
						</section>
						<?php endif; ?>	
						
						<section id="gkMainbody">
							<?php if(($this->layout->isFrontpage() && !$this->API->modules('mainbody')) || !$this->layout->isFrontpage()) : ?>
								<jdoc:include type="component" />
							<?php else : ?>
								<jdoc:include type="modules" name="mainbody" style="<?php echo $this->module_styles['mainbody']; ?>" />
							<?php endif; ?>
						</section>
						
						<?php if($this->API->modules('mainbody_bottom')) : ?>
						<section id="gkMainbodyBottom">
							<jdoc:include type="modules" name="mainbody_bottom" style="<?php echo $this->module_styles['mainbody_bottom']; ?>" />
						</section>
						<?php endif; ?>
					</div>
					
					<?php if($this->API->modules('sidebar')) : ?>
					<aside id="gkSidebar"<?php if($this->API->modules('sidebar') == 1) : ?> class="gkOnlyOne"<?php endif; ?>>
						<div>
							<jdoc:include type="modules" name="sidebar" style="<?php echo $this->module_styles['sidebar']; ?>" />
						</div>
					</aside>
					<?php endif; ?>
		    	</section>
			</div>
			
			<?php if(stripos($tpl_page_suffix, 'dark-bottom') !== FALSE) : ?>
			<div id="gkDarkBottom"></div>
			<?php endif; ?>
		</div>
		
		<?php if($this->API->modules('bottom1')) : ?>
		<section id="gkBottom1">
			<div class="gkCols6<?php if($this->API->modules('bottom1') > 1) : ?> gkNoMargin<?php endif; ?> gkPage">
				<jdoc:include type="modules" name="bottom1" style="<?php echo $this->module_styles['bottom1']; ?>" modnum="<?php echo $this->API->modules('bottom1'); ?>" />
			</div>
		</section>
		<?php endif; ?>
	    
	    <?php if($this->API->modules('bottom2')) : ?>
	    <section id="gkBottom2">
	    	<div class="gkCols6<?php if($this->API->modules('bottom2') > 1) : ?> gkNoMargin<?php endif; ?> gkPage">
	    		<jdoc:include type="modules" name="bottom2" style="<?php echo $this->module_styles['bottom2']; ?>" modnum="<?php echo $this->API->modules('bottom2'); ?>" />
	    	</div>
	    </section>
	    <?php endif; ?>
	    
	    <?php if($this->API->modules('bottom3')) : ?>
	    <section id="gkBottom3">
	    	<div class="gkCols6<?php if($this->API->modules('bottom3') > 1) : ?> gkNoMargin<?php endif; ?> gkPage">
	    		<jdoc:include type="modules" name="bottom3" style="<?php echo $this->module_styles['bottom3']; ?>" modnum="<?php echo $this->API->modules('bottom3'); ?>" />
	    	</div>
	    </section>
	    <?php endif; ?>
	    
	    <?php if($this->API->modules('bottom4')) : ?>
	    <section id="gkBottom4">
	    	<div class="gkCols6<?php if($this->API->modules('bottom4') > 1) : ?> gkNoMargin<?php endif; ?> gkPage">
	    		<jdoc:include type="modules" name="bottom4" style="<?php echo $this->module_styles['bottom4']; ?>" modnum="<?php echo $this->API->modules('bottom4'); ?>" />
	    	</div>
	    </section>
	    <?php endif; ?>
	    
	    <div id="gkBottomSection">
		    <?php if($this->API->modules('bottom5')) : ?>
		    <section id="gkBottom5">
		    	<div class="gkCols6<?php if($this->API->modules('bottom5') > 1) : ?> gkNoMargin<?php endif; ?> gkPage">
		    		<jdoc:include type="modules" name="bottom5" style="<?php echo $this->module_styles['bottom5']; ?>" modnum="<?php echo $this->API->modules('bottom5'); ?>" />
		    	</div>
		    </section>
		    <?php endif; ?>
		    
		    <?php if($this->API->modules('lang')) : ?>
		    <section id="gkLang">
		    	<div class="gkPage">
		         	<jdoc:include type="modules" name="lang" style="<?php echo $this->module_styles['lang']; ?>" />
		         </div>
		    </section>
		    <?php endif; ?>
		    
		    <?php $this->layout->loadBlock('footer'); ?>
	    </div>
    </div>
    
   	<?php $this->layout->loadBlock('social'); ?>
   	<?php $this->layout->loadBlock('tools/login'); ?>
   	
   	<?php if($this->API->get('menu_type', 'aside') == 'aside') : ?>
	<i id="static-aside-menu-toggler" class="fa fa-reorder"></i>
	<i id="close-menu" class="fa fa-times"></i>
	<nav id="aside-menu">
		<div>
			<?php
				$this->mainmenu->loadMenu($this->API->get('menu_name','mainmenu')); 
		    	$this->mainmenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
			?>
		</div>
	</nav>
	<?php endif; ?>
   		
	<jdoc:include type="modules" name="debug" />
	<script>
	jQuery(document).ready(function(){
   		// Target your .container, .wrapper, .post, etc.
   		jQuery("body").fitVids();
	});
	</script>
      <script src="instagram_api/instagram_api.js"  crossorigin="anonymous"></script>
</body>
</html>