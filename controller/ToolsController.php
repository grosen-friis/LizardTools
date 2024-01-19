<?php
class ToolsController extends BaseController
{

    private static array $_FILE_EXTENSIONS_ALLOWED = [
        'jpeg', /* Image */
        'jpg',  /* Image */
        'png',  /* Image */
        'gif',  /* Image */
        'bmp',  /* Image */
        'tiff',  /* Image */
        'pdf',  /* Document */
        'txt',  /* Data */
        'xml',  /* Data */
        'csv',  /* Data */
        'doc',  /* Document */
        'docm',  /* Document */
        'ocx',  /* Document */
        'dot',  /* Document */
        'dotm',  /* Document */
        'dotx',  /* Document */
        'odt',  /* Document */
        'rtf',  /* Document */
        'wps',  /* Document */
        'xps',  /* Document */
        'xls',  /* Document */
        'xlsm',  /* Document */
        'xlsb',  /* Document */
        'xlsx',  /* Document */
        'xlt',  /* Document */
        'xltm',  /* Document */
        'xltx',  /* Document */
        'xlw',  /* Document */
        'pot',  /* Document */
        'potm',  /* Document */
        'potx',  /* Document */
        'ppa',  /* Document */
        'ppam',  /* Document */
        'pps',  /* Document */
        'ppsm',  /* Document */
        'ppsx',  /* Document */
        'ppt',  /* Document */
        'pptm',  /* Document */
        'pptx',  /* Document */
        'pptx',  /* Document */
        'pptx',  /* Document */
        'wmv',  /* Video */
        'mov',  /* Video */
        'mp4',  /* Video */
        'mks'  /* Video */
    ];

    private static array $_FILE_ZIP_EXTENSIONS_ALLOWED = [
        'zip',  /* Archive */
        'gzip', /* Archive */
        'rar',  /* Archive */
    ];

    private static int $_MAX_FILE_SIZE_IN_MB = 1000;

    private static int $_MAX_FILE_AGE_IN_HOURS = 24;


    public function __construct()
    {
        parent::__construct();
    }

    /* =============== PASSWORD TOOL =============== */

    public function password( array $wheres ):array {

        $data = [];

        // $adminController = new AdminController();

        // Test to see if user is logged in with core Admin privileges,
        // If not, user is redirected to admin-login page
        // If user is logged in as core Admin then $data will contain a token.
        // That token must be passed on to the view file
        // $data = $adminController->init( $data );

        $data['viewTitle'] = 'Online password generator tool';
        $data['viewMetaDescription'] = 'Generate up to 50 unique passwords at a time, in the length you specify and that contain characters from five different character sets (letters, numbers and special characters) for you to choose from. ';

        return $data;

    }

    public function apiPassword( array $data ):array {

        $passwordLength = (int) $data['routeComponentsApiIds'][0];
        $passwordCount = (int) $data['routeComponentsApiIds'][1];

        if ($passwordLength >= 6 && $passwordLength <= 2048) {

            if ($passwordCount >= 1 && $passwordCount <= 50) {

                $passwordData = [];
                $passwordData['data']['passwordLength'] = $passwordLength;
                $passwordData['data']['passwordCount'] = $passwordCount;

                $dataSetIdsTemp = str_split($data['routeComponentsApiIds'][2]);
                $dataSetIds = [];

                $isError = false;
                foreach ($dataSetIdsTemp as $dataSetId) {

                    $dataSetId = (int)$dataSetId;
                    if ($dataSetId < 1 || $dataSetId > 5) {
                        $isError = true;
                        break;
                    }

                    if (!isset($dataSetIds[$dataSetId])) {
                        $dataSetIds[$dataSetId] = count($dataSetIds);
                    }
                }

                if (!$isError) {

                    $dataSetIds = array_flip($dataSetIds);

                    $dataSets = [
                        1 => 'abcdefghijklmnopqrstuvwxyz',
                        2 => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
                        3 => '0123456789',
                        4 => '+-!#¤%&=?€£$@',
                        5 => '.,;:_^~*|/?=()[]{}'
                    ];

                    $passwordData['data']['passwordCharacters'] = '';
                    foreach ($dataSetIds as $dataSetId) {
                        $passwordData['data']['passwordCharacters'] .= $dataSets[$dataSetId];
                    }

                    $data = $this->jsGeneratePasswords($passwordData);

                } else {
                    $data = [];
                    $data['output']['error'] = 'Data set IDs must be >= 1 or <= 5';
                }

            } else {
                $data = [];
                $data['output']['error'] = 'Number of passwords must be >= 1 or <= 50';
            }

        } else {

            $data = [];
            $data['output']['error'] = 'Passwords lenge must be >= 6 or <= 2.048';

        }


        return $data;

    }

