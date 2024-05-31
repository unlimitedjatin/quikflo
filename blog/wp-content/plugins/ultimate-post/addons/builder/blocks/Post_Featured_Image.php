<?php
namespace ULTP\blocks;

defined('ABSPATH') || exit;

class Post_Featured_Image {
    public function __construct() {
        add_action('init', array($this, 'register'));
    }
    public function get_attributes() {
        
        return array(
            'blockId' => '',
            /*============================
                Post Featured Image Setting
            ============================*/
            'altText'  => 'Image',
            'imgScale' => 'cover',
            'imgAlign' => (object)['lg' =>'left'],
            
            /*============================
                Dynamic Caption 
            ============================*/
            'enableCaption' => false,
            
            /*============================
                Video Settings
            ============================*/
            'enableVideoCaption' => false,
            'videoWidth' => (object)['lg' =>'100'],
            'stickyEnable' => false,

            /*============================
                Advanced Settings
            ============================*/
            'advanceId' => '',
            'advanceZindex' => '',
            'hideExtraLarge' => false,
            'hideDesktop' => false,
            'hideTablet' => false,
            'hideMobile' => false,
            'advanceCss' => '',
        );
    }

    public function register() {
        register_block_type( 'ultimate-post/post-featured-image',
            array(
                'editor_script' => 'ultp-blocks-editor-script',
                'editor_style'  => 'ultp-blocks-editor-css',
                'render_callback' => array($this, 'content')
            )
        );
    }

    public function content($attr, $noAjax) {
        $attr = wp_parse_args($attr, $this->get_attributes());
        $block_name = 'post-image';
        $wrapper_before = $wrapper_after = $content = '';

        $post_video = get_post_meta(get_the_ID(), '__builder_feature_video', true);
        $caption = get_post_meta(get_the_ID(), '__builder_feature_caption', true); 

        $embeded = $post_video ? ultimate_post()->get_embeded_video($post_video, false, true, false, true, true, false, true, array('width' => array('width' => $attr["videoWidth"])) ) : '';
        $post_thumb_id = get_post_thumbnail_id(get_the_ID());
        $img_content = ultimate_post()->get_image($post_thumb_id, '', '', $attr['altText']);
        $img_caption = wp_get_attachment_caption($post_thumb_id);

        if ($embeded || has_post_thumbnail()) {
            $wrapper_before .= '<div '.($attr['advanceId']?'id="'.$attr['advanceId'].'" ':'').' class="wp-block-ultimate-post-'.$block_name.' ultp-block-'.$attr["blockId"].(isset($attr["className"])?' '.$attr["className"]:'').''.(isset($attr["align"])? ' align' .$attr["align"]:'').'">';
                $wrapper_before .= '<div class="ultp-block-wrapper">';
                    $wrapper_before .= '<div class="ultp-image-wrapper">';
                        $wrapper_before .= '<div  class="ultp-builder-'.($embeded ? "video": "image").'">';
                            $content .= '<div class="ultp-'.($embeded ? "video": "image").'-block'.($attr['stickyEnable'] ? " ultp-sticky-video": "").'">';
                            $content .= $embeded ? $embeded : $img_content;
                        $wrapper_after .= '<span class="ultp-sticky-close"></span></div>';
                        $wrapper_after .= '</div>';
                    $wrapper_after .= '</div>';

                    if($attr['enableCaption'] && $img_caption || $caption && $attr['enableVideoCaption']){
                        $wrapper_after .= '<div class="ultp-featureImg-caption">';
                        $wrapper_after .= $embeded ? $caption : $img_caption;
                        $wrapper_after .= '</div>';
                    }
                $wrapper_after .= '</div>';
            $wrapper_after .= '</div>';
        }
        return $wrapper_before.$content.$wrapper_after;
    }
}