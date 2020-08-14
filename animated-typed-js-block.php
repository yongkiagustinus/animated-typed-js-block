<?php
/**
 * Plugin Name:     Animated Typed JS Block
 * Description:     Create an animated typing effect text easily
 * Version:         0.1.0
 * Author:          The WordPress Contributors
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     animated-typed-js-block
 *
 * @package         animated-typed-js-block
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function animated_typed_js_block_animated_typed_js_block_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "animated-typed-js-block/animated-typed-js-block" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'animated-typed-js-block-animated-typed-js-block-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);

	$editor_css = 'build/index.css';
	wp_register_style(
		'animated-typed-js-block-animated-typed-js-block-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'animated-typed-js-block-animated-typed-js-block-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'animated-typed-js-block/animated-typed-js-block', array(
		'editor_script' => 'animated-typed-js-block-animated-typed-js-block-block-editor',
		'editor_style'  => 'animated-typed-js-block-animated-typed-js-block-block-editor',
		'style'         => 'animated-typed-js-block-animated-typed-js-block-block',
	) );
}
add_action( 'init', 'animated_typed_js_block_animated_typed_js_block_block_init' );
