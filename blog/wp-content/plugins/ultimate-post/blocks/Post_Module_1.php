<?php
namespace ULTP\blocks;

defined('ABSPATH') || exit;

class Post_Module_1{

    public function __construct() {
        add_action('init', array($this, 'register'));
    }

    public function get_attributes() {

        return array(
            'blockId' => '',
            'previewImg' => '',
            //--------------------------
            //      Layout
            //--------------------------
            'layout' => 'layout1',

            //--------------------------
            //      Query Setting
            //--------------------------
            'queryQuick' => '',
            'queryNumPosts' => (object)['lg'=>5],
            'queryNumber' => 5,
            'queryType' => 'post',
            'queryTax' => 'category',
            'queryTaxValue' => '[]',
            'queryRelation' => 'OR',
            'queryOrderBy' => 'date',
            'metaKey' => 'custom_meta_key',
            'queryOrder' => 'desc',
            // Include Remove from Version 2.5.4
            'queryInclude' => '',
            'queryExclude' => '[]',
            'queryAuthor' => '[]',
            'queryOffset' => '0',
            'queryExcludeTerm' => '[]',
            'queryExcludeAuthor' => '[]',
            'querySticky' => true,
            'queryUnique' => '',
            'queryPosts' => '[]',
            'queryCustomPosts' => '[]',
            //--------------------------
            //      General Setting
            //--------------------------
            'titleShow' => true,
            'titleStyle' => 'none',
            'headingShow' => true,
            'excerptShow' => true,
            'catShow' => true,
            'metaShow' => true,
            'showImage' => true,
            'filterShow' => false,
            'paginationShow' => false,
            'readMore' => false,
            'contentTag' => 'div',
            'openInTab' => false,
            'notFoundMessage' => 'No Post Found',

            //--------------------------
            //      Heading Setting/Style
            //--------------------------
            'headingText' => 'Post Module #1',
            'headingURL' => '',
            'headingBtnText' => 'View More',
            'headingStyle' => 'style9',
            'headingTag' => 'h2',
            'headingAlign' => 'left',
            'subHeadingShow' => false,
            'subHeadingText' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut sem augue. Sed at felis ut enim dignissim sodales.',
            
            //--------------------------
            //      Title Setting/Style
            //--------------------------
            'titleTag' => 'h3',
            'titlePosition' => true,
            'titleLength' => 0,

            //--------------------------
            // Content Setting/Style
            //--------------------------
            
            'varticalAlign' => 'middle',
            'showSeoMeta' => false,
            'showSmallExcerpt' => false,
            'showFullExcerpt' => false,
            'excerptLimit' => 20,
            
            //--------------------------
            // Category Setting/Style
            //--------------------------
            'maxTaxonomy'=> '30',
            'taxonomy' => 'category',
            'showSmallCat' => false,
            'catStyle' => 'classic',
            'catPosition' => 'aboveTitle',
            'customCatColor' => false,
            'seperatorLink' => admin_url( 'edit-tags.php?taxonomy=category' ),
            'onlyCatColor' => false,
            
            //--------------------------
            // Meta Setting/Style
            //--------------------------
            'showSmallMeta' => true,
            'metaPosition' => 'top',
            'metaStyle' => 'icon',
            'authorLink' => true,
            'metaSeparator' => 'dot',
            'metaList' => '["metaAuthor","metaDate","metaRead"]',
            'metaMinText' => 'min read',
            'metaAuthorPrefix' => 'By',
            'metaDateFormat' => 'M j, Y',
            'metaListSmall' => '["metaAuthor","metaDate"]',
            
            //--------------------------
            // Image Setting/Style
            //--------------------------
            'columnFlip' => false,
            'imgCrop' => 'full',
            'imgCropSmall' => (ultimate_post()->get_setting('disable_image_size') == 'yes' ? 'full' : 'ultp_layout_square'),
            'imgAnimation' => 'opacity',
            'imgOverlay' =>  false,
            'imgOverlayType' => 'default',
            'fallbackEnable' => true,
            'fallbackImg' => '',
            'imgSrcset' => false,
            'imgLazy' => false,

            //--------------------------
            // Video Setting/Style
            //--------------------------
            'vidIconEnable' => true,
            'popupAutoPlay' => true,
            'iconSize' => (object)['lg'=>'40', 'sm'=> '30', 'xs'=> '30', 'unit' => 'px'],
            // by default should be off
            'enablePopup' => false,
            'enablePopupTitle' => true,
            
            //--------------------------
            // Separator
            //--------------------------
            'separatorShow' => false,
            
            //--------------------------
            // Read more Setting/Style
            //--------------------------
            'showSmallBtn' => false,
            'readMoreText' => '',
            'readMoreIcon' => 'rightArrowLg',
            
            //--------------------------
            // Filter Setting/Style
            //--------------------------
            'filterBelowTitle' => false,
            'filterType' => 'category',
            'filterText' => 'all',
            'filterValue' => '[]',
            'filterMobile' => true,
            'filterMobileText' => 'More',

            //--------------------------
            // Pagination Setting/Style
            //--------------------------
            'paginationType' => 'navigation',
            'paginationNav' => 'textArrow',
            'navPosition' => 'topRight',
            
            //--------------------------
            //  Wrapper Style
            //--------------------------
            'advanceId' => '',
            'advanceZindex' => '',
            'hideExtraLarge' => false,
            'hideTablet' => false,
            'hideMobile' => false,
            'advanceCss' => '',
            'currentPostId' =>  '',
        );
    }

