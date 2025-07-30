<?php

namespace Veiculo\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Validator\NotEmpty;

class VeiculoForm extends Form implements \Laminas\InputFilter\InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('veiculo_form');

        // PLACA
        $placa = new Element\Text('placa');
        $placa->setLabel('Placa');
        $placa->setLabelAttributes(['class' => 'required']);
        $placa->setAttribute('class', 'form-control');
        $placa->setAttribute('required', 'required');

        $placa->setAttribute('maxlength', '7');
        $this->add($placa);

        // RENAVAM
        $renavam = new Element\Text('renavam');
        $renavam->setLabel('RENAVAM');
        $renavam->setAttribute('class', 'form-control');
        $renavam->setAttribute('maxlength', '30');
        $this->add($renavam);

        // MODELO
        $modelo = new Element\Text('modelo');
        $modelo->setLabel('Modelo');
        $modelo->setLabelAttributes(['class' => 'required']);
        $modelo->setAttribute('class', 'form-control');
        $modelo->setAttribute('required', 'required');
        $modelo->setAttribute('maxlength', '20');
        $this->add($modelo);

        // MARCA
        $marca = new Element\Text('marca');
        $marca->setLabel('Marca');
        $marca->setLabelAttributes(['class' => 'required']);
        $marca->setAttribute('class', 'form-control');
        $marca->setAttribute('required', 'required');
        $marca->setAttribute('maxlength', '20');
        $this->add($marca);

        // ANO
        $ano = new Element\Text('ano');
        $ano->setLabel('Ano');
        $ano->setLabelAttributes(['class' => 'required']);
        $ano->setAttribute('class', 'form-control');
        $ano->setAttribute('required', 'required');
        $ano->setAttribute('title', 'Ano deve ser um número');
        $this->add($ano);

        // COR
        $cor = new Element\Text('cor');
        $cor->setLabel('Cor');
        $cor->setLabelAttributes(['class' => 'required']);
        $cor->setAttribute('class', 'form-control');
        $cor->setAttribute('required', 'required');
        $cor->setAttribute('pattern', '[A-Za-z\s]+'); // Validação
        $cor->setAttribute('title', 'A cor deve conter apenas letras e espaços');
        $cor->setAttribute('placeholder', 'Ex: Vermelho, Azul, Preto');
        $cor->setAttribute('maxlength', '20');
        $this->add($cor);
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

    public function getInputFilterSpecification()
    {
        return [
            'placa' => [
                'allow_empty' => false,
                'required' => true,
                'validators' => [
                    ['name' => NotEmpty::class, 'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'O campo placa é obrigatório.',
                        ],
                    ]],
                ],
            ],
            'modelo' => [
                'allow_empty' => false,
                'required' => true,
                'validators' => [
                    ['name' => NotEmpty::class, 'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'O campo modelo é obrigatório.',
                        ],
                    ]],
                ],
            ],
            'marca' => [
                'allow_empty' => false,
                'required' => true,
                'validators' => [
                    ['name' => NotEmpty::class, 'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'O campo marca é obrigatório.',
                        ],
                    ]],
                ],
            ],
            'ano' => [
                'required' => true,
                'allow_empty' => false,
                'continue_if_empty' => false,
                'validators' => [
                    [
                        'name' => \Laminas\Validator\NotEmpty::class,
                        'options' => [
                            'messages' => [
                                \Laminas\Validator\NotEmpty::IS_EMPTY => 'O campo ano é obrigatório.',
                            ],
                        ],
                    ],
                    [
                        'name' => \Laminas\Validator\Digits::class,
                        'options' => [
                            'messages' => [
                                \Laminas\Validator\Digits::NOT_DIGITS => 'Informe apenas números.',
                            ]
                        ]
                    ],
                ],
            ],
            'cor' => [
                'allow_empty' => false,
                'required' => true,
                'validators' => [
                    ['name' => NotEmpty::class, 'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'O campo cor é obrigatório.',
                        ],
                    ]],
                ],
            ],
        ];
    }
}