    /* =============== SPIN TOOL =============== */

    public function spin( array $wheres ):array {

        $data = [];
        $data['viewTitle'] = 'Online spintext generator';
        $data['viewMetaDescription'] = 'Use this tool to generate spintexts based on quality spintax. Spintax is a syntax that you can use to spin finished texts, where software randomly selects words/sentences from lists.';
        return $data;

    }

    public function apiSpinFormatCsvReturnText( array $data ):array
    {

        return $this->apiSpin( $data, 'csv', 'text' );

    }

    public function apiSpinFormatCsvReturnZip( array $data ):array
    {

        return $this->apiSpin( $data, 'csv', 'zip' );

    }

    public function apiSpinFormatTxtReturnZip( array $data ):array
    {

        return $this->apiSpin( $data, 'txt', 'zip' );

    }

    private function apiSpin( array $data, string $filesFormat, string $filesReturn ):array
    {
        $spintextCount = (int) $data['routeComponentsApiIds'][0];

        if ($spintextCount > 0) {

            if (isset($data['spintax']) && is_string($data['spintax']) && strlen($data['spintax']) > 0) {

                $spintax = $data['spintax'];
                $errorMessage = $this->spinValidateSpintax($spintax);

                if ($errorMessage == '') {

                    $data = [];
                    $data['data']['spintax'] = $spintax;
                    $data['data']['filesFormat'] = $filesFormat;
                    $data['data']['filesReturn'] = $filesReturn;
                    $data['data']['filesCount'] = $spintextCount;

                    $spinData = $this->jsSpinGenerateFiles( $data );

                    $data = [];
                    $data['output']['spin_count'] = $spintextCount;
                    if ($filesReturn == 'text') {
                        $data['output']['spin_text'] = $spinData['output']['spinnerTextCsv'];
                    } else if ($filesReturn == 'zip') {
                        $data['output']['download_zip_fil_url'] = "https://grosen.tools/download/{$spinData['output']['zipFileRelativePath']}";
                    }

                } else {
                    $data = [];
                    $data['output']['error'] = "Spintax is invalid: {$errorMessage} [ {$this->spinSpinTax($spintax)} ]";
                }

            } else {
                $data = [];
                $data['output']['error'] = 'Spintax is not part of post-data or spin-tax postdata is blank';
            }

        } else {
            $data = [];
            $data['output']['error'] = 'Text count must be >= 1';
        }

        return $data;

    }


    private function spinSpinTax( string $spintax_s ):string {

        if (strlen($spintax_s) > 0) {

            $encoding_s = 'UTF-8';
            $spintaxLength_i = mb_strlen($spintax_s, $encoding_s);

            if ($spintaxLength_i > 0) {

                while (true) {

                    $spintaxLength_i = mb_strlen($spintax_s, $encoding_s);
                    $endBlock_i = mb_strpos($spintax_s, '}', 0, $encoding_s);
                    if (is_int($endBlock_i)) {
                        $tempBeginBlock_i = 0;
                        $offSet_i = 0;

                        while (true) {

                            $beginBlock_i = mb_strpos($spintax_s, '{', $offSet_i, $encoding_s);
                            if (is_int($beginBlock_i) && $beginBlock_i < $endBlock_i) {
                                $tempBeginBlock_i = $beginBlock_i;
                                $offSet_i = $beginBlock_i + 1;
                            } else {
                                $beginBlock_i = $tempBeginBlock_i +  1;
                                $variantsLength_i = $endBlock_i - $beginBlock_i;
                                $variants_s = mb_substr($spintax_s, $beginBlock_i, $variantsLength_i, $encoding_s);
                                $randomVariant_s = $this->spinGetRandomVariant($variants_s);

                                $tempSpintax_s = mb_substr($spintax_s, 0, ($beginBlock_i - 1), $encoding_s);
                                $tempSpintax_s .=  $randomVariant_s;
                                $tempSpintax_s .= mb_substr($spintax_s, ($endBlock_i + 1), (mb_strlen($spintax_s) - $endBlock_i), $encoding_s);

                                $spintax_s = $tempSpintax_s;
                                $encoding_s = 'UTF-8';
                                break;
                            }
                        }
                    } else {
                        break;
                    }
                }
            }
        } else {
            $spintax_s = '';
        }

        return $spintax_s;
    }

