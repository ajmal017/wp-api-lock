<?php

/*
Plugin Name: WP API Lock
Plugin URI: https://github.com/japalekhin/wp-api-lock
Description: Disable WordPress front-end functionality. Just serve Admin Dashboard and REST API.
Version: 1.0.0
Author: Japa Alekhin Llemos <jap@alekhin.io>
Author URI: https://jap.alekhin.io
License: GPLv3 or later
Text Domain: akismet
 */

if (!function_exists('is_rest')) {
    /**
     * Checks if the current request is a WP REST API request.
     *
     * Case #1: After WP_REST_Request initialisation
     * Case #2: Support "plain" permalink settings
     * Case #3: URL Path begins with wp-json/ (your REST prefix)
     *          Also supports WP installations in subfolders
     *
     * https://wordpress.stackexchange.com/a/317041
     *
     * @author matzeeable
     * @return boolean
     */
    function is_rest()
    {
        $prefix = rest_get_url_prefix();
        if (defined('REST_REQUEST') && REST_REQUEST// (#1)
             || isset($_GET['rest_route']) // (#2)
             && strpos(trim($_GET['rest_route'], '\\/'), $prefix, 0) === 0) {
            return true;
        }

        // (#3)
        $rest_url = wp_parse_url(site_url($prefix));
        $current_url = wp_parse_url(add_query_arg(array()));
        return strpos($current_url['path'], $rest_url['path'], 0) === 0;
    }
}

add_action('init', function () {
    if (!(is_admin() || is_rest())) {
        wp_redirect(admin_url());
        exit;
    }
});
