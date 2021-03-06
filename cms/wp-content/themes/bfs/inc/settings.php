<?php

require_once __DIR__ . '/hooks.php';

/*
 *
 * This script sets up a global-level settings page.
 *
 */

/*
 *
 * ----- Custom ACF Gutenberg blocks
 *
 */
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_register_block_type' ) )
		return;

	// Investments block
	acf_register_block_type( [
		'name' => 'bfs-investments',
		'title' => __( 'Investments' ),
		'description' => __( 'Investments' ),
		'category' => 'wealth-holdings',
		'icon' => 'money-alt',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// FAQs block
	acf_register_block_type( [
		'name' => 'bfs-faqs',
		'title' => __( 'FAQs' ),
		'description' => __( 'FAQs' ),
		'category' => 'wealth-holdings',
		'icon' => 'editor-textcolor',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Brochures block
	acf_register_block_type( [
		'name' => 'bfs-brochures',
		'title' => __( 'Brochures' ),
		'description' => __( 'Brochures' ),
		'category' => 'wealth-holdings',
		'icon' => 'media-document',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Testimonials block
	acf_register_block_type( [
		'name' => 'bfs-testimonials',
		'title' => __( 'Testimonials' ),
		'description' => __( 'Testimonials' ),
		'category' => 'wealth-holdings',
		'icon' => 'testimonial',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Tile Link block
	acf_register_block_type( [
		'name' => 'bfs-tile-link',
		'title' => __( 'Tile Link' ),
		'description' => __( 'A tile that can link to a post, attachment or trigger playback of a video.' ),
		'category' => 'wealth-holdings',
		'icon' => 'testimonial',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Form block
	acf_register_block_type( [
		'name' => 'bfs-form',
		'title' => __( 'Form' ),
		'description' => __( 'Form' ),
		'category' => 'wealth-holdings',
		'icon' => 'feedback',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_template' => get_template_directory() . '/inc/blocks/form.php'
	] );

	function acf_render_callback ( $block, $content, $is_preview, $post_id ) {
		if ( ! class_exists( '\BFS\CMS' ) )
			return;

		\BFS\CMS::$currentQueriedPostACF = array_merge( \BFS\CMS::$currentQueriedPostACF, get_fields() ?: [ ] );
	}

} );



/*
 *
 * Prevent auto-"correction" of URLs
 * 	Based on `https://core.trac.wordpress.org/ticket/16557`
 *
 */
add_filter( 'redirect_canonical', function ( $redirectUrl ) {
	if ( is_404() && ! isset( $_GET[ 'p' ] ) )
		return false;
	else
		return $redirectUrl;
} );



function bfs_theme_setup () {

	/*
	 * Theme Supports
	 *
	 * Register support for certain features
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
	 */
	// Enable support for Post Thumbnails on posts and pages.
	// @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	add_theme_support( 'editor-style' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'dark-editor-style' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );



	/*
	 *
	 * Media Settings
	 *
	 */
	add_image_size( 'small', 400, 400, false );



	/*
	 *
	 * Templates for the various Post Types
	 *
	 */
	add_filter( 'register_post_type_args', function ( $args, $postType ) {

		if ( $postType === 'investment' ) {
			$args[ 'template' ] = [
				[ 'acf/bfs-investments' ]
			];
			$args[ 'template_lock' ] = 'all';
		}
		else if ( $postType === 'faq' ) {
			$args[ 'template' ] = [
				[ 'core/paragraph', [ 'placeholder' => 'Type in a detailed answer here...' ] ],
				[ 'acf/bfs-faqs' ]
			];
			// $args[ 'template_lock' ] = 'all';
		}
		else if ( $postType === 'brochure' ) {
			$args[ 'template' ] = [
				[ 'acf/bfs-brochures' ]
			];
			$args[ 'template_lock' ] = 'all';
		}
		else if ( $postType === 'tile-link' ) {
			$args[ 'template' ] = [
				[ 'acf/bfs-tile-link' ]
			];
			$args[ 'template_lock' ] = 'all';
		}
		else if ( $postType === 'testimonial' ) {
			$args[ 'template' ] = [
				[ 'acf/bfs-testimonials' ]
			];
			$args[ 'template_lock' ] = 'all';
		}

		return $args;

	}, 20, 2 );



	/*
	 *
	 * Show the Meta-data page if ACF is enabled
	 *
	 */
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( [
			'page_title' => 'Metadata',
			'menu_title' => 'Metadata',
			'menu_slug' => 'metadata',
			'capability' => 'edit_posts',
			'parent_slug' => '',
			'position' => '5',
			'icon_url' => 'dashicons-info'
		] );
	}

}

add_action( 'after_setup_theme', 'bfs_theme_setup' );



add_action( 'bfs/backend/on-editing-posts', function ( $postType ) {

	// Add a custom block category
	add_filter( 'block_categories', function ( $categories ) {
		return array_merge( $categories, [
			[
				'slug' => 'wealth-holdings',
				'title' => __( 'Wealth Holdings', 'bfs' ),
				'icon' => 'money'
			]
		] );
	} );

	// Only allow access to certain types of blocks
	wp_enqueue_script(
		'bfs-block-access',
		get_template_directory_uri() . '/js/block-access.js',
		[ 'wp-data', 'wp-edit-post' ],
		filemtime( get_template_directory() . '/js/block-access.js' )
	);

} );


/*
 *
 * ----- Tile Links
 *	Capture certain ACF values and store them as native post (or post meta) attributes, or tags.
 *	This is to optimize the post querying.
 *
 */
function tileLink__SavePostHook ( $postId, $post, $postWasUpdated ) {

	if ( get_post_type( $postId ) !== 'tile-link' )
		return;

	require_once __DIR__ . '/../../../../../inc/cms.php';

	// Unregister the save_post action hook to prevent an infinite loop
	remove_action( 'save_post_tile-link', 'tileLink__SavePostHook', 100, 3 );

	$thePost = \BFS\CMS::getPostById( $postId );

	/*
	 * Capture the "title" value as the post title
	 */
	// Strip away all the HTML and newline characters
	$title = strip_tags( str_replace( "\r\n", ' ', $thePost->get( 'tile_title' ) ) );
	wp_update_post( [ 'ID' => $postId, 'post_title' => $title ], false, false );


	/*
	 * Capture the "Feature in" value as a tag
	 */
	$tags = array_map( function ( $tag ) {
		return 'for-' . $tag;
	}, $thePost->get( 'feature_on' ) );

	$allExistingPostTags = wp_get_post_tags( $postId, [ 'fields' => 'slugs' ] );
	$allOtherTags = array_filter( $allExistingPostTags, function ( $tag ) {
		return substr( $tag, 0, 4 ) != 'for-';
	} );

	$tagsToSet = array_merge( $allOtherTags, $tags );

	wp_set_post_tags( $postId, $tagsToSet, false );

	// Re-register the action hook
	add_action( 'save_post_tile-link', 'tileLink__SavePostHook', 100, 3 );

}
// Register a `save_post` action hook for the Tile Link post
add_action( 'save_post_tile-link', 'tileLink__SavePostHook', 100, 3 );
