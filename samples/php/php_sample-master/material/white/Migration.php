<?php if ( ! defined( 'ABSPATH' ) ) exit;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

abstract class NF_Abstracts_Migration
{
    public $table_name = '';

    public $charset_collate = '';

    public $flag = '';

    public function __construct( $table_name, $flag )
    {
        $this->table_name =  $table_name;
    }

    public function table_name()
    {
        global $wpdb;
        return $wpdb->prefix . $this->table_name;
    }

    public function charset_collate()
    {
        global $wpdb;
        return $wpdb->get_charset_collate();
    }

    public function _run()
    {
        // Check the flag
        if( get_option( $this->flag, FALSE ) ) return;

        // Run the migration
        $this->run();

        // Set the Flag
        update_option( $this->flag, TRUE );
    }

    protected abstract function run();

    public function _drop()
    {
        global $wpdb;
        if( ! $this->table_name ) return;
        if( 0 == $wpdb->query( $wpdb->prepare( "SHOW TABLES LIKE '%s'", $this->table_name() ) ) ) return;
        $wpdb->query( $wpdb->prepare( "DROP TABLE %s", $this->table_name() ) );
        return $this->drop();
    }

    protected function drop()
    {
        // This section intentionally left blank.
    }
}
