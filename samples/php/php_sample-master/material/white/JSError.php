<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_JSError
{
    public function __construct()
    {
        add_action( 'wp_ajax_nf_log_js_error',   array( $this, 'log_error' ) );
        add_action( 'wp_ajax_nopriv_nf_log_js_error',   array( $this, 'log_error' ) );
    }

    public function log_error()
    {
        check_ajax_referer( 'ninja_forms_display_nonce', 'security' );
        $message = esc_html( stripslashes( $_REQUEST[ 'message' ] ) );
        $url = esc_html( stripslashes( $_REQUEST[ 'url' ] ) );
        $lineNumber = esc_html( stripslashes( $_REQUEST[ 'lineNumber' ] ) );

        Ninja_Forms()->logger()->emergency( $message . ' in ' . $url . ' on line ' . $lineNumber );
 
        die( 1 );
    }
}