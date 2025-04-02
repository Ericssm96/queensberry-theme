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
define( 'DB_NAME', 'queensberry-db' );

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
define( 'AUTH_KEY',         '$vi5Q!yg<0ai%`|y-T`|i^@+8*qZxG{2rEXZL{r;g[x/u3:j@@Z`!ntU2vGmE->=' );
define( 'SECURE_AUTH_KEY',  '`!8TjFAf?8/J0M?sMK7JMV96;#)Y@eP8H?}K?0eRfv7&)ggO>sSbZOz#_b_p@v+a' );
define( 'LOGGED_IN_KEY',    'W}9wHs#a1sy`rH,lI5`l~{B6sY:;HWLl=vpv 6tC,Ip@.Af:r`5,UP^Jt[N)xVL>' );
define( 'NONCE_KEY',        'VC6*mG7@mN+_C)dH?cn@JAlZ#fjmR05k%YQTbG:i<[}=UmQc{2n1<8G@ o?o( |V' );
define( 'AUTH_SALT',        ')!Dn}s$8$%g^?rXUSSP]Z:&1M2lMkiUyQBAtU{_`8rv?n-ftyQ?1716qSXebC2V;' );
define( 'SECURE_AUTH_SALT', '.8|:je{y^, G9Ui|ezj/$[3DU%7ieU<cfUo6He]&!:Fw;1$:e5)uf-oW5(m%k5E`' );
define( 'LOGGED_IN_SALT',   '8gR=L^[ B^{|i~Z:;z=bmE[jV7Q,>nXt92.b5D7ePRL/,^&aSALgw20C <XhmjJr' );
define( 'NONCE_SALT',       'Rh~*E[FPD1gIe9Eim({IH9 vn`iiT+lMr.(2peD{q#wDD+RowQR<K;9rzp44r|6f' );
define( 'SMTP_USER',   'AKIA5ELAUGB4VK7Z4UP5' );
define( 'SMTP_PASS',   'BAVWe9M/LGGZhHgmSA/dpoanZB+nNJ1O8rf4YRrbDIa+' );
define( 'SMTP_HOST',   'email-smtp.us-east-1.amazonaws.com' );
define( 'SMTP_FROM',   'naoresponda@flytour.com.br' );
define( 'SMTP_NAME',   'Flytour' );
define( 'SMTP_PORT',   '2587' );
define( 'SMTP_SECURE', 'tls' );
define( 'SMTP_AUTH',    true );
define( 'SMTP_DEBUG',   0 );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
set_time_limit(880); 
ini_set('memory_limit', '512M');

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
