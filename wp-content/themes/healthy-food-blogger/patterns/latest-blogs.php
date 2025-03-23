<?php
 /**
  * Title: Latest Blogs
  * Slug: healthy-food-blogger/latest-blogs
  */
?>

<!-- wp:group {"className":" wp-block-section alignfull blog-section","style":{"spacing":{"padding":{"right":"0px","left":"0px","top":"0px","bottom":"0px"}}},"backgroundColor":"background","layout":{"type":"default"}} -->
<div class="wp-block-group wp-block-section alignfull blog-section has-background-background-color has-background" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:spacer {"height":"23px"} -->
<div style="height:23px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"10%","className":"latest-blog-left-dummy"} -->
<div class="wp-block-column latest-blog-left-dummy" style="flex-basis:10%"></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%","className":"latest-blogs-wrap"} -->
<div class="wp-block-column latest-blogs-wrap" style="flex-basis:60%"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":5,"className":"blog-heading","style":{"typography":{"fontStyle":"normal","fontWeight":"400","fontSize":"20px"}},"fontFamily":"rozha-one"} -->
<h5 class="wp-block-heading blog-heading has-rozha-one-font-family" style="font-size:20px;font-style:normal;font-weight:400"><?php esc_html_e('Latest Blog Posts','healthy-food-blogger'); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"blog-view-btn","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600","textTransform":"capitalize"}},"textColor":"primary"} -->
<p class="blog-view-btn has-primary-color has-text-color has-link-color" style="font-size:14px;font-style:normal;font-weight:600;text-transform:capitalize"><a href="#"><?php esc_html_e('view all &gt;','healthy-food-blogger'); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"latestblog-box-wrap","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|40","top":"var:preset|spacing|40","right":"var:preset|spacing|40","left":"var:preset|spacing|40"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group latestblog-box-wrap" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:query {"queryId":14,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[],"format":[]}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|50"}},"border":{"bottom":{"color":"var:preset|color|border-color","width":"1px"},"top":{},"right":{},"left":{}}}} -->
<div class="wp-block-columns are-vertically-aligned-center" style="border-bottom-color:var(--wp--preset--color--border-color);border-bottom-width:1px;padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":10,"overlayColor":"heading","isUserOverlayColor":true,"minHeight":250,"isDark":false,"layout":{"type":"default"}} -->
<div class="wp-block-cover is-light" style="min-height:250px"><span aria-hidden="true" class="wp-block-cover__background has-heading-background-color has-background-dim-10 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size"></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"className":"latest-meta-box","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group latest-meta-box"><!-- wp:post-date {"format":"j M","style":{"typography":{"textTransform":"capitalize"}}} /-->

<!-- wp:comments -->
<div class="wp-block-comments"><!-- wp:comments-title {"showPostTitle":false,"level":6,"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400","textTransform":"capitalize"},"elements":{"link":{"color":{"text":"var:preset|color|body-text"}}},"spacing":{"margin":{"top":"0","bottom":"0"}}},"textColor":"body-text"} /--></div>
<!-- /wp:comments --></div>
<!-- /wp:group -->

<!-- wp:post-title {"style":{"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"400"}},"fontFamily":"rozha-one"} /-->

<!-- wp:post-excerpt {"excerptLength":35,"style":{"typography":{"fontSize":"14px"}}} /-->

<!-- wp:read-more {"content":"read more \u003e","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600","textTransform":"capitalize"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:post-template -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%","className":"latest-blogs-sidebar"} -->
<div class="wp-block-column latest-blogs-sidebar" style="flex-basis:20%"><!-- wp:template-part {"slug":"sidebar","theme":"healthy-food-blogger","area":"uncategorized"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"10%","className":"latest-blog-right-dummy"} -->
<div class="wp-block-column latest-blog-right-dummy" style="flex-basis:10%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"23px"} -->
<div style="height:23px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group -->