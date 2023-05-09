<?php
$routes = [
    '/password-generator' => [ 'ToolsController@password', '/plugin/LizardTools/view/password_generator.php' ],
    '/api/password/length/{}/count/{}/datasets/{}' => [ 'ToolsController@apiPassword', '/plugin/LizardTools/view/api_password_generator.php', 'json' ],
    '/' => [ 'ToolsController@home', '/plugin/LizardTools/view/tools_home.php' ]
];
