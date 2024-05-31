<?php
namespace ULTP\blocks;
defined('ABSPATH') || exit;
class Post_Grid_5{
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
            'contentTag' =>  'div',
            'openInTab' =>  false,
            'columnFlip' =>  false,
            'notFoundMessage' =>  'No Post Found',

            /*============================
                Query Setting
            ============================*/
            'queryQuick' =>  '',
            'queryNumber' =>  4,
            'queryType' =>  'post',
            'queryTax' =>  'category',
            'queryTaxValue' =>  '[]',
            'queryRelation' =>  'OR',
            'queryOrderBy' =>  'date',
            'metaKey' =>  'custom_meta_key',
            'queryOrder' =>  'desc',
            // Include Remove from Version 2.5.4
            'queryInclude' =>  '',
            'queryExclude' =>  '',
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
            'headingShow' =>  true,
            'headingText' =>  'Post Grid #5',
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
            'titleShow' =>  true,
            'titleTag' =>  'h3',
            'titlePosition' =>  true,
            'titleLength' =>  0,
            'titleStyle' =>  'none',
            /*============================
                Meta Style
            ============================*/
            'metaShow' =>  true,
            'showSmallMeta' =>  true,
            'metaPosition' =>  'top',
            'metaStyle' =>  'icon',
            'authorLink' =>  true,
            'metaSeparator' =>  'emptyspace',
            'metaList' =>  '["metaAuthor","metaDate"]',
            'metaMinText' =>  'min read',
            'metaAuthorPrefix' =>  'By',
            'metaDateFormat' =>  'M j, Y',
            'metaListSmall' =>  '["metaDate"]',
            
            /*============================
                Category Style
            ============================*/
            'maxTaxonomy'=>  '30',
            'catShow' =>  true,
            'taxonomy' =>  'category',
            'showSmallCat' =>  false,
            'catStyle' =>  'classic',
            'catPosition' =>  'aboveTitle',
            'customCatColor' =>  false,
            'seperatorLink' =>  admin_url( 'edit-tags.php?taxonomy=category' ),
            'onlyCatColor' =>  false,
            
            /*============================
                Image Style
            ============================*/
            'showImage' =>  true,
            'imgCrop' =>  (ultimate_post()->get_setting('disable_image_size') == 'yes' ? 'full' : 'ultp_layout_landscape'),
            'imgCropSmall' =>  (ultimate_post()->get_setting('disable_image_size') == 'yes' ? 'full' : 'ultp_layout_square'),
            'imgAnimation' =>  'zoomIn',
            'imgOverlay' =>  true,
            'imgOverlayType' =>  'simgleGradient',
            'fallbackEnable' =>  true,
            'fallbackImg' =>  '',
            'imgSrcset' =>  false,
            'imgLazy' =>  false,
            /*============================
                Video Style
            ============================*/
            'vidIconEnable' =>  true,
            'popupAutoPlay' =>  true,
            'iconSize' =>  (object)['lg'=>'40', 'sm'=> '30', 'xs'=> '30', 'unit' => 'px'],
            // by default should be off
            'enablePopup' =>  false,
            'enablePopupTitle' =>  true,
            
            /*============================
                Content Style
            ============================*/
            /* == Content Animation */
            'titleAnimation' =>  '',
            'overlayContentPosition' =>  'bottomPosition',
            
            /*============================
                Filter Style
            ============================*/
            'filterShow' =>  false,
            'filterBelowTitle' =>  false,
            'filterType' =>  'category',
            'filterText' =>  'all',
            'filterValue' =>  '[]',
            'filterMobile' =>   true,
            'filterMobileText' =>  'More',

            /*============================
                Pagination Style
            ============================*/
            'paginationShow' =>  false,
            'paginationType' =>  'navigation',
            'paginationNav' =>  'textArrow',
            'navPosition' =>  'topRight',
            
            /*============================
                Excerpt Style
            ============================*/
            'excerptShow' =>  false,
            'showSeoMeta' => false,
            'showSmallExcerpt' =>  false,
            'showFullExcerpt' =>  false,
            'excerptLimit' =>  20,
            
