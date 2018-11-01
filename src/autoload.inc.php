<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
function autoloade55fd2f45fe2a784cd73b9b223a34b86($class) {
    static $classes = null;
    if ($classes === null) {
        $classes = array(
            'controller\\basecontroller' => '/controller/BaseController.php',
            'controller\\playercontroller' => '/controller/PlayerController.php',
            'controller\\teamcontroller' => '/controller/TeamController.php',
            'model\\factory\\playerfactory' => '/model/factory/PlayerFactory.php',
            'model\\factory\\teamfactory' => '/model/factory/TeamFactory.php',
            'model\\player' => '/model/Player.php',
            'model\\team' => '/model/Team.php',
            'playercreationtests' => '/tests/PlayerTest.php',
            'services\\datasingleton' => '/services/DataSingleton.php',
            'services\\mongomanager' => '/services/MongoManager.php',
            'services\\randomnames' => '/services/RandomNames.php',
            'teamcreationtests' => '/tests/TeamTest.php'
        );
    }
    $cn = strtolower($class);
    if (isset($classes[$cn])) {
        require dirname(__FILE__) . $classes[$cn];
    }
}
spl_autoload_register('autoloade55fd2f45fe2a784cd73b9b223a34b86', true);
// @codeCoverageIgnoreEnd
