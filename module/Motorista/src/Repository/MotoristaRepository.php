<?php

namespace Motorista\Repository;

use Doctrine\ORM\EntityRepository;

class MotoristaRepository extends EntityRepository
{
    public function findAllMotoristas()
    {
        return $this->findBy([], ['nome' => 'ASC']);
    }

    public function findMotoristaByNome($nome)
    {
        return $this->findOneBy(['nome' => $nome]);
    }
}
