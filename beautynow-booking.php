<?php 
	/*
	Plugin Name: BeautyNow Booking
	Description: Plugin for searching and booking beauty appointments
	Version:     1.0.1
	Author:      BeautyNow
	Author URI:  http://beautynowapp.com
    License:     GPLv3
	License URI: http://www.gnu.org/licenses/gpl.html
    */
	
	function iframe_unqprfx_embed_shortcode( $atts ) {
		$location_id = $atts["location_id"];
		$max_openings = isset($atts["max_openings"]) ? $atts["max_openings"] : 4;
	
		$defaults = array(
			'src' => 'http://widget.beautynowapp.com/location/' . $location_id,
			'width' => '100%',
			'height' => '500',
			'scrolling' => 'yes',
			'class' => 'iframe-class',
			'frameborder' => '0'
		);

		foreach ( $defaults as $default => $value ) { // add defaults
			if ( ! @array_key_exists( $default, $atts ) ) { // mute warning with "@" when no params at all
				$atts[$default] = $value;
			}
		}

		$html = "\n".'<!-- iframe plugin v.4.2 wordpress.org/plugins/iframe/ -->'."\n";
		$html .= '<iframe';
		foreach( $atts as $attr => $value ) {
			if ( strtolower($attr) != 'same_height_as' AND strtolower($attr) != 'onload'
				AND strtolower($attr) != 'onpageshow' AND strtolower($attr) != 'onclick') { // remove some attributes
				if ( $value != '' ) { // adding all attributes
					$html .= ' ' . esc_attr( $attr ) . '="' . esc_attr( $value ) . '"';
				} else { // adding empty attributes
					$html .= ' ' . esc_attr( $attr );
				}
			}
		}
		$html .= '></iframe>'."\n";

		if ( isset( $atts["same_height_as"] ) ) {
			$html .= '
				<script>
				document.addEventListener("DOMContentLoaded", function(){
					var target_element, iframe_element;
					iframe_element = document.querySelector("iframe.' . esc_attr( $atts["class"] ) . '");
					target_element = document.querySelector("' . esc_attr( $atts["same_height_as"] ) . '");
					iframe_element.style.height = target_element.offsetHeight + "px";
				});
				</script>
			';
		}

		return $html;
	}
	add_shortcode( 'booknow', 'iframe_unqprfx_embed_shortcode' );


	function iframe_unqprfx_plugin_meta( $links, $file ) { // add 'Plugin page' and 'Donate' links to plugin meta row
		if ( strpos( $file, 'iframe/iframe.php' ) !== false ) {
			$links = array_merge( $links, array( '<a href="http://web-profile.com.ua/wordpress/plugins/iframe/" title="Plugin page">Iframe</a>' ) );
			$links = array_merge( $links, array( '<a href="http://web-profile.com.ua/donate/" title="Support the development">Donate</a>' ) );
			$links = array_merge( $links, array( '<a href="http://codecanyon.net/item/advanced-iframe-pro/5344999?ref=webvitaly">Advanced iFrame Pro</a>' ) );
		}
		return $links;
	}
	add_filter( 'plugin_row_meta', 'iframe_unqprfx_plugin_meta', 10, 2 );
?>