<?php
/**
 * Plugin Name: quarza
 * Description: quarza test plugin
 * Author: quarza
 * Version 1.0.0
 * 
 */

 if(  !defined('ABSPATH')) {
    exit;
 }

class quarza {
    public function __construct() {
        add_action('init', array($this, 'create_custom_post_type'));

        // add assets(js, css)
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));

        add_shortcode('shortcode-test', array($this, 'load_shortcode'));
    }

    public function create_custom_post_type() {
        // i couldnt get tis to work
        //echo '<script>alert("Welcome to Geeks for Geeks")</script>'; 

        $args = array(
            'public' => true,
            'has_archive' => true,
            'supports' => array('title'),
            'exclude_from_search' => true,
            'publicly_queryable' => false, 
            'capability' => 'manage_options',
            'labels' => array(
                'name' => 'quarza section',
                'singular_name' => 'quarza shieeett'
            ),
            'menu_icon' => 'dashicons-welcome-view-site',
        );

        register_post_type('simple_contact_form', $args);
    }

    public function load_assets() {
        wp_enqueue_style(
            'quarza',
            plugin_dir_url( __FILE__ ) . '/css/quarza.css',
            array(),
            1,
            'all'
        );

        // adds js script to top
        wp_enqueue_script(
            'quarza',
            plugin_dir_url( __FILE__ ) . '/js/quarza.js',
            array('jquery'),
            1,
            true
        );


    }

    public function load_shortcode() 
    {?>
    <h!> test </h1>

    <div class="quarza-form"> 
    <form id="quarza-form-form">
        <input type="email" placeholder="email">

        <button class="btn btn-success btn-block"> Send message </button>
    </form>
    </div>

    <?php //return 'shortcode works';
    }
}

new quarza();