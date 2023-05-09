<?php
class LizardToolsPlugin extends BasePlugin
{

    public function __construct()
    {
        parent::__construct();
        $this->_pluginVersion = 1.0;
        $this->_pluginName = 'LizardTools';
        $this->_pluginDescription = 'LizardTools plugin by Grosen Friis';
        // $this->_pluginClass /* Set by BasePlugin->setClass() */
        // $this->_pluginFilePath /* Set by BasePlugin->setFolderAndFile() */
        $this->_pluginFolderPath = __DIR__;
        // $this->_pluginError /* Set by BasePlugin->setError() */
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function activate(array $results = [] ):array
    {

        $results = [];

        /*
        $sql = "CREATE TABLE IF NOT EXISTS `lele_languages` (
  `lele_languages_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lele_languages_iso1` varchar(255) NOT NULL,
  PRIMARY KEY (`lele_languages_id`),
  UNIQUE KEY `uidx_lele_languages_iso1` (`lele_languages_iso1`(2)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";;
        $results[] = $this->_database->query($sql);

        $sql = "TRUNCATE `lele_languages`;";
        $results[] = $this->_database->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `lele_language_translations` (
  `lele_language_translations_id` bigint unsigned NOT NULL,
  `lele_languages_id` bigint unsigned NOT NULL,
  `lele_language_translations_name` tinytext NOT NULL,
  UNIQUE KEY `uidx_lele_language_translations_id_lele_languages_id` (`lele_language_translations_id`,`lele_languages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
        $results[] = $this->_database->query($sql);

        $sql = "TRUNCATE `lele_language_translations`;";
        $results[] = $this->_database->query($sql);

        */

        $result = [];
        $result['result'] = [];
        $result['error'] = false;

        $results[] = $result;


        return parent::activate( $results );

    }

    public function upgrade()
    {
        return $this;
    }

}