    private function spinColorSpintax( string $spintax_s ):string {
        $colorLevel_Ar = null;
        $colorLevel_Ar[] = 'Black';
        $colorLevel_Ar[] = 'Green';
        $colorLevel_Ar[] = 'Grey';
        $colorLevel_Ar[] = 'Red';
        $colorLevel_Ar[] = 'Blue';
        $colorLevel_Ar[] = 'Cyan';
        $colorLevel_Ar[] = 'Silver';
        $colorLevel_Ar[] = 'Orange';
        $colorLevel_Ar[] = 'Brown';
        $colorLevel_Ar[] = 'Yellow';

        $colorLevel_i = 0;
        $colorLevelMax_i = count($colorLevel_Ar) - 1;
        if (!is_null($spintax_s))
        {
            $encoding_s = 'UTF-8';
            $spintaxLength_i = mb_strlen($spintax_s, $encoding_s);
            if ($spintaxLength_i > 0)
            {
                $colorSpintax_s = "<span style=\"color: {$colorLevel_Ar[$colorLevel_i]};\">";
                for ($i = 0; $i < $spintaxLength_i; ++$i)
                {
                    $letter_s = mb_substr($spintax_s, $i, 1, $encoding_s);
                    if ($letter_s == '{')
                    {
                        ++$colorLevel_i;
                        if ($colorLevel_i > $colorLevelMax_i)
                        {
                            $colorLevel_i = 0;
                        }
                        $colorSpintax_s .= "</span><span style=\"color: Purple;\">{$letter_s}</span><span style=\"color: {$colorLevel_Ar[$colorLevel_i]};\">";

                    }
                    else if ($letter_s == '}')
                    {
                        --$colorLevel_i;
                        if ($colorLevel_i < 0)
                        {
                            $colorLevel_i = $colorLevelMax_i;
                        }
                        $colorSpintax_s .= "</span><span style=\"color: Purple;\">{$letter_s}</span><span style=\"color: {$colorLevel_Ar[$colorLevel_i]};\">";
                    }
                    else if ($letter_s == '|')
                    {
                        $colorSpintax_s .= "</span><span style=\"color: Purple;\">{$letter_s}</span><span style=\"color: {$colorLevel_Ar[$colorLevel_i]};\">";
                    }
                    else
                    {
                        $colorSpintax_s .= $letter_s;
                    }
                }
                $colorSpintax_s .= '</span>';
            }
        }
        else
        {
            $colorSpintax_s = '';
        }

        return $colorSpintax_s;
    }


    private function spinValidateSpintax( string $spintax_s ):string
    {

        $errorMessage_s = '';
        if (strlen($spintax_s) > 0) {

            $encoding_s = 'UTF-8';
            $curleyBracketLeftCount_i = 0;
            $curleyBracketRightCount_i = 0;


            $spintaxLength_i = mb_strlen($spintax_s, $encoding_s);
            if ($spintaxLength_i > 0)
            {
                for ($i = 0; $i < $spintaxLength_i; ++$i)
                {
                    $letter_s = mb_substr($spintax_s, $i, 1, $encoding_s);
                    if ($letter_s == '{')
                    {
                        ++$curleyBracketLeftCount_i;

                    }
                    else if ($letter_s == '}')
                    {
                        ++$curleyBracketRightCount_i;
                    }
                }

                $difference_i = $curleyBracketLeftCount_i - $curleyBracketRightCount_i;

                if ($difference_i != 0)
                {
                    $errorMessage_s = 'Syntax error: Spintax contains';
                }


                if ($curleyBracketLeftCount_i > $curleyBracketRightCount_i)
                {
                    $errorMessage_s .= ' "{" that does not have a related ending "}" i.e. a "}" is missing.';
                }

                if ($curleyBracketLeftCount_i < $curleyBracketRightCount_i)
                {
                    $errorMessage_s .= ' "}" that does not have a related beginning "{" i.e. a "{" is missing..';
                }

            }
        }

        return $errorMessage_s;
    }

