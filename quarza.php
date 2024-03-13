<?php
/**
 * Plugin Name: quarza
 * Description: quarza test plugin
 * Author: quarzat
 * Version 1.0.0
 * 
 */

 if(  !defined('ABSPATH')) {
    exit;
 }

 class quarza {
    public function __construct() {
        add_action('init', array($this, 'create_custom_post_type'));
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
                'name' => 'contact form'
                'singular_name' => 'Contact Form entrty'
            ),
            'menu_icon' => 'dashicons-media-text',
        );

        register_post_type('simple_contact_form', $args);
    }
 }

