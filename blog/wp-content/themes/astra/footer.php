<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<?php astra_content_bottom(); ?>
	</div> <!-- ast-container -->
	</div><!-- #content -->
<?php 
	astra_content_after();
		
	astra_footer_before();
		
	astra_footer();
		
	astra_footer_after(); 
?>
	</div><!-- #page -->
<?php 
	astra_body_bottom();    
	wp_footer(); 
?>
<script>
	function getViewportSize() {
    let width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    let height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    return {
        width: width,
        height: height
    };
}

function addStickyHeaderOnScroll(selector) {
    let header = document.querySelector(selector);
    window.onscroll = () => {
        if (window.scrollY > 10) {
            // Add the sticky class to the header
            header.classList.add('sticky-header');
        } else {
            // Remove the sticky class if the page is scrolled back to the top
            header.classList.remove('sticky-header');
        }
    };
}

// Check viewport size and add sticky header functionality accordingly
function setupStickyHeader() {
    let viewport = getViewportSize();
    if (viewport.width <= 768) {
        addStickyHeaderOnScroll("#ast-mobile-header");
    } else {
        addStickyHeaderOnScroll(".site-primary-header-wrap");
    }
}

// Call the function to set up the sticky header
setupStickyHeader();

</script>
	</body>
</html>
