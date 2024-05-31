<?php
namespace ULTP\blocks;

defined('ABSPATH') || exit;

class Post_Category {
    public function __construct() {
        add_action('init', array($this, 'register'));
    }
    public function get_attributes() {

        return array(
            'blockId' => '',

            /*============================
                Post Category Setting
            ============================*/
            'catLabelShow' => true,
            'catIconShow' => true,
            'catSeparator' => ',',
            'catAlign' => (object)[],

            /*============================
                Categories Label Settings
            ============================*/
            'catLabel' => 'Category : ',
            
            /*============================
                Categories Icon Style
            ============================*/
            'catIconStyle' => '',

            /*============================
                Advance Setting
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
        register_block_type( 'ultimate-post/post-category',
            array(
                'editor_script' => 'ultp-blocks-editor-script',
                'editor_style' => 'ultp-blocks-editor-css',
                'render_callback' => array($this, 'content')
            )
        );
    }

    public function content($attr, $noAjax) {
        $attr = wp_parse_args($attr, $this->get_attributes());
        $block_name = 'post-category';
        $wrapper_before = $wrapper_after = $content = '';

        $categories = get_the_category();
        if (!empty($categories)) {
            $wrapper_before .= '<div '.($attr['advanceId']?'id="'.$attr['advanceId'].'" ':'').' class="wp-block-ultimate-post-'.$block_name.' ultp-block-'.$attr["blockId"].(isset($attr["className"])?' '.$attr["className"]:'').''.(isset($attr["align"])? ' align' .$attr["align"]:'').'">';
                $wrapper_before .= '<div class="ultp-block-wrapper">';
                    $content .= '<div class="ultp-builder-category">';
                        if($attr["catIconShow"]){
                            $content .= ultimate_post()->svg_icon(''.$attr["catIconStyle"].'');
                        }
                        if ($attr['catLabelShow'] ) { 
                            $content .= '<div class="cat-builder-label">'.$attr['catLabel'].'</div>';
                        }
                        $content .= '<div class="cat-builder-content">';
                            foreach ($categories as $key => $category) {
                                $content .= ( ($key > 0 && $attr['catSeparator']) ? ' '.$attr['catSeparator']:'').'<a class="ultp-category-list" href="'.get_term_link($category->term_id).'">'.$category->name.'</a>';
                            }
                        $content .= '</div>';
                    $content .= '</div>';
                $wrapper_after .= '</div>';
            $wrapper_after .= '</div>';
        }

        return $wrapper_before.$content.$wrapper_after;
    }
}