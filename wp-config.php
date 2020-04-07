<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'b31_25220147_wp74' );

/** MySQL database username */
define( 'DB_USER', '25220147_1' );

/** MySQL database password */
define( 'DB_PASSWORD', '87SGy)p7j-' );

/** MySQL hostname */
define( 'DB_HOST', 'sql206.byetcluster.com' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'pd0mzrmxo7rt5guv9wquz0yvjkbiaaba96glhw4krfc0otrd9permcjforbuyxrn' );
define( 'SECURE_AUTH_KEY',  'xydv7am3rze6wxyqbwvqlrlxsllrmuqruibavormbj5f8v4tptuwqaoocs1diasi' );
define( 'LOGGED_IN_KEY',    'lgsczntjjjzjssqyg8cylrf3yofsezer2ck5jmzmpctf0x3liubmdpucftvvhr6h' );
define( 'NONCE_KEY',        'hm8jamypqobkidf27b6nybdppzelgjplrdnulytpfphusuopiyali1kigklrzbpt' );
define( 'AUTH_SALT',        'mw3eehwbgfih4updlnudpkk46ynqbld2osx3qowwtbrpmchaa7gqiixxi38jqcha' );
define( 'SECURE_AUTH_SALT', 'tlvcxuxh0ztnxlqinrtck6iipjboy5scsw9ggalunlttbnoz8gqturvimylkt8wz' );
define( 'LOGGED_IN_SALT',   'p0xp9txzaos6hhdhuqosivir3lk4ifwbb4dcq5ttv9xdzgftftolomnvyolloqua' );
define( 'NONCE_SALT',       'iiccvre6atdst6g4m07ag0n8krazc6zc7epj0jasz7i3emdeobt7q19zcl8qtdy6' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpfv_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
