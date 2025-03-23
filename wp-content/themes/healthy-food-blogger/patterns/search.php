<?php
 /**
  * Title: Search
  * Slug: healthy-food-blogger/search
  */
?>
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"70%"} -->
<div class="wp-block-column" style="flex-basis:70%"><!-- wp:group {"className":"latestblog-box-wrap","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|40","top":"var:preset|spacing|40","right":"var:preset|spacing|40","left":"var:preset|spacing|40"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group latestblog-box-wrap" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:query {"queryId":14,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:group {"className":"inner-blogs-border-box","style":{"border":{"bottom":{"color":"var:preset|color|border-color","width":"1px"},"top":{},"right":{},"left":{}}}} -->
<div class="wp-block-group inner-blogs-border-box" style="border-bottom-color:var(--wp--preset--color--border-color);border-bottom-width:1px"><!-- wp:post-featured-image /-->

<!-- wp:group {"className":"latest-meta-box","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group latest-meta-box"><!-- wp:post-date {"format":"j M","style":{"typography":{"textTransform":"capitalize"}}} /-->

<!-- wp:comments -->
<div class="wp-block-comments"><!-- wp:comments-title {"showPostTitle":false,"level":6,"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400","textTransform":"capitalize"},"elements":{"link":{"color":{"text":"var:preset|color|body-text"}}},"spacing":{"margin":{"top":"0","bottom":"0"}}},"textColor":"body-text"} /--></div>
<!-- /wp:comments --></div>
<!-- /wp:group -->

<!-- wp:post-title {"style":{"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"400"}},"fontFamily":"rozha-one"} /-->

<!-- wp:post-excerpt {"excerptLength":35,"style":{"typography":{"fontSize":"14px"}}} /-->

<!-- wp:read-more {"content":"read more \u003e","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600","textTransform":"capitalize"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"align":"center","placeholder":"Add text or blocks that will display when a query returns no results.","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}},"textColor":"heading"} -->
<p class="has-text-align-center has-heading-color has-text-color has-link-color"><?php esc_html_e('Sorry Nothing Found. Try searching..!!','healthy-food-blogger'); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%"><!-- wp:template-part {"slug":"sidebar","theme":"healthy-food-blogger","tagName":"div"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->