<?php

namespace Veiculo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Motorista\Entity\Motorista;

/**
 * @ORM\Entity
 * @ORM\Table(name="veiculos")
 */
class Veiculo
{
    /** @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer") */
    private $id;

    /** @ORM\Column(type="string", length=7, unique=true) */
    private $placa;

    /** @ORM\Column(type="string", length=30, nullable=true) */
    private $renavam;

    /** @ORM\Column(type="string", length=20) */
    private $modelo;

    /** @ORM\Column(type="string", length=20) */
    private $marca;

    /** @ORM\Column(type="integer") */
    private $ano;

    /** @ORM\Column(type="string", length=20) */
    private $cor;

    /** @ORM\Column(type="datetime") */
    private $created_at;

    /** @ORM\Column(type="datetime") */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="Motorista\Entity\Motorista", inversedBy="veiculos")
     * @ORM\JoinTable(name="motoristas_veiculos")
     */
    private $motoristas;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->motoristas = new ArrayCollection();
    }

    public function addMotorista(Motorista $motorista)
    {
        if (!$this->motoristas->contains($motorista)) {
            $this->motoristas->add($motorista);
            $motorista->addVeiculo($this);
        }
    }

    public function removeMotorista(Motorista $motorista)
    {
        if ($this->motoristas->contains($motorista)) {
            $this->motoristas->removeElement($motorista);
            $motorista->removeVeiculo($this);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPlaca()
    {
        return $this->placa;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    public function getRenavam()
    {
        return $this->renavam;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setRenavam($renavam)
    {
        $this->renavam = $renavam;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }
    public function getMarca()
    {
        return $this->marca;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function getCor()
    {
        return $this->cor;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    public function setCor($cor)
    {
        $this->cor = $cor;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    public function exchangeArray(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->placa = $data['placa'] ?? null;
        $this->renavam = $data['renavam'] ?? null;
        $this->modelo = $data['modelo'] ?? null;
        $this->marca = $data['marca'] ?? null;
        $this->ano = $data['ano'] ?? null;
        $this->cor = $data['cor'] ?? null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->getId(),
            'placa' => $this->getPlaca(),
            'renavam' => $this->getRenavam(),
            'modelo' => $this->getModelo(),
            'marca' => $this->getMarca(),
            'ano' => $this->getAno(),
            'cor' => $this->getCor(),
        ];
    }

    public function getTabulatorConfig()
    {
        return [

            ['title' => 'ID', 'field' => 'id', 'width' => 50],
            ['title' => 'Placa', 'field' => 'placa'],
            ['title' => 'Renavam', 'field' => 'renavam'],
            ['title' => 'Modelo', 'field' => 'modelo'],
            ['title' => 'Marca', 'field' => 'marca'],
            ['title' => 'Ano', 'field' => 'ano'],
            ['title' => 'Cor', 'field' => 'cor'],

        ];
    }
}
