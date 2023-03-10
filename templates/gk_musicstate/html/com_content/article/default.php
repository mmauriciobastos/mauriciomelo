<?php

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT .'/helpers');

// Create shortcuts to some parameters.
$params = $this->item->params;
$images = json_decode($this->item->images);
$attribs = json_decode($this->item->attribs);
JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php'); 
if($attribs ) {
    foreach($attribs as $key => $value) {
        if($value != null) {
           $params->set($key, $value);
        }
    }
}

$canEdit	= $this->item->params->get('access-edit');
$urls = json_decode($this->item->urls);
$user		= JFactory::getUser();

// URL for Social API
$cur_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$cur_url = preg_replace('@%[0-9A-Fa-f]{1,2}@mi', '', htmlspecialchars($cur_url, ENT_QUOTES, 'UTF-8'));

// OpenGraph support
$template_config = new JConfig();
$uri = JURI::getInstance();
$article_attribs = json_decode($this->item->attribs, true);

$pin_image = '';
$og_title = $this->escape($this->item->title);
$og_type = 'article';
$og_url = $cur_url;
if (version_compare( JVERSION, '1.8', 'ge' ) && isset($images->image_fulltext) and !empty($images->image_fulltext)) {     $og_image = $uri->root() . htmlspecialchars($images->image_fulltext, ENT_COMPAT, 'UTF-8');
     $pin_image = $uri->root() . htmlspecialchars($images->image_fulltext, ENT_COMPAT, 'UTF-8');
} else {
     $og_image = '';
     preg_match('/src="([^"]*)"/', $this->item->text, $matches);

     if(isset($matches[0])) {
     	$pin_image = $uri->root() . substr($matches[0], 5,-1);
     }
}


$og_site_name = $template_config->sitename;
$og_desc = '';

if(isset($article_attribs['og:title'])) {
     $og_title = ($article_attribs['og:title'] == '') ? $this->escape($this->item->title) : $this->escape($article_attribs['og:title']);
     $og_type = $this->escape($article_attribs['og:type']);
     $og_url = $cur_url;
     $og_image = ($article_attribs['og:image'] == '') ? $og_image : $uri->root() . $article_attribs['og:image'];
     $og_site_name = ($article_attribs['og:site_name'] == '') ? $template_config->sitename : $this->escape($article_attribs['og:site_name']);
     $og_desc = $this->escape($article_attribs['og:description']);
}

$doc = JFactory::getDocument();
$doc->setMetaData( 'og:title', $og_title );
$doc->setMetaData( 'og:type', $og_type );
$doc->setMetaData( 'og:url', $og_url );
$doc->setMetaData( 'og:image', $og_image );
$doc->setMetaData( 'og:site_name', $og_site_name );
$doc->setMetaData( 'og:description', $og_desc );

$useDefList = (($params->get('show_author')) or ($params->get('show_category')) or ($params->get('show_parent_category'))
	or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date'))
	or ($params->get('show_hits')));
?>

