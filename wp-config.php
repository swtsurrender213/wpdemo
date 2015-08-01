<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wpdemo');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+agH=+xGFQU._go)7((sbX%//Zi6}zp,}4}*]|GV_4Uj]rncK??I`uumw![Q:-{C');
define('SECURE_AUTH_KEY',  'EBQHanS_mD^_EHp=ErNt`M20y%gu 26Q,-qV|iFdK37|>l=az/?lcf,;Y|a+Wr h');
define('LOGGED_IN_KEY',    '~T8E6MST@lY#IF}xU;m-k}S1H+b&#2zgnhc{Q@]f`d4n-j$#D@}Gqygf;&9(q+v;');
define('NONCE_KEY',        'uSygsj .qRicRH~I0<TC#+|Fq/xGD=&Hfes9?<7hmY>Y+_+smxj!2-&CF&Oh4rxt');
define('AUTH_SALT',        'FR5%ir1ibi+ob=hMpn*sSm1q#UY<nSW{Ai(c<,#UV3o:q{0J_|]+QqGDE%zmv}[k');
define('SECURE_AUTH_SALT', 'Qlw&_!K!iy[wcW|]2/=7#u#KU(A+WAt%Oj/+SP#Jh}UENwpfI3lyhfW!6gru`=>H');
define('LOGGED_IN_SALT',   'mg:8N^/#w=G?9!*wVX^4^7Xsa_YZgA<nK89_5P^LN^WkM/pv;/+Ra32)ECI3?bO;');
define('NONCE_SALT',       'C-`jp~^I<usSg$!HIR]TE?^5z;q9H@u-s#es@9We/oVV/+^tn~tPUn||c9`JcI+f');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpdem_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
