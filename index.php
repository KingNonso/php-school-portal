<?php /* Model View Controller */?>
<?php
    //use an autoloader
    require 'config/core/ini.php';

    define('URL', 'http://localhost/school_portal/');
    define('UPLOAD_PATH', __DIR__.'\public\uploads\\');
    define('TEST_INC', __DIR__.'\views\\');

    $app = new Bootstrap();
