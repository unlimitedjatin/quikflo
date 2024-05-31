<?php
namespace ULTP\blocks;

defined('ABSPATH') || exit;

class Post_Reading_Time {
    public function __construct() {
        add_action('init', array($this, 'register'));
    }
    public function get_attributes() {
        
        return array(
            'blockId' => '',
            
            /*============================
                Post Reading Meta Settings
            ============================*/
            'readLabel' => true,
            'readIconShow' => true,
            'readLabelText' => 'Reading Time',

            /*============================
                Post Reading Icon Settings
            ============================*/
            'readIconStyle' => 'readingTime1',
            
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
        register_block_type( 'ultimate-post/post-reading-time',
            array(
                'editor_script' => 'ultp-blocks-editor-script',
                'editor_style'  => 'ultp-blocks-editor-css',
                'render_callback' => array($this, 'content')
            )
        );
    }

    public function content($attr, $noAjax) {
        $attr = wp_parse_args($attr, $this->get_attributes());
        $block_name = 'post-reading-time';
        $wrapper_before = $wrapper_after = $content = '';

        $wrapper_before .= '<div '.($attr['advanceId']?'id="'.$attr['advanceId'].'" ':'').' class="wp-block-ultimate-post-'.$block_name.' ultp-block-'.$attr["blockId"].(isset($attr["className"])?' '.$attr["className"]:'').''.(isset($attr["align"])? ' align' .$attr["align"]:'').'">';
            $wrapper_before .= '<div class="ultp-block-wrapper">';
                $content .= '<span class="ultp-read-count">';
                    if ($attr["readIconShow"] && ($attr["readIconStyle"] != '')) {
                        $content .= ultimate_post()->svg_icon($attr["readIconStyle"]); 
                    }
                    $content .= '<div>';
                        $content .= ceil(mb_strlen(wp_strip_all_tags(get_the_content( null,  false, get_the_ID() )))/1200);
                    $content .= '</div>';
                    if ($attr["readLabel"]) {
                        $content .= '<span class="ultp-read-label">'.$attr["readLabelText"].'</span>';
                    }
                $content .= '</span>';
            $wrapper_after .= '</div>';
        $wrapper_after .= '</div>';
        
        return $wrapper_before.$content.$wrapper_after;
    }
}