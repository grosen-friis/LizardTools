<?php
class ToolsController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

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
}