<?php
namespace ULTP\blocks;

defined('ABSPATH') || exit;

class Next_Previous {
    public function __construct() {
        add_action('init', array($this, 'register'));
    }
    public function get_attributes() {

        return array(
            'blockId' => '',

            /*============================
                Next Preview Settings
            ============================*/
            'layout' => 'style1',
            'headingEnable' => true,
            'imageShow' => true,
            'titleShow' => true,
            'dateShow' => true,
            'navDivider' => false,
            'iconShow' => true,

            /*============================
                Navigation 
            ============================*/
            'titlePosition' => true,
            'prevContentAlign' => "left",
            'nextContentAlign' => "right",
            // Previous
            'prevHeadText' => 'Previous Post',
            // Next
            'nextHeadText' => 'Next Post',

             /*============================
                Divider Setting/Style
            ============================*/
            'dividerBorderShape' => true,

            /*============================
                Arrow Icon
            ============================*/
            'arrowIconStyle' => 'Angle2',
            
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
        register_block_type( 'ultimate-post/next-previous',
            array(
                'editor_script' => 'ultp-blocks-editor-script',
                'editor_style'  => 'ultp-blocks-editor-css',
                'render_callback' => array($this, 'content')
            )
        );
    }
    public function content($attr, $noAjax) {
        $attr = wp_parse_args($attr, $this->get_attributes());

        $block_name = 'next-previous';
        $wrapper_before = $wrapper_after = $content = $next_prev_img = '';

        if($attr["imageShow"]){
            $next_prev_img .= "next-prev-img";
        }

        $arrowLeft = '<span class="ultp-icon ultp-icon-'.$attr['arrowIconStyle'].'">'.ultimate_post()->svg_icon('left'.$attr['arrowIconStyle']).'</span>';
        $arrowRight = '<span class="ultp-icon ultp-icon-'.$attr['arrowIconStyle'].'">'.ultimate_post()->svg_icon('right'.$attr['arrowIconStyle']).'</span>';

        $wrapper_before .= '<div '.($attr['advanceId']?'id="'.$attr['advanceId'].'" ':'').' class="wp-block-ultimate-post-'.$block_name.' ultp-block-'.$attr["blockId"].(isset($attr["className"])?' '.$attr["className"]:'').''.(isset($attr["align"])? ' align' .$attr["align"]:'').'">';
            $wrapper_before .= '<div class="ultp-block-wrapper">';
                $content .= '<div class="ultp-block-nav '.$next_prev_img.'">';
                    $content .= $this->renderHtml($attr, $arrowLeft, $arrowRight, true);
                    if ($attr['navDivider'] && $attr['dividerBorderShape']) {
                        $content .= '<span class="ultp-divider"></span>';
                    }
                    $content .= $this->renderHtml($attr, $arrowLeft, $arrowRight, false);
                $content .= '</div>';
            $wrapper_after .= '</div>';
        $wrapper_after .= '</div>';

        return $wrapper_before.$content.$wrapper_after;
    }

    public function renderHtml($attr, $arrowLeft, $arrowRight, $left) {
        $output = '';
        $post_data = $left ? get_previous_post() : get_next_post();
        if ($post_data) {
            $imageData = '<div class="ultp-nav-img">';
                $imageData .= ($attr['iconShow'] && $attr['layout'] == 'style2') ? ($left ? $arrowLeft : $arrowRight) : '';
                if (has_post_thumbnail($post_data->ID)) {
                    $imageData .= $attr['imageShow'] ? get_the_post_thumbnail($post_data->ID) : '';
                }
            $imageData .= '</div>';
            $output .= '<a class="'.($left ? 'ultp-nav-block-prev ultp-nav-prev-'.$attr['layout'] : 'ultp-nav-block-next ultp-nav-next-'.$attr['layout']).'" href="'.get_permalink($post_data->ID).'">';
                if ($attr['headingEnable'] && !$attr['titlePosition'] && ( $attr['layout'] == 'style2' )) { 
                    $output .= '<div class='.($left ? "ultp-prev-title" : "ultp-next-title").' >'.($left ? $attr['prevHeadText'] : $attr['nextHeadText']).'</div>';
                }
                if ($left && $attr['iconShow'] && $attr['layout'] != 'style2') {
                    $output .= $arrowLeft;
                }
                $output .= '<div class="ultp-nav-inside">';
                    if ($attr['headingEnable'] && !$attr['titlePosition'] && $attr['layout'] != 'style2') {
                        $output .= '<div class='.($left ? "ultp-prev-title" : "ultp-next-title").' >'.($left ? $attr['prevHeadText'] : $attr['nextHeadText']).'</div>';
                    }
                    $output .= '<div class="ultp-nav-inside-container">';
                        if ($left) {
                            $output .= $imageData;
                        }
                        if ($left == false && $attr['layout'] == 'style3' ) {
                            $output .= $imageData;
                        }
                        $output .= '<div class="ultp-nav-text-content">';
                            if ($attr['headingEnable'] && $attr['titlePosition']) {
                                $output .= '<div class='.($left ? "ultp-prev-title" : "ultp-next-title").' >'.($left ? $attr['prevHeadText'] : $attr['nextHeadText']).'</div>';
                            }
                            if ($attr['dateShow']) {
                                $output .= '<div class="ultp-nav-date">'.get_the_date(get_option('date_format'), $post_data->ID).'</div>';
                            }
                            if ($attr['titleShow']) {
                                $output .= '<div class="ultp-nav-title">'.get_the_title($post_data->ID).'</div>';
                            }
                        $output .= '</div>';
                        if ($left == false && $attr['layout'] != 'style3' ) {
                            $output .= '<span>'.$imageData.'</span>';
                        }
                    $output .= '</div>';
                $output .= '</div>';
                if ($left == false && $attr['iconShow'] && $attr['layout'] != 'style2') {
                    $output .= $arrowRight;
                }
            $output .= '</a>';
        }
        return $output;
    }
}