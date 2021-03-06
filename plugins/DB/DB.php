<?php

namespace Minion\Plugins;

class DBPlugin extends \Minion\Plugin {

    private $Initialized;
    private $DB = false;

    private function init () {
        if (!$this->DB) {
            $this->DB = new \PDO(
                $this->conf('DSN'),
                $this->conf('Username'),
                $this->conf('Password'),
                array(
                    \PDO::ATTR_PERSISTENT => true,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                )
            );
        }
    }

    public function &getDB () {
        $this->init();
        return $this->DB;
    }

}

$DB = new DBPlugin(
    'DB',
    'Database connection manager.',
    'Ryan N. Freebern / ryan@freebern.org'
);

return $DB
    ->on('before-loop', function (&$data) use ($DB) {
        $DB->Minion->State['DB'] = $DB->getDB();
        $DB->Minion->State['DBType'] = $DB->conf('DB');
    });

?>