    private function spinGetRandomVariant( string $variants_s ):string {

        $randomVariant_s = '';
        $encoding_s = 'UTF-8';
        if (!is_null($variants_s) && mb_strlen($variants_s, $encoding_s) > 0)
        {
            $delimiterIdx_i = mb_strpos($variants_s, '|', 0, $encoding_s);
            if (is_int($delimiterIdx_i))
            {
                $variants_Ar = explode('|', $variants_s);
                $variantsCount_i = count($variants_Ar);
                $random_i =  mt_rand(0, ($variantsCount_i - 1));
                $randomVariant_s = (string) $variants_Ar[$random_i];
            }
            else
            {
                $randomVariant_s = $variants_s;
            }
        }

        return $randomVariant_s;
    }

    /* =============== TRANSFER TOOL =============== */

    public function transfer( array $wheres ):array {

        $data = [];

        // $adminController = new AdminController();

        // Test to see if user is logged in with core Admin privileges,
        // If not, user is redirected to admin-login page
        // If user is logged in as core Admin then $data will contain a token.
        // That token must be passed on to the view file
        // $data = $adminController->init( $data );

        // Delete zip-files that are more than 24 hours old
        $currentDirectory = getcwd();
        $uploadDirectoryPath = "{$currentDirectory}/download/";
        $zipFiles = scandir($uploadDirectoryPath);
        $rightNowTime = time();
        $oneDayInSeconds = self::$_MAX_FILE_AGE_IN_HOURS*60*60;
        foreach ($zipFiles as $zipFile) {

            if ($zipFile == '.' || $zipFile == '..') { continue; }
            if (is_dir("{$uploadDirectoryPath}/{$zipFile}")) { continue; }
            if (is_file("{$uploadDirectoryPath}/{$zipFile}")) {

                $zipFileElements = pathinfo("{$uploadDirectoryPath}/{$zipFile}");
                if (isset($zipFileElements['extension']) && strtolower($zipFileElements['extension']) == 'zip') {

                    $zipFileTime = filectime("{$uploadDirectoryPath}/{$zipFile}");

                    if ( ($rightNowTime - $zipFileTime) > $oneDayInSeconds) {
                        unlink("{$uploadDirectoryPath}/{$zipFile}");
                    }
                }
            }
        }

        $data['viewTitle'] = 'Transfer large file tool';
        $data['viewMetaDescription'] = 'Transfer a file up to ' . self::$_MAX_FILE_SIZE_IN_MB . ' MB from one computer or phone to another. You upload the file and get a download link you can share. ';
        $data['maxFileSizeInMb'] = self::$_MAX_FILE_SIZE_IN_MB;
        $data['maxFileAgeInHours'] = self::$_MAX_FILE_AGE_IN_HOURS;

        $fileExtensionsAllowed = self::$_FILE_EXTENSIONS_ALLOWED;
        $fileExtensionsAllowed = array_merge($fileExtensionsAllowed, self::$_FILE_ZIP_EXTENSIONS_ALLOWED);

        $data['fileExtensionsAllowed'] = implode(' | ', $fileExtensionsAllowed);
        $data['fileExtensionsAllowedJson'] = json_encode($fileExtensionsAllowed);

        return $data;

    }


