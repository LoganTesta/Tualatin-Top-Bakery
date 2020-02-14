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
define( 'DB_NAME', 'tualatintopbakery' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'uV7hRQptT1>85$%z,rgztOC%89c s4a|b1/}>W5fCK1cDhan8k[2,j}D:SEZkNpv' );
define( 'SECURE_AUTH_KEY',  'O``T[~gaTc>XY<AvA`xY32cKn_}R>/n3Kw>+SMZr]p+Vq1tCe}s`#mX:n+%/+,:D' );
define( 'LOGGED_IN_KEY',    'sqJ3U$IlUFlMK/2^%#<u#?z:YX0N[_4@ 8;O9;6(29x_Ps`.);jKZ([+uiTZ@`Tx' );
define( 'NONCE_KEY',        'EqNROM[j4r(0$&yW<BU~lP)D2/z<fOYvkw;L.y/0VTAO_NkvA{,dI0ob=R>(qyB4' );
define( 'AUTH_SALT',        'R$^,#wJ2l,_^}O3O0YX5FOO-,+[:k4~6-^nGu*(X* yOuT)xnj[h5TDf-#vQ}!0;' );
define( 'SECURE_AUTH_SALT', '7+1qMgh7KiFZnq[o%pU]MDHVmQff;6RsZth)Fas~b7,BY<WGc9WT7K08r@9DO]5X' );
define( 'LOGGED_IN_SALT',   'x}AZ0*,c5BL>6j16$2_nWV.Z`E1F(kdfm~0Nb@m7!Cva<i5php8~35l$`nR+t,z=' );
define( 'NONCE_SALT',       '-XA *DgN+n5})Vsp8Hzi8Vq&@?iO5vd8I{!|-[Y</zj6))ep+NK=1AI{rU[LSOWC' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
