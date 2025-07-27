<?php

namespace Veiculo\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Form\Element\Select;

class VeiculoForm extends Form
{
    public function __construct()
    {
        parent::__construct('veiculo_form');

        // RENAVAM
        $renavam = new Element\Text('renavam');
        $renavam->setLabel('RENAVAM');
        $renavam->setAttribute('class', 'form-control');
        $this->add($renavam);

        // MARCA
        $marca = new Element\Text('marca');
        $marca->setLabel('Marca');
        $marca->setAttribute('class', 'form-control');
        $this->add($marca);

        // MODELO
        $modelo = new Element\Text('modelo');
        $modelo->setLabel('Modelo');
        $modelo->setAttribute('class', 'form-control');
        $this->add($modelo);

        // PLACA
        $placa = new Element\Text('placa');
        $placa->setLabel('Placa');
        $placa->setAttribute('class', 'form-control');
        $this->add($placa);

        // COR
        $cor = new Element\Text('cor');
        $cor->setLabel('Cor');
        $cor->setAttribute('class', 'form-control');
        $this->add($cor);

        // ANO
        $ano = new Element\Text('ano');
        $ano->setLabel('Ano');
        $ano->setAttribute('class', 'form-control');
        $this->add($ano);
    }

    public function setDataToEntity($veiculo)
    {
        $data = $this->getData();
        foreach ($data as $key => $value) {
            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($veiculo, $setter)) {
                $veiculo->$setter($value);
            }
        }
    }
}
