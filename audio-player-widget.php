<?php
/**
 * Plugin Name: Audio Player Widget
 * Plugin URI:  https://github.com/ninefootone/audio-player-widget
 * Description: Registers a custom Elementor widget that renders a Plyr audio player. Supports direct URL input or an ACF attachment field.
 * Version:     1.0.1
 * Author:      ninefootone creative
 * Author URI:  https://www.ninefootone.co.uk
 * Text Domain: audio-player-widget
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */

defined( 'ABSPATH' ) || exit;

define( 'APW_VERSION', '1.0.1' );
define( 'APW_PLYR_VERSION', '3.7.8' );
define( 'APW_FILE', __FILE__ );
define( 'APW_DIR', plugin_dir_path( __FILE__ ) );
define( 'APW_URL', plugin_dir_url( __FILE__ ) );

// Plugin Update Checker v5.5 (vendored — do not upgrade without testing)
// https://github.com/YahnisElsts/plugin-update-checker
require_once APW_DIR . 'lib/plugin-update-checker/plugin-update-checker.php';
$apw_update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
    'https://github.com/ninefootone/audio-player-widget',
    __FILE__,
    'audio-player-widget'
);
$apw_update_checker->getVcsApi()->enableReleaseAssets();

/**
 * Bail early with an admin notice if Elementor isn't active.
 */
function apw_check_elementor(): void {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', function () {
            echo '<div class="notice notice-warning"><p>'
                . esc_html__( 'Audio Player Widget requires Elementor to be installed and activated.', 'audio-player-widget' )
                . '</p></div>';
        } );
    }
}
add_action( 'plugins_loaded', 'apw_check_elementor' );

/**
 * Register the widget with Elementor.
 */
function apw_register_widget( \Elementor\Widgets_Manager $manager ): void {
    require_once APW_DIR . 'includes/class-audio-player-widget.php';
    $manager->register( new \AudioPlayerWidget\Audio_Player_Widget() );
}
add_action( 'elementor/widgets/register', 'apw_register_widget' );

/**
 * Register Plyr assets. Only enqueued on demand by the widget.
 */
function apw_register_assets(): void {
    wp_register_style(
        'plyr-css',
        'https://cdn.plyr.io/' . APW_PLYR_VERSION . '/plyr.css',
        [],
        APW_PLYR_VERSION
    );

    wp_register_script(
        'plyr-js',
        'https://cdn.plyr.io/' . APW_PLYR_VERSION . '/plyr.polyfilled.js',
        [],
        APW_PLYR_VERSION,
        true
    );

    wp_register_script(
        'apw-init',
        APW_URL . 'assets/js/init.js',
        [ 'plyr-js' ],
        APW_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'apw_register_assets' );
