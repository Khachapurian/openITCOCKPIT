<?php

$timezone = date_default_timezone_get();
if (empty($timezone)) {
    $timezone = 'UTC';
}

return [
    /**
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug'    => filter_var(env('OITC_DEBUG', false), FILTER_VALIDATE_BOOLEAN),

    /**
     * Configure basic information about the application.
     *
     * - namespace - The namespace to find app classes under.
     * - defaultLocale - The default locale for translation, formatting currencies and numbers, date and time.
     * - encoding - The encoding used for HTML + database connections.
     * - base - The base directory the app resides in. If false this
     *   will be auto detected.
     * - dir - Name of app directory.
     * - webroot - The webroot directory.
     * - wwwRoot - The file path to webroot.
     * - baseUrl - To configure CakePHP to *not* use mod_rewrite and to
     *   use CakePHP pretty URLs, remove these .htaccess
     *   files:
     *      /.htaccess
     *      /webroot/.htaccess
     *   And uncomment the baseUrl key below.
     * - fullBaseUrl - A base URL to use for absolute links. When set to false (default)
     *   CakePHP generates required value based on `HTTP_HOST` environment variable.
     *   However, you can define it manually to optimize performance or if you
     *   are concerned about people manipulating the `Host` header.
     * - imageBaseUrl - Web path to the public images directory under webroot.
     * - cssBaseUrl - Web path to the public css directory under webroot.
     * - jsBaseUrl - Web path to the public js directory under webroot.
     * - paths - Configure paths for non class based resources. Supports the
     *   `plugins`, `templates`, `locales` subkeys, which allow the definition of
     *   paths for plugins, view templates and locale files respectively.
     */
    'App'      => [
        'namespace'       => 'App',
        'encoding'        => 'UTF-8',
        'defaultLocale'   => 'en_US',
        'defaultTimezone' => $timezone,
        'base'            => false,
        'dir'             => 'src',
        'webroot'         => 'webroot',
        'wwwRoot'         => WWW_ROOT,
        //'baseUrl' => env('SCRIPT_NAME'),
        'fullBaseUrl'     => false,
        'imageBaseUrl'    => 'img/',
        'cssBaseUrl'      => 'css/',
        'jsBaseUrl'       => 'js/',
        'paths'           => [
            'plugins'   => [ROOT . DS . 'plugins' . DS],
            'templates' => [APP . 'Template' . DS],
            'locales'   => [ROOT . DS . 'resources' . DS . 'locales' . DS],
        ],
    ],

    /**
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => 'cf4515a2c1833f4aed69591f81598da0124cbd460449b2812495a64d8d70aadc'
    ],

    /**
     * Apply timestamps with the last modified time to static assets (js, css, images).
     * Will append a querystring parameter containing the time the file was modified.
     * This is useful for busting browser caches.
     *
     * Set to true to apply timestamps when debug is true. Set to 'force' to always
     * enable timestamping regardless of debug value.
     */
    'Asset'    => [
        //'timestamp' => true,
        // 'cacheTime' => '+1 year'
    ],

    /**
     * Configure the cache adapters.
     */
    'Cache'    => [
        'default' => [
            'className' => \Cake\Cache\Engine\FileEngine::class,
            'path'      => CACHE,
            'url'       => null
        ],

        'migration' => [
            'className' => \Cake\Cache\Engine\RedisEngine::class,
            'serialize' => true,
            'prefix'    => 'oitc_',
            'duration'  => '+30 minute',
            'host'      => '127.0.0.1',
            'port'      => 6379
        ],

        'permissions'   => [
            'className' => \Cake\Cache\Engine\RedisEngine::class,
            'serialize' => true,
            'prefix'    => 'permissions_',
            'duration'  => '+600 seconds',
            'host'      => '127.0.0.1',
            'port'      => 6379
        ],

        'long_time_cache'   => [
            'className' => \Cake\Cache\Engine\RedisEngine::class,
            'serialize' => true,
            'prefix'    => 'ltc_',
            'duration'  => '+24 hours',
            'host'      => '127.0.0.1',
            'port'      => 6379
        ],

        /**
         * Configure the cache used for general framework caching.
         * Translation cache files are stored with this configuration.
         * Duration will be set to '+2 minutes' in bootstrap.php when debug = true
         * If you set 'className' => 'Null' core cache will be disabled.
         */
        '_cake_core_'   => [
            'className' => \Cake\Cache\Engine\FileEngine::class,
            'prefix'    => 'myapp_cake_core_',
            'path'      => CACHE . 'persistent/',
            'serialize' => true,
            'duration'  => '+1 years',
            'url'       => env('CACHE_CAKECORE_URL', null),
        ],

        /**
         * Configure the cache for model and datasource caches. This cache
         * configuration is used to store schema descriptions, and table listings
         * in connections.
         * Duration will be set to '+2 minutes' in bootstrap.php when debug = true
         */
        '_cake_model_'  => [
            'className' => \Cake\Cache\Engine\FileEngine::class,
            'prefix'    => 'myapp_cake_model_',
            'path'      => CACHE . 'models/',
            'serialize' => true,
            'duration'  => '+1 years',
            'url'       => env('CACHE_CAKEMODEL_URL', null),
        ],

        /**
         * Configure the cache for routes. The cached routes collection is built the
         * first time the routes are processed via `config/routes.php`.
         * Duration will be set to '+2 seconds' in bootstrap.php when debug = true
         */
        '_cake_routes_' => [
            'className' => \Cake\Cache\Engine\FileEngine::class,
            'prefix'    => 'myapp_cake_routes_',
            'path'      => CACHE,
            'serialize' => true,
            'duration'  => '+1 years',
            'url'       => env('CACHE_CAKEROUTES_URL', null),
        ],
    ],

    /**
     * Configure the Error and Exception handlers used by your application.
     *
     * By default errors are displayed using Debugger, when debug is true and logged
     * by Cake\Log\Log when debug is false.
     *
     * In CLI environments exceptions will be printed to stderr with a backtrace.
     * In web environments an HTML page will be displayed for the exception.
     * With debug true, framework errors like Missing Controller will be displayed.
     * When debug is false, framework errors will be coerced into generic HTTP errors.
     *
     * Options:
     *
     * - `errorLevel` - int - The level of errors you are interested in capturing.
     * - `trace` - boolean - Whether or not backtraces should be included in
     *   logged errors/exceptions.
     * - `log` - boolean - Whether or not you want exceptions logged.
     * - `exceptionRenderer` - string - The class responsible for rendering
     *   uncaught exceptions. If you choose a custom class you should place
     *   the file for that class in src/Error. This class needs to implement a
     *   render method.
     * - `skipLog` - array - List of exceptions to skip for logging. Exceptions that
     *   extend one of the listed exceptions will also be skipped for logging.
     *   E.g.:
     *   `'skipLog' => ['Cake\Http\Exception\NotFoundException', 'Cake\Http\Exception\UnauthorizedException']`
     * - `extraFatalErrorMemory` - int - The number of megabytes to increase
     *   the memory limit by when a fatal error is encountered. This allows
     *   breathing room to complete logging or error handling.
     */
    'Error'    => [
        'errorLevel'        => E_ALL,
        'exceptionRenderer' => \Cake\Error\ExceptionRenderer::class,
        'skipLog'           => [],
        'log'               => true,
        'trace'             => true,
    ],


    /**
     * Configures logging options
     */
    'Log'      => [
        'debug'   => [
            'className' => \Cake\Log\Engine\FileLog::class,
            'path'      => LOGS,
            'file'      => 'debug',
            'url'       => env('LOG_DEBUG_URL', null),
            'scopes'    => false,
            'levels'    => ['notice', 'info', 'debug'],
        ],
        'error'   => [
            'className' => \Cake\Log\Engine\FileLog::class,
            'path'      => LOGS,
            'file'      => 'error',
            'url'       => env('LOG_ERROR_URL', null),
            'scopes'    => false,
            'levels'    => ['warning', 'error', 'critical', 'alert', 'emergency'],
        ],
        // To enable this dedicated query log, you need set your datasource's log flag to true
        'queries' => [
            'className' => \Cake\Log\Engine\FileLog::class,
            'path'      => LOGS,
            'file'      => 'queries',
            'url'       => env('LOG_QUERIES_URL', null),
            'scopes'    => ['queriesLog'],
        ],
    ],

    /**
     * Session configuration.
     *
     * Contains an array of settings to use for session configuration. The
     * `defaults` key is used to define a default preset to use for sessions, any
     * settings declared here will override the settings of the default config.
     *
     * ## Options
     *
     * - `cookie` - The name of the cookie to use. Defaults to 'CAKEPHP'. Avoid using `.` in cookie names,
     *   as PHP will drop sessions from cookies with `.` in the name.
     * - `cookiePath` - The url path for which session cookie is set. Maps to the
     *   `session.cookie_path` php.ini config. Defaults to base path of app.
     * - `timeout` - The time in minutes the session should be valid for.
     *    Pass 0 to disable checking timeout.
     *    Please note that php.ini's session.gc_maxlifetime must be equal to or greater
     *    than the largest Session['timeout'] in all served websites for it to have the
     *    desired effect.
     * - `defaults` - The default configuration set to use as a basis for your session.
     *    There are four built-in options: php, cake, cache, database.
     * - `handler` - Can be used to enable a custom session handler. Expects an
     *    array with at least the `engine` key, being the name of the Session engine
     *    class to use for managing the session. CakePHP bundles the `CacheSession`
     *    and `DatabaseSession` engines.
     * - `ini` - An associative array of additional ini values to set.
     *
     * The built-in `defaults` options are:
     *
     * - 'php' - Uses settings defined in your php.ini.
     * - 'cake' - Saves session files in CakePHP's /tmp directory.
     * - 'database' - Uses CakePHP's database sessions.
     * - 'cache' - Use the Cache class to save sessions.
     *
     * To define a custom session handler, save it at src/Network/Session/<name>.php.
     * Make sure the class implements PHP's `SessionHandlerInterface` and set
     * Session.handler to <name>
     *
     * To use database sessions, load the SQL file located at config/schema/sessions.sql
     */
    'Session'  => [
        'defaults' => env('SESSION_DEFAULTS', 'php'),
    ],
];
