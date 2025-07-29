<?php

namespace Rastreamento\Form;

use Laminas\Form\Form;

class RastreamentoForm extends Form
{
    public function __construct()
    {
        parent::__construct('rastreamento_form');
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
