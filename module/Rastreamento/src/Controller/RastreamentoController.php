<?php

namespace Rastreamento\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Motorista\Entity\Motorista;

class RastreamentoController extends AbstractActionController
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {

        $motoristas = $this->entityManager
            ->getRepository(Motorista::class)
            ->findAll();

        $dadosMotoristas = [];
        foreach ($motoristas as $motorista) {
            $veiculos = $motorista->getVeiculos()->toArray();

            if (empty($veiculos)) {
                continue; // Pula motoristas sem veículos
            }
            $dadosMotoristas[] = [

                'motorista' =>   $motorista->getId() . ' - ' . $motorista->getNome(),
                //pega apenas um veículo do motorista
                'veiculo' => $veiculos[0]->getPlaca(),
                'posicao' => $this->gerarCoordenadas(),

            ];
        }

        return new ViewModel(['motoristas' => $dadosMotoristas]);
    }

    // Método para gerar coordenadas aleatórias (simulando rastreamento)
    private function gerarCoordenadas(float $raioKm = 3.0): array
    {
        $latCentro = -27.1000;
        $longCentro = -52.6200;
        $raioLat = $raioKm / 111;
        $raioLong = $raioKm / 96;

        $lat = $latCentro + (mt_rand(-1000000, 1000000) / 1000000) * $raioLat;
        $long = $longCentro + (mt_rand(-1000000, 1000000) / 1000000) * $raioLong;

        return ['lat' => round($lat, 6), 'long' => round($long, 6)];
    }
    public function listarJsonAction() {}
}
