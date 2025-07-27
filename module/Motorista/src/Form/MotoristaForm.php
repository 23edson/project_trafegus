<?php

namespace Motorista\Form;

use Laminas\Filter\Callback;
use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Form\Element\Select;

class MotoristaForm extends Form
{
    public function __construct()
    {
        parent::__construct('motorista_form');

        // NOME
        $nome = new Element\Text('nome');
        $nome->setLabel('NOME');
        $nome->setAttribute('class', 'form-control');
        $this->add($nome);

        // RG
        $rg = new Element\Text('rg');
        $rg->setLabel('RG');
        $rg->setAttribute('class', 'form-control');
        $this->add($rg);

        // CPF
        $cpf = new Element\Text('cpf');
        $cpf->setLabel('CPF');
        $cpf->setAttribute('class', 'form-control');
        $this->add($cpf);

        //telefone
        $telefone = new Element\Text('telefone');
        $telefone->setLabel('TELEFONE');
        $telefone->setAttribute('class', 'form-control');
        $this->add($telefone);

        //veiculos vinculados
        $veiculo = new Select('veiculos');
        $veiculo->setLabel('Veículo');
        $veiculo->setAttributes([
            'class' => 'form-control select2', // utiliza o select2
            'data-placeholder' => 'Selecione um veículo',
            'data-url' => '/veiculos/listar-json', // URL para buscar veículos
            'multiple' => true,
            'required' => false,
        ]);
        $veiculo->setEmptyOption('Selecione um veículo');
        $veiculo->setValueOptions([]); // será preenchido via AJAX
        $this->add($veiculo);
    }

    public function setDataToEntity($motorista)
    {
        $data = $this->getData();
        foreach ($data as $key => $value) {
            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($motorista, $setter)) {
                $motorista->$setter($value);
            }
        }
    }
}
