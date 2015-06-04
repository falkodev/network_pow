<?php

namespace AppBundle\Manager;

use HireVoice\Neo4j\EntityManager;
use HireVoice\Neo4j\Configuration;

class GraphManager extends EntityManager
{
    public function __construct($host, $port, $proxy_dir, $username = null, $password = null,  $debug = false)
    {
        $configuration = new Configuration([
            'host'      => $host,
            'port'      => $port,
            'proxy_dir' => $proxy_dir,
            'username'  => $username,
            'password'  => $password,
            'debug'     => $debug,
        ]);

        parent::__construct($configuration);
    }
}
