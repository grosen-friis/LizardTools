<?php
$routes = [
    '/' => [ 'ToolsController@home', '/plugin/LizardTools/view/tools_home.php' ],
    '/password-generator' => [ 'ToolsController@password', '/plugin/LizardTools/view/password_generator.php' ],
    '/api/password/length/{}/count/{}/datasets/{}' => [ 'ToolsController@apiPassword', '/plugin/LizardTools/view/api_password_generator.php', 'json' ],
    '/spintext-generator' => [ 'ToolsController@spin', '/plugin/LizardTools/view/spintext_generator.php' ],
    '/api/spintext/count/{}/format/csv/return/text' => [ 'ToolsController@apiSpinFormatCsvReturnText', '/plugin/LizardTools/view/api_spintext_generator.php', 'json' ],
    '/api/spintext/count/{}/format/csv/return/zip' => [ 'ToolsController@apiSpinFormatCsvReturnZip', '/plugin/LizardTools/view/api_spintext_generator.php', 'json' ],
    '/api/spintext/count/{}/format/txt/return/zip' => [ 'ToolsController@apiSpinFormatTxtReturnZip', '/plugin/LizardTools/view/api_spintext_generator.php', 'json' ],
    '/transfers' => [ 'ToolsController@transfer', '/plugin/LizardTools/view/transfer.php' ],
    '/transfer-upload' => [ 'ToolsController@transferUpload', '/plugin/LizardTools/view/transfer_upload.php', 'json' ]
];