    public function transferUpload( array $data ):array {

        /* JavaScript documentation with upload progress indicator: https://usefulangle.com/post/321/javascript-fetch-upload-progress */

        $currentDirectory = getcwd();
        $uploadDirectory = "/download/";

        $statusMessage = '';
        $errorMessage = '';
        if (isset($_FILES['file']['name']) && isset($_FILES['file']['size']) && isset($_FILES['file']['tmp_name']) && isset($_FILES['file']['type'])) {

            $fileName = $_FILES['file']['name'];
            $fileSize = $_FILES['file']['size'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileType = $_FILES['file']['type'];

            $fileNameElements = explode('.', $fileName);
            if (count($fileNameElements) > 1) {
                $fileExtension = strtolower(end($fileNameElements));

                if (!in_array($fileExtension, self::$_FILE_EXTENSIONS_ALLOWED) && !in_array($fileExtension, self::$_FILE_ZIP_EXTENSIONS_ALLOWED)) {
                    $errorMessage = "Upload file extension [{$fileExtension}] is not allowed";
                } else {

                    if ($fileSize > (self::$_MAX_FILE_SIZE_IN_MB * 1000000)) {
                        $errorMessage = 'The size of the upload file exceeds maximum: [' . self::$_MAX_FILE_SIZE_IN_MB . '] MB.';

                    } else {

                        if (empty($errors)) {

                            $uploadFileNameHash = md5($fileName . $fileSize . $fileTmpName . $fileType . $fileExtension . time());
                            $fileBaseName = basename($fileName);
                            $uploadFilePathPrefix = "{$currentDirectory}{$uploadDirectory}";
                            $isUpload = false;
                            if (in_array($fileExtension, self::$_FILE_ZIP_EXTENSIONS_ALLOWED)) {

                                $uploadFilePath = "{$uploadFilePathPrefix}{$uploadFileNameHash}.{$fileExtension}";
                                $isUpload = move_uploaded_file($fileTmpName, $uploadFilePath);
                                $fileBaseName = "{$uploadFileNameHash}.{$fileExtension}";

                            } else {

                                $uploadFolderPath = "{$uploadFilePathPrefix}/{$uploadFileNameHash}";
                                if (mkdir($uploadFolderPath)) {

                                    $uploadFilePath = "{$uploadFolderPath}/{$fileBaseName}";
                                    $isUpload = move_uploaded_file($fileTmpName, $uploadFilePath);

                                    $zip = new ZipArchive();

                                    $zipFilePath = "{$uploadFilePathPrefix}{$uploadFileNameHash}.zip";

                                    if (file_exists($zipFilePath)) {
                                        unlink($zipFilePath);
                                    }

                                    if (!$zip->open($zipFilePath, ZIPARCHIVE::CREATE)) {
                                        $errorMessage = 'An error occurred, so file was not uploaded, please try again';
                                    } else {
                                        $zip->addFile($uploadFilePath, $fileBaseName);
                                        $zip->close();
                                        unlink($uploadFilePath);
                                        rmdir($uploadFolderPath);
                                        $fileBaseName = "{$uploadFileNameHash}.zip";
                                    }
                                }
                            }

                            if ($isUpload) {
                                $statusMessage = $fileBaseName;
                            } else {
                                $errorMessage = 'An error occurred, so file was not uploaded, please try again';
                            }
                        }
                    }
                }
            }
        }

        $data['statusMessage'] = $statusMessage;
        $data['errorMessage'] = $errorMessage;

        return $data;
    }


    /* =============== GENERAL functions =============== */

    public function home( array $wheres ):array {

        $data = [];

        // $adminController = new AdminController();

        // Test to see if user is logged in with core Admin privileges,
        // If not, user is redirected to admin-login page
        // If user is logged in as core Admin then $data will contain a token.
        // That token must be passed on to the view file
        // $data = $adminController->init( $data );

        $data['viewTitle'] = 'Online tools';
        $data['viewMetaDescription'] = 'List of free online tools';
        $data['viewApiMetaDescription'] = 'List of free online APIs';

        return $data;

    }


    /* =============== PASSWORD TOOL =============== */

    public function jsGeneratePasswords( array $data ):array {

        $passwordLength = (isset($data['data']['passwordLength']) && $data['data']['passwordLength'] !== NULL && is_int($data['data']['passwordLength']) && $data['data']['passwordLength'] >= 6 && $data['data']['passwordLength'] <= 2048) ? $data['data']['passwordLength'] : NULL;
        $passwordCount = (isset($data['data']['passwordCount']) && $data['data']['passwordCount'] !== NULL && is_int($data['data']['passwordCount']) && $data['data']['passwordCount'] >= 1 && $data['data']['passwordCount'] <= 50) ? $data['data']['passwordCount'] : NULL;
        $passwordCharacters = (isset($data['data']['passwordCharacters']) && $data['data']['passwordCharacters'] !== NULL && is_string($data['data']['passwordCharacters']) && strlen($data['data']['passwordCharacters']) > 0) ? $data['data']['passwordCharacters'] : NULL;

        $passwords = [];
        if ($passwordLength !== NULL && $passwordCount !== NULL && $passwordCharacters !== NULL) {

            $passwordCharactersLength = (strlen($passwordCharacters) - 1);

            for ($i = 0; $i < $passwordCount; $i++) {

                $isPasswordInUse = true;
                while($isPasswordInUse) {
                    $password = '';
                    for ($j = 0; $j < $passwordLength; $j++) {
                        $password .= mb_substr($passwordCharacters, rand(0, $passwordCharactersLength), 1);
                    }
                    if (!isset($passwords[$password])) {
                        $passwords[$password] = count($passwords);
                        $isPasswordInUse = false;
                    }
                }
            }
        }

        $passwords = array_flip($passwords);

        unset($data['data']);
        $data['format'] = 'json';
        $data['output'] = [
            'passwords' => $passwords
        ];

        return $data;

    }


    public function jsSpinGenerateFiles( array $data ) {

        $spintax = (isset($data['data']['spintax']) && $data['data']['spintax'] !== NULL && is_string($data['data']['spintax']) && strlen($data['data']['spintax']) > 0) ? $data['data']['spintax'] : NULL;
        $filesFormat = (isset($data['data']['filesFormat']) && $data['data']['filesFormat'] !== NULL && is_string($data['data']['filesFormat']) && strlen($data['data']['filesFormat']) > 0) ? $data['data']['filesFormat'] : NULL;
        $filesCount = (isset($data['data']['filesCount']) && $data['data']['filesCount'] !== NULL && is_string($data['data']['filesFormat']) && strlen($data['data']['filesCount']) > 0 && ((int) $data['data']['filesCount']) > 0) ? $data['data']['filesCount'] : NULL;
        $filesReturn = (isset($data['data']['filesReturn']) && $data['data']['filesReturn'] !== NULL && is_string($data['data']['filesReturn']) && strlen($data['data']['filesReturn']) > 0) ? $data['data']['filesReturn'] : 'zip';

        $statusMessage = '';
        $zipFileRelativePath = '';
        $spinnerTextCsv = '';

        if ($spintax !== NULL && $filesFormat !== NULL && $filesCount !== NULL) {

            $date = new DateTime();
            $timeStamp_i = $date->getTimestamp();
            $zipFolderNamePrefix_s = '';
            for ($i = 0; $i < 5; ++$i) {
                $zipFolderNamePrefix_s .= chr(rand(97, 122));
            }

            if ($filesReturn == 'zip') {
                $zipFolderName_s = "{$zipFolderNamePrefix_s}{$timeStamp_i}";
                $zipFolderPath_s = "{$_SERVER['DOCUMENT_ROOT']}/download/{$zipFolderName_s}";
                $zipFileRelativePath = "{$zipFolderName_s}/spin-that-spintax.zip";
                $zipFilePath_s = "{$zipFolderPath_s}/spin-that-spintax.zip";
            }

            if (mb_detect_encoding($spintax, mb_detect_order()) == "ASCII") {
                $spintaxUtf8_s = utf8_encode($spintax);
                $spintax = $spintaxUtf8_s;
            }

            // The "download" folder must be made via ssh and given chmod 777
            if ($filesReturn == 'zip') {
                if (!is_dir($zipFolderPath_s)) {
                    mkdir($zipFolderPath_s);
                }
            }

            $spinnerTextHash_Ar = [];
            if ($filesReturn == 'zip') {
                $zipFile_Fi = new ZipArchive();
                $zipFile_Fi->open($zipFilePath_s, ZIPARCHIVE::CREATE);
            }

            for ($f = 0; $f < $filesCount; ++$f) {

                $spinnerFileName_s = '';
                if ($filesFormat == 'txt') {
                    $spinnerFileName_s = "spinner_" . $f . ".txt";
                } else if ($filesFormat == 'csv') {
                    $spinnerFileName_s = "spinner.csv";
                }

                $retryCount_i = 0;
                $isUniqueText_b = false;

                while (true) {
                    $retryCount_i++;
                    $spinnerText_s = $this->spinSpinTax($spintax);

                    $spinnerTextHash_s = md5($spinnerText_s);
                    if (!isset($spinnerTextHash_Ar[$spinnerTextHash_s])) {
                        $spinnerTextHash_Ar[$spinnerTextHash_s] = 0;
                        $isUniqueText_b = true;
                        break;
                    } else {
                        if ($retryCount_i >= 100000) {
                            break;
                        } else {
                            continue;
                        }
                    }
                }
                if (!$isUniqueText_b) {
                    break;
                }

                if ($filesFormat == 'txt') {
                    file_put_contents($zipFolderPath_s . "/" . $spinnerFileName_s, utf8_decode($spinnerText_s));
                    $zipFile_Fi->addFile($zipFolderPath_s . "/" . $spinnerFileName_s, $spinnerFileName_s);

                } else if ($filesFormat == 'csv') {
                    $searchFor = ["\r\n", "\n", "\t", '  '];
                    $replaceWith = [' ', ' ', ' ', ' '];

                    $spinnerText_s = str_replace($searchFor, $replaceWith, $spinnerText_s);
                    $spinnerTextCsv .= $spinnerText_s . "\n";
                }
            }

            if ($filesFormat == 'csv' && $filesReturn == 'zip') {
                file_put_contents($zipFolderPath_s . "/" . $spinnerFileName_s, utf8_decode($spinnerTextCsv));
                $zipFile_Fi->addFile($zipFolderPath_s . "/" . $spinnerFileName_s, $spinnerFileName_s);
            }

            if ($filesReturn == 'zip') {
                $zipFile_Fi->close();
            }

            if ($filesReturn == 'zip') {
                if ($filesFormat == 'txt') {
                    for ($f = 0; $f < $filesCount; ++$f) {
                        $spinnerFileName_s = "spinner_" . $f . ".txt";
                        unlink($zipFolderPath_s . "/" . $spinnerFileName_s);
                    }
                } else if ($filesFormat == 'csv') {
                    unlink($zipFolderPath_s . "/spinner.csv");
                }
            }
        }

        unset($data['data']);
        $data['format'] = 'json';
        $data['output']['statusMessage'] = $statusMessage;

        if ($filesReturn == 'zip') {
            $data['output']['zipFileRelativePath'] = $zipFileRelativePath;
        } else if ($filesReturn == 'text') {
            $data['output']['spinnerTextCsv'] = $spinnerTextCsv;
        }

        return $data;
    }

    public function jsSpinValidateSpintax( array $data ) {

        $spintax = (isset($data['data']['spintax']) && $data['data']['spintax'] !== NULL && is_string($data['data']['spintax']) && strlen($data['data']['spintax']) > 0) ? $data['data']['spintax'] : NULL;

        $errorMessage = '';
        if ($spintax !== NULL) {
            $errorMessage = $this->spinValidateSpintax( $spintax );
        }

        unset($data['data']);
        $data['format'] = 'json';
        $data['output'] = [
            'errorMessage' => $errorMessage
        ];

        return $data;
    }

    public function jsSpinSpinTax( array $data ) {

        $spintax = (isset($data['data']['spintax']) && $data['data']['spintax'] !== NULL && is_string($data['data']['spintax']) && strlen($data['data']['spintax']) > 0) ? $data['data']['spintax'] : NULL;

        $spinText = '';
        if ($spintax !== NULL) {
            $spinText = $this->spinSpinTax( $spintax );
        }

        unset($data['data']);
        $data['format'] = 'json';
        $data['output'] = [
            'spinText' => $spinText
        ];

        return $data;
    }

    public function jsSpinColorSpinTax( array $data ) {

        $spintax = (isset($data['data']['spintax']) && $data['data']['spintax'] !== NULL && is_string($data['data']['spintax']) && strlen($data['data']['spintax']) > 0) ? $data['data']['spintax'] : NULL;

        $coloredSpinTax = '';
        if ($spintax !== NULL) {
            $coloredSpinTax = $this->spinColorSpintax( $spintax );
        }

        unset($data['data']);
        $data['format'] = 'json';
        $data['output'] = [
            'coloredSpinTax' => $coloredSpinTax
        ];

        return $data;
    }



}
