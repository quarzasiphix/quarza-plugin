<?php
/**
 * Plugin Name: quarza
 * Description: quarza test plugin
 * Author: quarza
 * Version 1.0.0
 * 
*/


if(!defined('ABSPATH')) {
    exit;
}

class quarza {
    public function __construct() {
        add_action('init', array($this, 'create_custom_post_type'));

        // add assets(js, css)
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));

        add_shortcode('shortcode-test', array($this, 'load_shortcode'));

        //load js 
        add_action('wp_footer', array($this, 'load_scripts'));
    
        add_action('rest_api_init', array($this, 'register_rest_api'));
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

    public function load_shortcode() {?>  

        <style>
            h1 {
                text: center;
            } 

            .quarza-form {
                left: 50%
            }

        </style>
        <h!> test </h1>
        <div class="quarza-form"> 
        <form id="quarza-form-form">
            <input type="email" placeholder="email">
            <button class="btn btn-success btn-block"> Send message </button>
        </form>
        </div>
    <?php }  


    public function load_scripts() {?>
       <script>
        //var nonce = '<?php echo wp_create_nonce('wp_rest'); ?>'
        <script>
        (function($){ 
            $('#quarza-form-form').submit( function(event) {
                event.preventDefault(); // Prevent default form submission

                var form = $(this).serialize();
                console.log(form);

                $.ajax({
                    method:'post',
                    url: '<?php echo esc_url_raw(rest_url('quarza/send-email')); ?>',
                    headers: { 'X-WP-Nonce': '<?php echo wp_create_nonce( 'wp_rest' ); ?>' },
                    data: form, // Send form data in the request

                })
                .done(function(response) {
                    // Handle success response
                    console.log(response);
                })
                .fail(function(xhr, status, error) {
                    // Handle failure response
                    console.log(xhr.responseText);
                });
            });
        })(jQuery);
    </script>
    <?php }

    public function register_rest_api() {
        register_rest_route( 'quarza/', 'send-email', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_contact_form')
        ));
    }

    public function handle_contact_form( WP_REST_Request $request ) {
        // Retrieve request data
        $parameters = $request->get_params();
        $headers = $request->get_headers();
        $nonce = $headers['x_wp_nonce'][0];

        if(wp_verify_nonce($nonce, 'wp_rest')) {
            echo 'This nonce is correct';
        }
        
        // Now you can use $parameters and $headers as needed
    
        // Example usage:
        $email = $parameters['email'];
        // Process the received data
    
        // Return a response (example)
        return rest_ensure_response( 'Data received successfully' );
    }
    
}

new quarza();