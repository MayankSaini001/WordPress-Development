<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'saini' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'p7xW+{%D|Wq@f.k&VwG4vv9VT8loBKRDFk-Gqq.BNYpirp_}^3Jw~>3cQ.K7iB;K' );
define( 'SECURE_AUTH_KEY',  'm)(?Lz1;x (bM/*O$bZ=o}Pkp wl/;6U}iwcbTBx`y1;<xGSf` O3uB|R])fjP(m' );
define( 'LOGGED_IN_KEY',    'nH}(-ko^}A2wZm-dC{b*S(Za2q@G-Gv,{wSjRi[ym<j6&;Z.Q;u2vO(TN8sZ3#bf' );
define( 'NONCE_KEY',        'k<iT=a|9mY1B6[;iXKw;tPU|2z+/N/I@$-%H1h>9%i[d^^7#*brxl|@BDAeTvo<r' );
define( 'AUTH_SALT',        'z1p;KY?&z&#?0P7Nh@ljl%b{9#Dx=,!xL4TWWKnfBrKc(i>CpvBy0g^vp{ .U4Mw' );
define( 'SECURE_AUTH_SALT', '$z=PW}{As>nj>vbQX/W,1c0;e0`~`{K^@t.ow)SQolkRd^-8rP/9xdG?)9xn+ESw' );
define( 'LOGGED_IN_SALT',   '(yUh$U6D?m)A3/WuJW@DU-b3FHR=qWcJUIEi_~@hZ|H&_>x%J~-LZ:b+6jXwA}gQ' );
define( 'NONCE_SALT',       '>?a&BSrx-8:_c;X~D4iIyOARBNGOp4`wHqX it&C7pr+m=woCk?U_6.<_kv_a5~F' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
