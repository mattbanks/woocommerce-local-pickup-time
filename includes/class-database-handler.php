<?php
/**
 * Local Pickup Time
 *
 * @package   Local_Pickup_Time_Database_Handler
 * @author    Tim Nolte <tim.nolte@ndigitals.com>
 * @license   GPL-2.0+
 * @link      https://www.ndigitals.com
 * @copyright 2014-2020 Local Pickup Time
 */

/**
 * Local_Pickup_Time_Database_Handler class
 * Defines database functionality
 *
 * @package Local_Pickup_Time_Database_Handler
 * @author  Tim Nolte <tim.nolte@ndigitals.com>
 */
class Local_Pickup_Time_Database_Handler {

	/**
	 * Instance of this class.
	 *
	 * @since    1.4.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * The table name suffix.
	 *
	 * The suffix to use along with the WordPress configured table prefix when
	 * referencing a table.
	 *
	 * @since     1.4.0
	 *
	 * @var       string
	 */
	protected $table_name;

	/**
	 * The WordPress database object.
	 *
	 * @since    1.4.0
	 *
	 * @var      wpdb
	 */
	protected $database;

	/**
	 * The database collation.
	 *
	 * @since
	 *
	 * @var      string
	 */
	protected $collation;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.4.0
	 *
	 * @param wpdb   $database           The database object.
	 * @param string $table_name         The table name that is represented.
	 * @param bool   $suppress_errors    Should the errors be suppressed.
	 */
	private function __construct( $database, $table_name, $suppress_errors = true ) {

		$this->database        = $database;
		$this->table_prefix    = $this->get_table_prefix();
		$this->suppress_errors = (bool) $suppress_errors;

		if ( $database->has_cap( 'collation' ) ) {
			$this->collation = $database->get_charset_collate();
		}

		// Remove the table prefix if it it was included.
		$this->table_name = str_replace( $this->table_prefix, '', $table_name );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.4.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Return the table name with table prefix..
	 *
	 * @since     1.4.0
	 *
	 * @return    string   The table name including table prefix.
	 */
	public function get_table_name() {

		return $this->get_table_prefix() . $this->table_name;

	}

	/**
	 * Returns the WordPress table prefix.
	 *
	 * @since     1.4.0
	 *
	 * @return    string The WordPress table prefix.
	 */
	protected function get_table_prefix() {

		return $this->database->get_blog_prefix();

	}

	/**
	 * Returns the character set collation.
	 *
	 * @since    1.4.0
	 *
	 * @return   string   The dataase collation.
	 */
	public function get_collation() {

		return $this->collation;

	}

}
