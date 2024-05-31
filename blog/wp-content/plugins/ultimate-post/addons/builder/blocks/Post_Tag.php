<?php
namespace ULTP\blocks;

defined('ABSPATH') || exit;

class Post_Tag {
    public function __construct() {
        add_action('init', array($this, 'register'));
    }
    public function get_attributes() {

        return array(
            'blockId' => '',

            /*============================
                Post Tag Settings
            ============================*/
            'tagLabelShow' => true,
            'tagIconShow' => true,
            'tagAlign' => (object)[],

            /*============================
                Tag Label Settings
            ============================*/
            'tagLabel' => 'Tags: ',
            /*============================
                Tag Icon Settings
            ============================*/
            'tagIconStyle' => '',

            //--------------------------
            //  Advanced Settings
            //--------------------------
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
        register_block_type( 'ultimate-post/post-tag',
            array(
                'editor_script' => 'ultp-blocks-editor-script',
                'editor_style'  => 'ultp-blocks-editor-css',
                'render_callback' => array($this, 'content')
            )
        );
    }
    public function content($attr, $noAjax) {
        $attr = wp_parse_args($attr, $this->get_attributes());
        $block_name = 'post-tag';
        $wrapper_before = $wrapper_after = $content = '';

        $tag_list = get_the_tag_list('','');

        if ($tag_list) {
            $wrapper_before .= '<div '.($attr['advanceId']?'id="'.$attr['advanceId'].'" ':'').' class="wp-block-ultimate-post-'.$block_name.' ultp-block-'.$attr["blockId"].(isset($attr["className"])?' '.$attr["className"]:'').''.(isset($attr["align"])? ' align' .$attr["align"]:'').'">';
                $wrapper_before .= '<div class="ultp-block-wrapper">';
                    $content .= '<div class="ultp-builder-tag">';
                        if($attr["tagIconShow"]){
                            $content .= ultimate_post()->svg_icon(''.$attr["tagIconStyle"].'');
                        }
                        if ($attr['tagLabelShow']) {
                            $content .= '<div class="tag-builder-label">';
                                $content .= $attr['tagLabel'];
                            $content .= '</div>';
                        }
                        $content .= '<div class="tag-builder-content">';
                            $content .= $tag_list;
                        $content .= '</div>';
                    $content .= '</div>';
                $wrapper_after .= '</div>';
            $wrapper_after .= '</div>';
        }

        return $wrapper_before.$content.$wrapper_after;
    }
}