<?php
namespace ULTP\blocks;

defined('ABSPATH') || exit;

class Post_List_1{

    public function __construct() {
        add_action('init', array($this, 'register'));
    }

    public function get_attributes() {

        return array(
            'blockId' =>  '',
            'previewImg' =>  '',
            
            /*============================
                General Setting
            ============================*/
            'layout' =>  'layout1',
            'gridStyle' =>  'style1',
            'columns' =>  (object)['lg' =>'2', 'xs' => '2'],
            'titleShow' =>  true,
            'titleStyle' =>  'none',
            'headingShow' =>  true,
            'excerptShow' =>  true,
            'catShow' =>  true,
            'metaShow' =>  true,
            'showImage' =>  true,
            'filterShow' =>  false,
            'paginationShow' =>  true,
            'readMore' =>  true,
            'contentTag' =>  'div',
            'openInTab' =>  false,
            'notFoundMessage' =>  'No Post Found',

            /*============================
                Query Setting
            ============================*/
            'queryQuick' =>  '',
            'queryNumPosts' =>  (object)['lg'=>6],
            'queryNumber' =>  6,
            'queryType' =>  'post',
            'queryTax' =>  'category',
            'queryTaxValue' =>  '[]',
            'queryRelation' =>  'OR',
            'queryOrderBy' =>  'date',
            'metaKey' =>  'custom_meta_key',
            'queryOrder' =>  'desc',
            // Include Remove from Version 2.5.4
            'queryInclude' =>  '',
            'queryExclude' =>  '[]',
            'queryAuthor' =>  '[]',
            'queryOffset' =>  '0',
            'queryExcludeTerm' =>  '[]',
            'queryExcludeAuthor' =>  '[]',
            'querySticky' =>  true,
            'queryUnique' =>  '',
            'queryPosts' =>  '[]',
            'queryCustomPosts' =>  '[]',

            /*============================
                Heading Style
            ============================*/
            'headingText' =>  'Post List #1',
            'headingURL' =>  '',
            'headingBtnText' =>   'View More',
            'headingStyle' =>  'style9',
            'headingTag' =>  'h2',
            'headingAlign' =>   'left',
            'subHeadingShow' =>  false,
            'subHeadingText' =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut sem augue. Sed at felis ut enim dignissim sodales.',
            
            /*============================
                Title Style
            ============================*/
            'titleTag' =>  'h3',
            'titlePosition' =>  true,
            'titleLength' =>  0,

            /*============================
                Meta Style
            ============================*/
            'metaPosition' =>  'top',
            'metaStyle' =>  'icon',
            'metaSeparator' =>  '',
            'authorLink' =>  true,
            'metaList' =>  '["metaAuthor","metaDate","metaRead"]',
            'metaMinText' =>  'min read',
            'metaAuthorPrefix' =>  'By',
            'metaDateFormat' =>  'M j, Y',
            
            /*============================
                Category Style
            ============================*/
            'maxTaxonomy'=>  '30',
            'taxonomy' =>  'category',
            'catStyle' =>  'classic',
            'catPosition' =>  'aboveTitle',
            'customCatColor' =>  false,
            'seperatorLink' =>  admin_url( 'edit-tags.php?taxonomy=category' ),
            'onlyCatColor' =>  false,
            
            /*============================
                Image Style
            ============================*/
            'imgCrop' =>  'full',
            'imgCropSmall' =>  (ultimate_post()->get_setting('disable_image_size') == 'yes' ? 'full' : 'ultp_layout_square'),
            'imgAnimation' =>  'none',
            'imgOverlay' =>  false,
            'imgOverlayType' =>  'default',
            'fallbackEnable' =>  true,
            'fallbackImg' =>  '',
            'imgSrcset' =>  false,
            'imgLazy' =>  false,

            /*============================
                Video Style
            ============================*/
            'vidIconEnable' =>  true,
            'popupAutoPlay' =>  true,
            'iconSize' =>  (object)['lg'=>'70', 'sm'=> '50', 'xs'=> '50', 'unit' => 'px'],
            // by default should be off
            'enablePopup' =>  false,
            'enablePopupTitle' =>  true,
            
            /*============================
                Filter Style
            ============================*/
            'filterBelowTitle' =>  false,
            'filterType' =>  'category',
            'filterText' =>  'all',
            'filterValue' =>  '[]',
            'filterMobile' =>   true,
            'filterMobileText' =>  'More',
            
            /*============================
                Pagination Style
            ============================*/
            'paginationType' =>  'pagination',
            'loadMoreText' =>  'Load More',
            'paginationText' =>  'Previous|Next',
            'paginationNav' =>  'textArrow',
            'paginationAjax' =>  true,
            'navPosition' =>  'topRight',
            
            /*============================
                Excerpt Style
            ============================*/
            'showSeoMeta' => false,
            'showFullExcerpt' =>  false,
            'fullExcerptLg' =>  false,
            'excerptLimit' =>  25,
            'excerptLimitLg' =>  '70',
            'excerptLimitLg' =>  '70',

            /*============================
                Read More Style
            ============================*/
            'readMoreText' =>  '',
            'readMoreIcon' =>  '',
            
            /*============================
                Separator Style
            ============================*/
            'separatorShow' =>  false,
            
            /*============================
                Advance Wrapper Style
            ============================*/
            'advanceId' =>  '',
            'advanceZindex' =>  '',
            'hideExtraLarge' =>  false,
            'hideTablet' =>  false,
            'hideMobile' =>  false,
            'advanceCss' =>  '',
            'currentPostId' =>  '',
        );
    }

