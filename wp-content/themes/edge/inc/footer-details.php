<?php
/**
 * @package Theme Freesia
 * @subpackage Edge
 * @since Edge 1.0
 */
?>
<?php
/************************* EDGE FOOTER DETAILS **************************************/

function edge_site_footer() {
if ( is_active_sidebar( 'edge_footer_options' ) ) :
		dynamic_sidebar( 'edge_footer_options' );
	else:
		echo '<div class="copyright">' .'&copy; ' . date('Y') .' '; ?>
		<a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" target="_blank" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo( 'name', 'display' ); ?></a> | 
						<?php esc_html_e('Designed by:','edge'); ?> <a title="<?php echo esc_attr__( 'TinKV', 'tin' ); ?>" target="_blank" href="<?php echo esc_url( '#' ); ?>"><?php esc_html_e('TinKV', 'tin');?></a> 
					</div>
	<?php endif;
}
add_action( 'edge_sitegenerator_footer', 'edge_site_footer');
?>