    public function register() {
        register_block_type( 'ultimate-post/post-module-1',
            array(
                'editor_script' => 'ultp-blocks-editor-script',
                'editor_style' => 'ultp-blocks-editor-css',
                'render_callback' => array($this, 'content')
            )
        );
    }

    public function content($attr, $noAjax) {
        $attr = wp_parse_args($attr, $this->get_attributes());
        global $unique_ID;

        if (!$noAjax) {
            $paged = is_front_page() ? get_query_var('page') : get_query_var('paged');
            $attr['paged'] = $paged ? $paged : 1;
        }
        if($attr['queryUnique'] && isset($attr['savedQueryUnique'])) {
            $unique_ID = $attr['savedQueryUnique'];
        }

        $bigloop = '';
        $block_name = 'post-module-1';
        $wraper_before = $wraper_after = $post_loop = '';
        $attr['queryNumber'] = ultimate_post()->get_post_number(5, $attr['queryNumber'], $attr['queryNumPosts']);
        $recent_posts = new \WP_Query( ultimate_post()->get_query( $attr ) );
        $pageNum = ultimate_post()->get_page_number($attr, $recent_posts->found_posts);
        // Dummy Img Url
        $dummy_url = ULTP_URL.'assets/img/ultp-fallback-img.png';

        // Loadmore and Unique content 
        if($attr['queryUnique'] && isset($attr['loadMoreQueryUnique']) && $attr['paginationShow'] && ($attr['paginationType'] == 'loadMore')) {
            $unique_ID = $attr['loadMoreQueryUnique'];
            $current_unique_posts = $attr['ultp_current_unique_posts'];
        }

        if ($recent_posts->have_posts()) {
            
            $wraper_before .= '<div '.($attr['advanceId']?'id="'.$attr['advanceId'].'" ':'').' class="wp-block-ultimate-post-'.$block_name.' ultp-block-'.$attr["blockId"].''.(isset($attr["align"])? ' align' .$attr["align"]:'').''.(isset($attr["className"])?' '.$attr["className"]:'').'">';
                $wraper_before .= '<div class="ultp-block-wrapper">';

                    // Loading
                    $wraper_before .= ultimate_post()->loading();

                    if ($attr['headingShow'] || $attr['filterShow'] || $attr['paginationShow']) {
                        $wraper_before .= '<div class="ultp-heading-filter">';
                            $wraper_before .= '<div class="ultp-heading-filter-in">';
                                
                                // Heading
                                include ULTP_PATH.'blocks/template/heading.php';
                                
                                if ($attr['filterShow'] || $attr['paginationShow']) {
                                    $wraper_before .= '<div class="ultp-filter-navigation">';
                                        // Filter
                                        if($attr['filterShow'] && $attr['queryType'] != 'posts' && $attr['queryType'] != 'customPosts') {
                                            include ULTP_PATH.'blocks/template/filter.php';
                                        }
                                        // Navigation
                                        if ($attr['paginationShow'] && ($attr['paginationType'] == 'navigation') && ($attr['navPosition'] == 'topRight')) {
                                            include ULTP_PATH.'blocks/template/navigation-before.php';
                                        }
                                    $wraper_before .= '</div>';
                                }

                            $wraper_before .= '</div>';
                        $wraper_before .= '</div>';
                    }
             
                    $wraper_before .= '<div class="ultp-block-items-wrap ultp-block-post-module1 ultp-block-content-'.$attr['varticalAlign'].' ultp-block-content-'.($attr['columnFlip'] ? 'true' : 'false').' ultp-'.$attr['layout'].'">';
                        $idx = 0; // $idx = $noAjax ? 1 : 0;
                        while ( $recent_posts->have_posts() ): $recent_posts->the_post();
                            
                            include ULTP_PATH.'blocks/template/data.php';

                            include ULTP_PATH.'blocks/template/category.php';

                            if ($attr['queryUnique']) {
                                $unique_ID[$attr['queryUnique']][] = $post_id;
                                $current_unique_posts[] = $post_id;
                            }

                            $post_loop .= '<'.$attr['contentTag'].' class="ultp-block-item post-id-'.$post_id.'">';

                                $post_loop .= '<div class="ultp-block-content-wrap">';
                                    if(($post_thumb_id || $attr['fallbackEnable']) && $attr['showImage'] && ($idx == 0 || $attr['layout'] == 'layout2' || $attr['layout'] == 'layout3' || $attr['layout'] == 'layout5')) {
                                        $post_loop .= '<div class="ultp-block-image ultp-block-image-'.$attr['imgAnimation'].($attr["imgOverlay"] ? ' ultp-block-image-overlay ultp-block-image-'.$attr["imgOverlayType"].' ultp-block-image-'.$attr["imgOverlayType"].$idx : '' ).'">';
                                            if ($idx == 0) {
                                                $post_loop .= '<a href="'.$titlelink.'" '.($attr['openInTab'] ? 'target="_blank"' : '').'>';
                                                // Post Image Id
                                                $block_img_id = $post_thumb_id ? $post_thumb_id : ($attr['fallbackEnable'] && isset($attr['fallbackImg']['id']) ? $attr['fallbackImg']['id'] : '');
                                                // Post Image 
                                                if($post_thumb_id || ($attr['fallbackEnable'] && $block_img_id)) {
                                                    $post_loop .= ultimate_post()->get_image($block_img_id, $attr['imgCrop'], '', $title, $attr['imgSrcset'], $attr['imgLazy']);
                                                } else {
                                                    $video = ultimate_post()->get_youtube_id($post_video);
                                                    $post_loop .= '<img  src="'.($video ? 'https://img.youtube.com/vi/'.$video.'/0.jpg' : $dummy_url).'" alt="dummy-img" />';
                                                }
                                                $post_loop .= '</a>';
                                                if($post_video){
                                                    $post_loop .= '<div enableAutoPlay="'.$attr['popupAutoPlay'].'" class="ultp-video-icon">'.ultimate_post()->svg_icon('play_line').'</div>';
                                                }
                                            } else {
                                                if ($attr['layout'] == 'layout2' || $attr['layout'] == 'layout3' || $attr['layout'] == 'layout5') {
                                                    $post_loop .= '<a href="'.$titlelink.'" '.($attr['openInTab'] ? 'target="_blank"' : '').'>';
                                                    // Post Image Id
                                                    $block_img_id = $post_thumb_id ? $post_thumb_id : ($attr['fallbackEnable'] && isset($attr['fallbackImg']['id']) ? $attr['fallbackImg']['id'] : '');
                                                    // Post Image 
                                                    if($post_thumb_id || ($attr['fallbackEnable'] && $block_img_id)) {
                                                        $post_loop .= ultimate_post()->get_image($block_img_id, $attr['imgCropSmall'], '', $title, $attr['imgSrcset'], $attr['imgLazy']);
                                                    } else {
                                                        $video = ultimate_post()->get_youtube_id($post_video);
                                                        $post_loop .= '<img  src="'.($video ? 'https://img.youtube.com/vi/'.$video.'/0.jpg' : $dummy_url).'" alt="dummy-img" />';
                                                    }
                                                    $post_loop .= '</a>';
                                                    if($post_video){
                                                        $post_loop .= '<div enableAutoPlay="'.$attr['popupAutoPlay'].'" class="ultp-video-icon">'.ultimate_post()->svg_icon('play_line').'</div>';
                                                    }
                                                }
                                            }
                                            if (($attr['catPosition'] != 'aboveTitle') && ($idx == 0 || $attr['showSmallCat']) && $attr['catShow'] ) {
                                                $post_loop .= '<div class="ultp-category-img-grid">'.$category.'</div>';
                                            }
                                        $post_loop .= '</div>';
                                    }
                                    $post_loop .= '<div class="ultp-block-content">';
                                        // Category
                                        if (($attr['catPosition'] == 'aboveTitle') && ($idx == 0 || $attr['showSmallCat'] ) && $attr['catShow']) {
                                            $post_loop .= $category;
                                        }
                                        // Title
                                        if ($title && $attr['titleShow'] && $attr['titlePosition'] == 1) {
                                            include ULTP_PATH.'blocks/template/title.php';
                                        }                                        
                                        // Meta
                                        if ($attr['metaPosition'] =='top' ) {
                                            include ULTP_PATH.'blocks/template/meta.php';
                                        }                                        
                                        // Title
                                        if ($title && $attr['titleShow'] && $attr['titlePosition'] == 0) {
                                            include ULTP_PATH.'blocks/template/title.php';
                                        }
                                        // Excerpt
                                        if (($idx == 0 || $attr['showSmallExcerpt']) && $attr['excerptShow']) {
                                            $post_loop .= '<div class="ultp-block-excerpt">'.ultimate_post()->get_excerpt($post_id, $attr['showSeoMeta'], $attr['showFullExcerpt'], $attr['excerptLimit']).'</div>';
                                        }
                                        
                                        // Read More
                                        if ($attr['readMore'] && ($idx == 0 || $attr['showSmallBtn'])) {
                                            $post_loop .= '<div class="ultp-block-readmore"><a aria-label="'.$title.'" href="'.$titlelink.'" '.($attr['openInTab'] ? 'target="_blank"' : '').'>'.($attr['readMoreText'] ? $attr['readMoreText'] : esc_html__( "Read More", "ultimate-post" )).ultimate_post()->svg_icon($attr['readMoreIcon']).'</a></div>';
                                        }
                                        // Bottom
                                        if ($attr['metaPosition'] =='bottom' ) {
                                            include ULTP_PATH.'blocks/template/meta.php';
                                        }
                                    $post_loop .= '</div>';
                                $post_loop .= '</div>';
                                if($post_video && $attr['enablePopup'] && ($attr['layout'] != 'layout1' && $attr['layout'] != 'layout4' || $idx == 0)) {
                                    include ULTP_PATH.'blocks/template/video_popup.php';
                                }
                            $post_loop .= '</'.$attr['contentTag'].'>';
                            
                            if ($idx == 0) {
                                $bigloop = $post_loop;
                                $post_loop = '';
                            }

                            $idx ++;
                        endwhile;
                        if($attr['queryUnique']) {
                            $post_loop .= "<span style='display: none;' class='ultp-current-unique-posts' data-ultp-unique-ids= ".wp_json_encode($unique_ID)." data-current-unique-posts= ".wp_json_encode($current_unique_posts)."> </span>";
                        }
                        $bigloop = '<div class="ultp-big-post-module1">'.$bigloop.'</div>';
                        $post_loop = $bigloop.'<div class="ultp-small-post-module1">'.$post_loop.'</div>';

                    $wraper_after .= '</div>';//ultp-block-items-wrap
                    
                    // Navigation
                    if ($attr['paginationShow'] && ($attr['paginationType'] == 'navigation') && ($attr['navPosition'] != 'topRight')) {
                        include ULTP_PATH.'blocks/template/navigation-after.php';
                    }

                $wraper_after .= '</div>';
            $wraper_after .= '</div>';

            wp_reset_query();
        }else {
            $wraper_before .= ultimate_post()->get_no_result_found_html( $attr['notFoundMessage'] );
        }

        return $noAjax ? $post_loop : $wraper_before.$post_loop.$wraper_after;
    }

}