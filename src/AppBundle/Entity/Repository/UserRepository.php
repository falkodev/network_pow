<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\User;
use HireVoice\Neo4j\Repository;

class UserRepository extends Repository
{
    public function getAllUnconfirmedAccount($since)
    {
        return $this->createCypherQuery()
            ->query(sprintf("MATCH (n:User) WHERE n.creationDate > '%s' AND n.status = %d RETURN n", $since, User::STATUS_AWAITING))
            ->getList()
        ;
    }
}
