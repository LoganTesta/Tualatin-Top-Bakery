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
define( 'DB_NAME', 'blog' );

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
define( 'AUTH_KEY',         'l,4cb1ukD<8x::6CW@;[>5GT&TW^P1m(_W|y!h0L?w`B@cogM6A+CXQ%%RM[GH,(' );
define( 'SECURE_AUTH_KEY',  'Jr~PzlLQpvsg^bTEe_g9o]gNq -CI]ox`]uw=-#-p*oIn]L5]Gin4/>]|VIv0G}h' );
define( 'LOGGED_IN_KEY',    'WGfJb*Fv/<N+>FK^o3>]x@?UO%L@(vV=!F4(.z/8[|?OWpWT8y7U{6wZ:jS=L^2K' );
define( 'NONCE_KEY',        'exT41d6(;fZv S,9aM^&@:_.=|E.(m9j&?-C6C-_G=~=N = Q=^Yk#~Y6Ym]7]d>' );
define( 'AUTH_SALT',        'aCF(gsFlnmhxrqAMhtUGs3nv?^N:a]y?`^U8NK3]f~S,cRK%Qwtg7p~.btN!%1u%' );
define( 'SECURE_AUTH_SALT', ';,JX5_6, `4L7Ju$5ECt+:C(1gn ](O+!yc&5Wb|dx=+o`T,WoB~6.15S.nWY#2G' );
define( 'LOGGED_IN_SALT',   't=d,Wfw<$<i(I srlU0&+]n&O>T+U3lPzXhNb@Tile1ssQeK$QIlakxwyz41v&5x' );
define( 'NONCE_SALT',       'v/cH)fEw?L2n0V*#}?dia7WrCh4FFq|*5Yks#~|dJ#9s+J)3LVelEH!G:qH>( J!' );

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
