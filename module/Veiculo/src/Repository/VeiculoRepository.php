<?php

namespace Veiculo\Repository;

use Doctrine\ORM\EntityRepository;

class VeiculoRepository extends EntityRepository
{
    public function findAllVeiculos()
    {
        return $this->findBy([], ['placa' => 'ASC']);
    }

    public function findVeiculoByPlaca($placa)
    {
        return $this->findOneBy(['placa' => $placa]);
    }
}
