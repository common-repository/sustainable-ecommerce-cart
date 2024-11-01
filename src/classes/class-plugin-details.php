<?php

namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Plugin_Details extends Singleton {
	/**
	 * @return void
	 */
	public function init() {
		if ( is_admin() ) {
			add_filter( 'plugin_row_meta', array( $this, 'plugin_links' ), 10, 4 );
		}
	}

	/**
	 * Add a "details" link to open a thickbox popup with information about
	 * the plugin from the public directory.
	 *
	 * @since 1.0.0
	 *
	 * @param array $links List of links.
	 * @param string $plugin_file Relative path to the main plugin file from the plugins directory.
	 * @param array $plugin_data Data from the plugin headers.
	 * @return array
	 */
	public function plugin_links( $links, $plugin_file, $plugin_data ) {
		if ( isset( $plugin_data['PluginURI'] ) && false !== strpos( $plugin_data['PluginURI'], 'https://netzerosm.com' ) ) {
			$links = [];

			$version = esc_html__( 'Version', 'rgbc_netzero_sm' );
			$links[] = sprintf( "$version %s", RGBC_NETZERO_SM_VER );

			$by      = esc_html__( 'By', 'rgbc_netzero_sm' );
			$links[] = sprintf(
				'%s <a target="blank" href="%s">netzeroSM</a>',
				$by,
				Constants::SITE_URL
			);

			$links[] = sprintf(
				'<a href="%s" class="thickbox" title="%s">%s</a>',
				self_admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=sustainable-ecommerce-cart&amp;TB_iframe=true&amp;width=600&amp;height=550' ),
				esc_attr( esc_html__( 'More information about', 'rgbc_netzero_sm' ) . ' ' . $plugin_data['Name'] ?? '' ),
				esc_html__( 'View details', 'rgbc_netzero_sm' )
			);

		}

		return $links;
	}
}
