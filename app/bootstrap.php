<?php
// Load config
require_once 'config/config.php';

// Load helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';

// Autoload core libraries - controller, core, database
// the filename must match the classname
spl_autoload_register( function ( $className ) {
    require_once 'libraries/' . $className . '.php';
} );
