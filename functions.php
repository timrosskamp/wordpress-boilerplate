<?php

/* -------------------------------------------------------------------------- *\
    # COMPOSER
\* -------------------------------------------------------------------------- */

require_once get_template_directory() . '/vendor/autoload.php';

$timber = new Timber\Timber();




/* -------------------------------------------------------------------------- *\
    # THEME APPLICATION CLASS
\* -------------------------------------------------------------------------- */

class ThemeApplication {

    static function isDebug(): bool {
        return defined('WP_DEBUG') && WP_DEBUG == true;
    }

}




/* -------------------------------------------------------------------------- *\
    # THEME SUPPORT
\* -------------------------------------------------------------------------- */

add_action('after_setup_theme', function() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	// Custom background color.
	add_theme_support('custom-background', [
        'default-color' => 'f5efe0',
    ]);

	// Set content-width.
	global $content_width;
	if( !isset($content_width) ){
		$content_width = 580;
	}

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ]);

	// Add support for full and wide align images.
	add_theme_support('align-wide');

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	add_filter('script_loader_tag', function($tag, $handle){
        foreach(['async', 'defer'] as $attr){
            if( !wp_scripts()->get_data($handle, $attr) ){
                continue;
            }
            // Prevent adding attribute when already added.
            if( !preg_match(":\s$attr(=|>|\s):", $tag) ){
                $tag = preg_replace(':(?=></script>):', " $attr", $tag, 1);
            }
            // Only allow async or defer, not both.
            break;
        }
        return $tag;
    }, 10, 2);

});




/* -------------------------------------------------------------------------- *\
    # STYLES AND SCRIPTS ENQUEUEMENT
\* -------------------------------------------------------------------------- */

add_action('wp_enqueue_scripts', function(){

    $cssFile = ThemeApplication::isDebug() ? '/dist/style.css' : '/dist/style.min.css';
    $jsFile = ThemeApplication::isDebug() ? '/dist/script.js' : '/dist/script.min.js';

    wp_enqueue_style('theme-style', get_template_directory_uri() . $cssFile, [], @filemtime(get_template_directory() . $cssFile));

    wp_enqueue_script('theme-script', get_template_directory_uri() . $jsFile, [], @filemtime(get_template_directory() . $jsFile), true);
    wp_script_add_data('theme-script', 'async', true);

});




/* -------------------------------------------------------------------------- *\
    # MENUS
\* -------------------------------------------------------------------------- */

add_action('init', function(){

    register_nav_menus([
        'main' => 'Hauptmenü',
        'footer' => 'Menü in der Fußzeile',
    ]);

});

add_filter('timber/context', function($context){

    $context['menus'] = [
        'main' => new \Timber\Menu('main')
    ];

    return $context;
});




/* -------------------------------------------------------------------------- *\
    # BLOCKS
\* -------------------------------------------------------------------------- */

add_action('enqueue_block_editor_assets', function(){

    wp_enqueue_script('theme-blocks', get_template_directory_uri() . '/dist/blocks.js', ['wp-blocks', 'wp-element'], @filemtime(get_template_directory() . 'dist/blocks.js'));

});