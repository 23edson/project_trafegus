<?php

namespace Motorista\Form;

use Laminas\Filter\Callback;
use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Form\Element\Select;
use Laminas\InputFilter\InputFilterProviderInterface;

class MotoristaForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('motorista_form');

        // NOME
        $nome = new Element\Text('nome');
        $nome->setLabel('NOME');
        $nome->setLabelAttributes(['class' => 'required']);
        $nome->setAttribute('class', 'form-control');
        $nome->setAttribute('required', 'required');
        $nome->setAttribute('maxlength', '200');
        $this->add($nome);

        // RG
        $rg = new Element\Text('rg');
        $rg->setLabel('RG');
        $rg->setLabelAttributes(['class' => 'required']);
        $rg->setAttribute('class', 'form-control');
        $rg->setAttribute('required', 'required');
        $rg->setAttribute('maxlength', '20');
        $this->add($rg);

        // CPF
        $cpf = new Element\Text('cpf');
        $cpf->setLabel('CPF');
        $cpf->setLabelAttributes(['class' => 'required']);
        $cpf->setAttribute('class', 'form-control');
        $cpf->setAttribute('required', 'required');
        $cpf->setAttribute('pattern', '\d{11}');
        $cpf->setAttribute('title', 'CPF deve conter 11 dígitos');
        $cpf->setAttribute('maxlength', '11');
        $this->add($cpf);

        //telefone
        $telefone = new Element\Text('telefone');
        $telefone->setLabel('TELEFONE');
        $telefone->setAttribute('class', 'form-control');
        $telefone->setAttribute('maxlength', '20');
        $this->add($telefone);

        //veiculos vinculados
        $veiculo = new Select('veiculos');
        $veiculo->setLabel('Veículos');
        $veiculo->setAttributes([
            'class' => 'form-control select2', // utiliza o select2
            'data-placeholder' => 'Selecione um veículo',
            'data-url' => '/veiculos/listar-json', // URL para buscar veículos
            'multiple' => true, // permite múltiplas seleções

        ]);

        $veiculo->setOptions([
            'disable_inarray_validator' => true, //para evitar erro de validação
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

    public function getInputFilterSpecification()
    {
        return [
            'veiculos' => [
                'required' => false,
                'allow_empty' => true,
                'continue_if_empty' => true,
            ],
        ];
    }
}