<article class="item-page<?php echo $this->pageclass_sfx?>" itemscope itemtype="https://schema.org/Article">
<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />

	<?php if (!empty($this->item->pagination) AND $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative) : ?>
	<?php echo $this->item->pagination; ?>
	<?php endif; ?>
	
	<header<?php if (!$params->get('show_publish_date')) : ?> class="nodate"<?php endif; ?>>
		<?php if ($params->get('show_title')) : ?>
		<h1 itemprop="name">
			<?php echo $this->escape($this->item->title); ?>
		</h1>
		<?php endif; ?>
		
		<?php if (
			$params->get('show_create_date') || 
			$params->get('show_publish_date') || 
			$params->get('show_modify_date') ||  
			($params->get('show_parent_category') && $this->item->parent_slug != '1:root') ||
			$params->get('show_print_icon') || 
			$params->get('show_email_icon') || 
			$params->get('show_category') || 
			$params->get('show_hits') ||
			$canEdit || 
			($params->get('show_author') && !empty($this->item->author))
		) : ?>
		<ul>
			<?php if ($params->get('show_parent_category') && $this->item->parent_slug != '1:root') : ?>
			<li class="parent-category-name">
				<?php	$title = $this->escape($this->item->parent_title);
				$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'" itemprop="genre">'.$title.'</a>';?>
	
				<?php if ($params->get('link_parent_category') and $this->item->parent_slug) : ?>
					<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
				<?php else : ?>
					<?php echo JText::sprintf('COM_CONTENT_PARENT', '<span itemprop="genre">' . $title . '</span>'); ?>
				<?php endif; ?>
			</li>
			<?php endif; ?>

			<?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
			<li class="createdby" itemprop="author" itemscope itemtype="https://schema.org/Person">				
				<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author; ?>
				<?php $author = '<span itemprop="name">' . $author . '</span>'; ?>
				<?php if (!empty($this->item->contactid) && $params->get('link_author') == true): ?>
				<?php
					$needle = 'index.php?option=com_contact&view=contact&id=' . $this->item->contactid;
					$menu = JFactory::getApplication()->getMenu();
					$item = $menu->getItems('link', $needle, true);
					$cntlink = !empty($item) ? $needle . '&Itemid=' . $item->id : $needle;
				?>
					<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', JRoute::_($cntlink), $author, array('itemprop' => 'url'))); ?>
				<?php else: ?>
					<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
				<?php endif; ?>
			</li>
			<?php endif; ?>
			
			<?php if ($params->get('show_category')) : ?>
			<li class="itemCategory">
				<?php $title = $this->escape($this->item->category_title);
				$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'" itemprop="genre">'.$title.'</a>';?>
				<?php if ($params->get('link_category') and $this->item->catslug) : ?>
					<?php echo JText::sprintf('TPL_GK_LANG_PUBLISHED_IN', $url); ?>
				<?php else : ?>
					<?php echo JText::sprintf('TPL_GK_LANG_PUBLISHED_IN', '<span itemprop="genre">' . $title . '</span>'); ?>
				<?php endif; ?>
			</li>
			<?php endif; ?>
			
			<?php if ($params->get('show_hits')) : ?>
			<li class="itemHits">
				<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $this->item->hits; ?>" />
				<?php echo JText::sprintf('TPL_GK_LANG_HITS', $this->item->hits); ?>
			</li>
			<?php endif; ?>
			
			<li class="itemPrintEmail">
				<?php if (!$this->print) : ?>
					<?php if ($params->get('show_print_icon')) : ?>
						<?php echo preg_replace('@<img.*?alt="(.*?)".*?\/>@mis', '$1',JHtml::_('icon.print_popup',  $this->item, $params)); ?>,
					<?php endif; ?>
		
					<?php if ($params->get('show_email_icon')) : ?>
						<?php echo preg_replace('@<img.*?alt="(.*?)".*?\/>@mis', '$1',JHtml::_('icon.email',  $this->item, $params)); ?>
					<?php endif; ?>
					
					<?php if ($canEdit) : ?>
						, <?php echo preg_replace('@<img.*?alt="(.*?)".*?\/>@mis', '$1',JHtml::_('icon.edit', $this->item, $params)); ?>
					<?php endif; ?>
				<?php else : ?>
					<?php echo preg_replace('@<img.*?alt="(.*?)".*?\/>@mis', '$1',JHtml::_('icon.print_screen',  $this->item, $params)); ?>
				<?php endif; ?>
			</li>
			
			<?php if ($params->get('show_publish_date')) : ?>
			<li class="date-hidden">
				<time datetime="<?php echo JHtml::_('date', $this->item->publish_up, JText::_(DATE_W3C)); ?>" itemprop="datePublished"><?php echo JHtml::_('date', $this->item->publish_up, JText::_('TPL_GK_MUSICSTATE_DATE_FORMAT')); ?></time>
			</li>
			<?php endif; ?>
			
			<?php if ($params->get('show_modify_date')) : ?>
			<li class="modified"><time datetime="<?php echo JHtml::_('date', $this->item->modified, JText::_(DATE_W3C)); ?>"  itemprop="dateModified"><?php echo JHtml::_('date', $this->item->modified, JText::_('TPL_GK_MUSICSTATE_DATE_FORMAT')); ?></time></li>
			<?php elseif ($params->get('show_create_date')) : ?>
			<li class="created"><time datetime="<?php echo JHtml::_('date', $this->item->created, DATE_W3C); ?>"  itemprop="dateCreated"><?php echo JHtml::_('date', $this->item->created, JText::_('TPL_GK_MUSICSTATE_DATE_FORMAT')); ?></time></li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
		
		<?php if ($params->get('show_publish_date')) : ?>
		<time datetime="<?php echo JHtml::_('date', $this->item->publish_up, JText::_(DATE_W3C)); ?>"><?php echo JHtml::_('date', $this->item->publish_up, JText::_('j')); ?><span><?php echo JHtml::_('date', $this->item->publish_up, JText::_('M')); ?></span></time>
		<?php endif; ?>
	</header>
	
	<?php  if (isset($images->image_fulltext) and !empty($images->image_fulltext)) : ?>
	<div class="img-fulltext-<?php echo $images->float_fulltext ? $images->float_fulltext : $params->get('float_fulltext'); ?>">
		<img
			<?php if ($images->image_fulltext_caption):
				echo 'class="caption"'.' title="' .$images->image_fulltext_caption .'"';
			endif; ?>
	
			<?php if (empty($images->float_fulltext)):?>
				style="float:<?php echo  $params->get('float_fulltext') ?>"
			<?php else: ?>
				style="float:<?php echo  $images->float_fulltext ?>"
			<?php endif; ?>
			src="<?php echo $images->image_fulltext; ?>" alt="<?php echo $images->image_fulltext_alt; ?>" itemprop="image"/>
	</div>
	<?php endif; ?>

	<div class="itemBody<?php if (!$params->get('show_publish_date')) : ?> nodate<?php endif; ?>">	
		<?php  if (!$params->get('show_intro')) : ?>
			<?php echo $this->item->event->afterDisplayTitle; ?>
		<?php endif; ?>
		
		<?php echo $this->item->event->beforeDisplayContent; ?>
		
		<?php if (isset ($this->item->toc)) : ?>
			<?php echo $this->item->toc; ?>
		<?php endif; ?>
		
		<?php if (isset($urls) AND ((!empty($urls->urls_position) AND ($urls->urls_position=='0')) OR  ($params->get('urls_position')=='0' AND empty($urls->urls_position) ))
				OR (empty($urls->urls_position) AND (!$params->get('urls_position')))): ?>
		<?php echo $this->loadTemplate('links'); ?>
		
		<?php endif; ?>
		
		<?php if ($params->get('access-view')):?>
		
		<?php
		if (!empty($this->item->pagination) AND $this->item->pagination AND !$this->item->paginationposition AND !$this->item->paginationrelative):
			echo $this->item->pagination;
		 endif;
		?>
		
		<span itemprop="articleBody">
			<?php echo $this->item->text; ?>
		</span>
		
		<?php if (isset($urls) AND ((!empty($urls->urls_position)  AND ($urls->urls_position=='1')) OR ( $params->get('urls_position')=='1') )): ?>
		<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>
		
		<?php if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND!$this->item->paginationrelative): ?>
		<?php echo $this->item->pagination; ?>
		<?php endif; ?>
		
		<?php elseif ($params->get('show_noauth') == true and  $user->get('guest') ) : ?>
			<?php echo $this->item->introtext; ?>
		
			<?php //Optional link to let them register to see the whole article. ?>
		
			<?php if ($params->get('show_readmore') && $this->item->fulltext != null) : ?>
				<?php
					$menu = JFactory::getApplication()->getMenu();
					$active = $menu->getActive();
					$itemId = $active->id;
					$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
					$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
				?>
				<p class="readmore">
				<a href="<?php echo $link; ?>">
				<?php $attribs = json_decode($this->item->attribs);  ?>
				<?php
				if ($attribs->alternative_readmore == null) :
					echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
				elseif ($readmore = $this->item->alternative_readmore) :
					echo $readmore;
					if ($params->get('show_readmore_title', 0) != 0) :
					    echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
					endif;
				elseif ($params->get('show_readmore_title', 0) == 0) :
					echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
				else :
					echo JText::_('COM_CONTENT_READ_MORE');
					echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
				endif; ?></a>
				</p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	
	<?php if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND $this->item->paginationrelative): ?>
		<?php echo $this->item->pagination;?>
	<?php endif; ?>
	
	<?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
	    <div class="tags"><span class="tags-label"><?php echo JText::sprintf('TPL_GK_LANG_TAGGED_UNDER'); ?></span>
	       
	    <?php foreach ($this->item->tags->itemTags as $tag) : ?>
	         <a href="<?php echo JRoute::_(TagsHelperRoute::getTagRoute($tag->tag_id . ':' . $tag->alias)) ?>"><?php echo $tag->title; ?></a>
	    <?php endforeach; ?>
	    </div>
	<?php endif; ?>
	
	<gavern:social><div id="gkSocialAPI"></gavern:social>
	   <gavern:social><g:plusone GK_GOOGLE_PLUS_SETTINGS data-href="<?php echo $cur_url; ?>"></g:plusone></gavern:social>
	   <gavern:social><g:plus action="share" GK_GOOGLE_PLUS_SHARE_SETTINGS href="<?php echo $cur_url; ?>"></g:plus></gavern:social>
	   <gavern:social><fb:like href="<?php echo $cur_url; ?>" GK_FB_LIKE_SETTINGS></fb:like></gavern:social>
	   <gavern:social><a href="http://twitter.com/share" class="twitter-share-button" data-text="<?php echo $this->item->title; ?>" data-url="<?php $cur_url; ?>"  gk_tweet_btn_settings>Tweet</a></gavern:social>
	   <gavern:social><a href="http://pinterest.com/pin/create/button/?url=<?php echo $cur_url; ?>&amp;media=<?php echo $pin_image; ?>&amp;description=<?php echo str_replace(" ", "%20", $this->item->title); ?>" class="pin-it-button" count-layout="GK_PINTEREST_SETTINGS"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="<?php echo JText::_('TPL_GK_LANG_PINIT_TITLE'); ?>" /></a></gavern:social>
	 <gavern:social></div></gavern:social>
	 	 
	<?php echo $this->item->event->afterDisplayContent; ?>
</article>