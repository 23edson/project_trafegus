<?php

namespace Motorista\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Veiculo\Entity\Veiculo;

/**
 * @ORM\Entity
 * @ORM\Table(name="motoristas")
 */
class Motorista
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nome;
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $rg;
    /**
     * @ORM\Column(type="string", length=14)
     */
    private $cpf;
    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telefone;

    /** @ORM\Column(type="datetime") */
    private $created_at;

    /** @ORM\Column(type="datetime") */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="Veiculo\Entity\Veiculo", mappedBy="motoristas")
     */
    private $veiculos;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->veiculos = new ArrayCollection();
    }

    public function addVeiculo(Veiculo $veiculo)
    {
        if (!$this->veiculos->contains($veiculo)) {
            $this->veiculos->add($veiculo);
            $veiculo->addMotorista($this);
        }
    }

    public function removeVeiculo(Veiculo $veiculo)
    {
        if ($this->veiculos->contains($veiculo)) {
            $this->veiculos->removeElement($veiculo);
            $veiculo->removeMotorista($this);
        }
    }
    // Getters and Setters
    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getVeiculos()
    {
        return $this->veiculos;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    public function exchangeArray(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->nome = $data['nome'] ?? null;
        $this->rg = $data['rg'] ?? null;
        $this->cpf = $data['cpf'] ?? null;
        $this->telefone = $data['telefone'] ?? null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'rg' => $this->getRg(),
            'cpf' => $this->getCpf(),
            'telefone' => $this->getTelefone(),
        ];
    }

    public static function getTabulatorConfig()
    {
        return [

            ['title' => 'ID', 'field' => 'id', 'width' => 50],
            ['title' => 'Nome', 'field' => 'nome'],
            ['title' => 'RG', 'field' => 'rg'],
            ['title' => 'CPF', 'field' => 'cpf'],
            ['title' => 'Telefone', 'field' => 'telefone'],

        ];
    }
}
