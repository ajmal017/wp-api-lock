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

add_action('template_redirect', function () {
    wp_redirect(admin_url());
    exit;
});
