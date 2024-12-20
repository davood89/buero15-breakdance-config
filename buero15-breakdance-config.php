<?php
/**
 * Plugin Name: BÜRO15 Breakdance Config
 * Plugin URI: https://github.com/davood89/buero15-breakdance-config
 * Description: BÜRO15 Breakdance Konfiguration und ACF Styles
 * Version: 1.0.3
 * Author: BÜRO15
 * Author URI: https://buero15.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: buero15-breakdance-config
 * GitHub Plugin URI: davood89/buero15-breakdance-config
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Plugin version
define('B15_BREAKDANCE_CONFIG_VERSION', '1.0.3');

/**
 * Enqueue admin styles
 */
function b15_load_admin_styles() {
    wp_enqueue_style(
        'b15-acf-styles',
        plugin_dir_url(__FILE__) . 'assets/css/b15-acf.css',
        array(),
        B15_BREAKDANCE_CONFIG_VERSION
    );
}
add_action('admin_enqueue_scripts', 'b15_load_admin_styles');


add_action('breakdance_reusable_dependencies_urls', function ($urls) {
    $urls['gsap'] = plugin_dir_url(__FILE__) . 'assets/js/gsap.min.js';
    $urls['scrollTrigger'] = plugin_dir_url(__FILE__) . 'assets/js/ScrollTrigger.min.js';
    
    return $urls;
});



/**
 * Plugin update checker setup
 */
function b15_init_update_checker() {
    if (file_exists(__DIR__ . '/plugin-update-checker/plugin-update-checker.php')) {
        require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';
        
        if (class_exists('YahnisElsts\PluginUpdateChecker\v5\PucFactory')) {
            $myUpdateChecker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
                'https://github.com/davood89/buero15-breakdance-config/',
                __FILE__,
                'buero15-breakdance-config'
            );
            
            // Release Assets aktivieren
            $myUpdateChecker->getVcsApi()->enableReleaseAssets();
            
            // Branch auf 'main' setzen
            $myUpdateChecker->setBranch('main');
            
            // GitHub Token entfernen, wenn das Repository öffentlich ist
            // $myUpdateChecker->setAuthentication('your-github-personal-access-token');
        }
    }
}
add_action('init', 'b15_init_update_checker');