    public function register() {
        register_block_type( 'ultimate-post/post-list-1',
            array(
                'editor_script' => 'ultp-blocks-editor-script',
                'editor_style'  => 'ultp-blocks-editor-css',
                'render_callback' =>  array($this, 'content')
            )
        );
    }

    public function content($attr, $noAjax) {
        $attr = wp_parse_args($attr, $this->get_attributes());
        $attr['queryUnique'] = isset( $attr['queryUnique']) ? $attr['queryUnique']:'';
        global $unique_ID;
        
        if (!$noAjax) {
            $paged = is_front_page() ? get_query_var('page') : get_query_var('paged');
            $attr['paged'] = $paged ? $paged : 1;
        }
        if($attr['queryUnique'] && isset($attr['savedQueryUnique'])) {
            $unique_ID = $attr['savedQueryUnique'];
        }
        $block_name = 'post-list-1';
        $wraper_before = $wraper_after = $post_loop = '';
        $attr['queryNumber'] = ultimate_post()->get_post_number(6, $attr['queryNumber'], $attr['queryNumPosts']);
        $recent_posts = new \WP_Query( ultimate_post()->get_query( $attr ) );
        $pageNum = ultimate_post()->get_page_number($attr, $recent_posts->found_posts);
        // Dummy Img Url
        $dummy_url = ULTP_URL.'assets/img/ultp-fallback-img.png';
        // Current Post Id For Pagination
        $curr_post_id = '';
        if(is_single()){
            $curr_post_id = get_the_ID();
        }
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
             
                    $wraper_before .= '<div class="ultp-block-items-wrap ultp-block-row ultp-block-column-'.json_decode(wp_json_encode($attr['columns']), True)['lg'].' ultp-pl1a-'.$attr['gridStyle'].' ultp-post-list1-'.$attr['layout'].'">';
                        $idx = ($attr['paginationShow'] && ($attr['paginationType'] == 'loadMore')) ? ( $noAjax ? 1 : 0 ) : 0;
                        $index = 0;
                        while ( $recent_posts->have_posts() ): $recent_posts->the_post();
                            include ULTP_PATH.'blocks/template/data.php';

                            include ULTP_PATH.'blocks/template/category.php';

                            if ($attr['queryUnique']) {
                                $unique_ID[$attr['queryUnique']][] = $post_id;
                                $current_unique_posts[] = $post_id;
                            }

                            $post_loop .= '<'.$attr['contentTag'].' class="ultp-block-item post-id-'.$post_id.'">';
                                $post_loop .= '<div class="ultp-block-content-wrap">';
                                    $post_loop .= '<div class="ultp-block-entry-content">';
                                    if(($attr['gridStyle'] == 'style3' && $idx == 0) && (($post_thumb_id || $attr['fallbackEnable']) && $attr['showImage'])) {
                                        $post_loop .= '<div class="ultp-block-image ultp-block-image-'.$attr['imgAnimation'].($attr["imgOverlay"] ? ' ultp-block-image-overlay ultp-block-image-'.$attr["imgOverlayType"].' ultp-block-image-'.$attr["imgOverlayType"].$idx : '' ).'">';
                                            $post_loop .= '<a href="'.$titlelink.'" '.($attr['openInTab'] ? 'target="_blank"' : '').'>';
                                            // Post Image Id
                                            $block_img_id = $post_thumb_id ? $post_thumb_id : ($attr['fallbackEnable'] && isset($attr['fallbackImg']['id']) ? $attr['fallbackImg']['id'] : '');
                                            // Post Image 
                                            if($post_thumb_id || ($attr['fallbackEnable'] && $block_img_id)) {
                                                $post_loop .=  ultimate_post()->get_image($block_img_id, $attr['imgCrop'], '', $title, $attr['imgSrcset'], $attr['imgLazy']);
                                            } else {
                                                $video = ultimate_post()->get_youtube_id($post_video);
                                                $post_loop .= '<img  src="'.($video ? 'https://img.youtube.com/vi/'.$video.'/0.jpg' : $dummy_url).'" alt="dummy-img" />';
                                            }
                                            $post_loop .= '</a>';
                                            if (($attr['catPosition'] != 'aboveTitle') && $attr['catShow'] ) {
                                                $post_loop .= '<div class="ultp-category-img-grid">'.$category.'</div>';
                                            }
                                        $post_loop .= '</div>';
                                    }

                                    $post_loop .= '<div class="ultp-block-entry-heading">';
                                        // Category
                                        if (($attr['catPosition'] == 'aboveTitle') && $attr['catShow']) {
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
                                    $post_loop .= '</div>'; 

                                    if(($attr['gridStyle'] != 'style3' || $attr['gridStyle'] == 'style3' && $idx != 0 )  && (($post_thumb_id || $attr['fallbackEnable']) && $attr['showImage'])) {
                                        $post_loop .= '<div class="ultp-block-image ultp-block-image-'.$attr['imgAnimation'].($attr["imgOverlay"] ? ' ultp-block-image-overlay ultp-block-image-'.$attr["imgOverlayType"].' ultp-block-image-'.$attr["imgOverlayType"].$idx : '' ).'">';
                                            $post_loop .= '<a href="'.$titlelink.'" '.($attr['openInTab'] ? 'target="_blank"' : '').'>';
                                            // Post Image Size
                                            $imgSize = $attr['gridStyle'] != 'style1' ? $idx == 0 ?  $attr['imgCrop'] : $attr['imgCropSmall'] : $attr['imgCrop'];
                                            // Post Image Id
                                            $block_img_id = $post_thumb_id ? $post_thumb_id : ($attr['fallbackEnable'] && isset($attr['fallbackImg']['id']) ? $attr['fallbackImg']['id'] : '');
                                            // Post Image 
                                            if($post_thumb_id || ($attr['fallbackEnable'] && $block_img_id)) {
                                                    $post_loop .= ultimate_post()->get_image($block_img_id, $imgSize, '', $title, $attr['imgSrcset'], $attr['imgLazy']);
                                            } else {
                                                $video = ultimate_post()->get_youtube_id($post_video);
                                                    $post_loop .= '<img  src="'.($video ? 'https://img.youtube.com/vi/'.$video.'/0.jpg' : $dummy_url).'" alt="dummy-img" />';
                                            }
                                            $post_loop .= '</a>';
                                            if($post_video){
                                                $post_loop .= '<div enableAutoPlay="'.$attr['popupAutoPlay'].'" class="ultp-video-icon">'.ultimate_post()->svg_icon('play_line').'</div>';
                                            }
                                            if(($attr['catPosition'] != 'aboveTitle') && $attr['catShow'] ) {
                                                $post_loop .= '<div class="ultp-category-img-grid">'.$category.'</div>';
                                            }
                                        $post_loop .= '</div>';
                                    }

                                    $post_loop .= '</div>';
                                    $post_loop .= '<div class="ultp-block-content">';
                                        // Excerpt
                                        if ($attr['excerptShow']) {
                                            $excerptLim = $index == 0 && $attr['gridStyle'] !=  'style1' ? $attr['excerptLimitLg'] : $attr['excerptLimit'];
                                            $showFullexcerpt = $index == 0 && $attr['gridStyle'] !=  'style1' ? $attr['fullExcerptLg'] : $attr['showFullExcerpt'];
                                            $post_loop .= '<div class="ultp-block-excerpt">'.ultimate_post()->get_excerpt($post_id, $attr['showSeoMeta'], $showFullexcerpt, $excerptLim).'</div>';
                                        }

                                        // Read More
                                        if ($attr['readMore']) {
                                            $post_loop .= '<div class="ultp-block-readmore"><a aria-label="'.$title.'" href="'.$titlelink.'" '.($attr['openInTab'] ? 'target="_blank"' : '').'>'.($attr['readMoreText'] ? $attr['readMoreText'] : esc_html__( "Read More", "ultimate-post" )).ultimate_post()->svg_icon($attr['readMoreIcon']).'</a></div>';
                                        }
                                        // Meta
                                        if ($attr['metaPosition'] =='bottom' ) {
                                            include ULTP_PATH.'blocks/template/meta.php';
                                        }
                                    $post_loop .= '</div>';
                                $post_loop .= '</div>';
                                if($post_video && $attr['enablePopup']) {
                                    include ULTP_PATH.'blocks/template/video_popup.php';
                                }
                            $post_loop .= '</'.$attr['contentTag'].'>'; 
                            $idx ++;
                            $index++;
                        endwhile;
                        if($attr['queryUnique']) {
                            $post_loop .= "<span style='display: none;' class='ultp-current-unique-posts' data-ultp-unique-ids= ".wp_json_encode($unique_ID)." data-current-unique-posts= ".wp_json_encode($current_unique_posts)."> </span>";
                        }
                        if ($attr['paginationShow'] && ($attr['paginationType'] == 'loadMore')) {
                            $wraper_after .= '<span class="ultp-loadmore-insert-before"></span>';
                        }
                    $wraper_after .= '</div>';//ultp-block-items-wrap
                    
                    // Load More
                    if ($attr['paginationShow'] && ($attr['paginationType'] == 'loadMore')) {
                        include ULTP_PATH.'blocks/template/loadmore.php';
                    }

                    // Navigation
                    if ($attr['paginationShow'] && ($attr['paginationType'] == 'navigation') && ($attr['navPosition'] != 'topRight')) {
                        include ULTP_PATH.'blocks/template/navigation-after.php';
                    }

                    // Pagination
                    if ($attr['paginationShow'] && ($attr['paginationType'] == 'pagination')) {
                        include ULTP_PATH.'blocks/template/pagination.php';
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