            /*============================
                Readmore Style
            ============================*/
            'readMore' =>  false,
            'showSmallBtn' =>  false,
            'readMoreText' =>  '',
            'readMoreIcon' =>  'rightArrowLg',
            
            /*============================
                Wrapper Style
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
        register_block_type( 'ultimate-post/post-grid-5',
            array(
                'editor_script' => 'ultp-blocks-editor-script',
                'editor_style'  => 'ultp-blocks-editor-css',
                'render_callback' =>  array($this, 'content')
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
        
        $block_name = 'post-grid-5';
        $wraper_before = $wraper_after = $post_loop = '';
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
            $wraper_before .= '<div '.($attr['advanceId']?'id="'.$attr['advanceId'].'" ':'').' class="wp-block-ultimate-post-'.$block_name.' ultp-block-'.$attr["blockId"].''.(isset($attr["align"])? ' align' .$attr["align"]:'').''.(isset($attr["className"])? ' ' .$attr["className"]:'').'">';
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
                    $wraper_before .= '<div class="ultp-block-items-wrap ultp-block-row ultp-'.$attr['layout'].' ultp-block-content-'.($attr['columnFlip'] ? 'true' : 'false').'">';
                        $idx = 0;
                        while ( $recent_posts->have_posts() ): $recent_posts->the_post();
                            
                            include ULTP_PATH.'blocks/template/data.php';

                            include ULTP_PATH.'blocks/template/category.php';

                            if ($attr['queryUnique']) {
                                $unique_ID[$attr['queryUnique']][] = $post_id;
                                $current_unique_posts[] = $post_id;
                            }
                            
                            $post_loop .= '<'.$attr['contentTag'].' class="ultp-block-item post-id-'.$post_id.($attr['titleAnimation'] ? ' ultp-animation-'.$attr['titleAnimation'] : '').'">';
                                $post_loop .= '<div class="ultp-block-content-wrap ultp-block-content-overlay">';

                                    if(($post_thumb_id || $attr['fallbackEnable']) && $attr['showImage']) {
                                        $post_loop .= '<div class="ultp-block-image ultp-block-image-'.$attr['imgAnimation'].($attr["imgOverlay"] ? ' ultp-block-image-overlay ultp-block-image-'.$attr["imgOverlayType"] : '' ).'">';
                                            $srcset = $attr['imgSrcset'] ? 'srcset="'.esc_attr(wp_get_attachment_image_srcset($post_thumb_id)).'"' : '';
                                            $post_loop .= '<a href="'.$titlelink.'" '.($attr['openInTab'] ? 'target="_blank"' : '').'>';
                                            // Post Image Size
                                            $imgSize = $idx == 0 ? $attr['imgCrop'] : $attr['imgCropSmall'];
                                            // Image
                                            if($post_thumb_id && $post_thumb_id) {
                                                $post_loop .= '<img '.($attr['imgLazy'] ? ' loading="lazy"' : '').' '.$srcset.' alt="'.esc_attr($title).'" src="'.wp_get_attachment_image_url( $post_thumb_id, $imgSize ).'" />';
                                            } elseif($attr['fallbackEnable']) {
                                                if(isset($attr['fallbackImg']['id'])){
                                                    // User Define Fallback Image
                                                    $post_loop .= ultimate_post()->get_image($attr['fallbackImg']['id'], $imgSize, '', $title, $attr['imgSrcset'], $attr['imgLazy']);
                                                } else {
                                                    // Default Fallback Image
                                                    $video = ultimate_post()->get_youtube_id($post_video);
                                                    $post_loop .= '<img  src="'.($video ? 'https://img.youtube.com/vi/'.$video.'/0.jpg' : $dummy_url).'" alt="dummy-img" />';
                                                }
                                            }
                                            $post_loop .= '</a>';
                                            if($post_video){
                                                $post_loop .= '<div enableAutoPlay="'.$attr['popupAutoPlay'].'" class="ultp-video-icon">'.ultimate_post()->svg_icon('play_line').'</div>';
                                            }
                                            if (($attr['catPosition'] != 'aboveTitle') && ($idx == 0 || $attr['showSmallCat'] || $attr['layout'] == 'layout3' && $idx == 3) && $attr['catShow'] ) {
                                                $post_loop .= '<div class="ultp-category-img-grid">'.$category.'</div>';
                                            }
                                        $post_loop .= '</div>';
                                    } else {
                                        if($post_video){
                                            $post_loop .= '<div enableAutoPlay="'.$attr['popupAutoPlay'].'" class="ultp-video-icon">'.ultimate_post()->svg_icon('play_line').'</div>';
                                        }
                                        $post_loop .= '<div class="ultp-block-image ultp-block-empty-image"></div>';
                                    }
                                    $post_loop .= '<div class="ultp-block-content ultp-block-content-'.$attr['overlayContentPosition'].'">';
                                        $post_loop .= '<div class="ultp-block-content-inner">';
                                            // Category
                                            if (($attr['catPosition'] == 'aboveTitle') && ($idx == 0 || $attr['showSmallCat'] || ($attr['layout'] == 'layout3' && $idx == 3)) && $attr['catShow']) {
                                                $post_loop .= $category;
                                            }

                                            // Title
                                            if ($title && $attr['titleShow'] && $attr['titlePosition'] == 1) {
                                                include ULTP_PATH.'blocks/template/title.php';
                                            }
                                            
                                            // Meta
                                            if (($idx == 0 || $attr['showSmallMeta'] || ($attr['layout'] == 'layout3' && $idx == 3)) && $attr['metaShow'] && $attr['metaPosition'] =='top' ) {
                                                include ULTP_PATH.'blocks/template/meta.php';
                                            }
                                            
                                            // Title
                                            if ($title  && $attr['titleShow'] && $attr['titlePosition'] == 0) {
                                                include ULTP_PATH.'blocks/template/title.php';
                                            }

                                            // Excerpt
                                            if (($idx == 0 || $attr['showSmallExcerpt'] || ($attr['layout'] == 'layout3' && $idx == 3)) && $attr['excerptShow']) {
                                                $post_loop .= '<div class="ultp-block-excerpt">'.ultimate_post()->get_excerpt($post_id, $attr['showSeoMeta'], $attr['showFullExcerpt'], $attr['excerptLimit']).'</div>';
                                            }

                                            // Read More
                                            if ($attr['readMore'] && ($idx == 0 || $attr['showSmallBtn'] || $attr['layout'] == 'layout3' && $idx == 3)) {
                                                $post_loop .= '<div class="ultp-block-readmore"><a aria-label="'.$title.'" href="'.$titlelink.'" '.($attr['openInTab'] ? 'target="_blank"' : '').'>'.($attr['readMoreText'] ? $attr['readMoreText'] : esc_html__( "Read More", "ultimate-post" )).ultimate_post()->svg_icon($attr['readMoreIcon']).'</a></div>';
                                            }

                                            // Meta
                                            if (($idx == 0 || $attr['showSmallMeta'] || ($attr['layout'] == 'layout3' && $idx == 3)) && $attr['metaShow'] && $attr['metaPosition'] =='bottom' ) {
                                                include ULTP_PATH.'blocks/template/meta.php';
                                            }
                                        $post_loop .= '</div>';
                                    $post_loop .= '</div>';
                                $post_loop .= '</div>';
                                if($post_video && $attr['enablePopup']) {
                                    include ULTP_PATH.'blocks/template/video_popup.php';
                                }
                            $post_loop .= '</'.$attr['contentTag'].'>';
                            $idx ++;
                        endwhile;
                        if($attr['queryUnique']) {
                            $post_loop .= "<span style='display: none;' class='ultp-current-unique-posts' data-ultp-unique-ids= ".wp_json_encode($unique_ID)." data-current-unique-posts= ".wp_json_encode($current_unique_posts)."> </span>";
                        }
    
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