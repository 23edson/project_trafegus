<?php

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Veiculo\Entity\Veiculo;
use ApplicationTest\Utils\TestUtils;

//testes para o controller VeiculoController
class VeiculoControllerTest extends AbstractHttpControllerTestCase
{

    protected function setUp(): void
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/veiculos', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Veiculo');
        $this->assertControllerName('veiculo\controller\veiculo');
        $this->assertMatchedRouteName('veiculos');
        $this->assertQuery('div#tabela-veiculos');
    }

    public function testCreateWithValidDataRedirects()
    {
        $this->dispatch('/veiculos/create', 'POST', [
            'placa' => TestUtils::placaAleatoria(),
            'modelo' => 'Worker 17.250',
            'marca' => 'Volkswagen',
            'ano' => 2012,
            'cor' => 'Branco',
        ]);

        $this->assertResponseStatusCode(302); //redirect
        $this->assertRedirectTo('/veiculos');

        $this->reset(true);
        $this->dispatch('/veiculos', 'GET');
        // verifica se a mensagem de sucesso foi exibida
        $this->assertQuery('div.alert-success');
    }

    public function testCreateWithInvalidData()
    {
        $this->dispatch('/veiculos/create', 'POST', [
            'placa' => '',
            'modelo' => 'Worker 17.250',
            'marca' => 'Volkswagen',
            'ano' => 2000,
            'cor' => 'Branco',
        ]);

        $this->assertResponseStatusCode(200);
        $this->assertQuery('li');
        //verifica se validadou o campo placa
        $this->assertQueryContentContains('li', 'O campo placa é obrigatório.');
    }

    public function testEditGetFormLoads()
    {

        // Criando veículo associado
        $veiculo = new Veiculo();
        $veiculo->setPlaca(TestUtils::placaAleatoria());
        $veiculo->setModelo('Worker 17.250');
        $veiculo->setMarca('Volkswagen');
        $veiculo->setAno(2012);
        $veiculo->setCor('Branco');
        $veiculo->setUpdatedAt(new \DateTime());

        $entityManager = $this->getApplicationServiceLocator()->get('doctrine.entitymanager.orm_default');
        $entityManager->persist($veiculo);
        $entityManager->flush();

        $this->dispatch('/veiculos/edit/' . $veiculo->getId(), 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Veiculo');
        $this->assertControllerName('veiculo\controller\veiculo');
        $this->assertMatchedRouteName('veiculos');
        // Verifica se o formulário foi carregado corretamente
        $this->assertQuery('form#veiculo_form');
    }

    public function testEditWithValidDataDirects()
    {
        $this->dispatch('/veiculos/edit/1', 'POST', [
            'placa' => TestUtils::placaAleatoria(),
            'modelo' => 'Worker 17.250',
            'marca' => 'Volkswagen',
            'ano' => 2012,
            'cor' => 'Branco',
        ]);

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/veiculos');

        $this->reset(true);
        $this->dispatch('/veiculos', 'GET');
        // verifica se a mensagem de sucesso foi exibida
        $this->assertQuery('div.alert-success');
    }

    public function testEditWithInvalidData()
    {

        $veiculo = new Veiculo();
        $veiculo->setPlaca(TestUtils::placaAleatoria());
        $veiculo->setModelo('Worker 17.250');
        $veiculo->setMarca('Volkswagen');
        $veiculo->setAno(2012);
        $veiculo->setCor('Branco');
        $veiculo->setUpdatedAt(new \DateTime());

        $entityManager = $this->getApplicationServiceLocator()->get('doctrine.entitymanager.orm_default');
        $entityManager->persist($veiculo);
        $entityManager->flush();


        $this->dispatch('/veiculos/edit/' . $veiculo->getId(), 'POST', [
            'placa' => '',
            'modelo' => '',
            'marca' => '',
            'ano' => '',
            'cor' => ''
        ]);

        $this->assertResponseStatusCode(200);
        $this->assertQuery('li');
        // verifica se validou o campo placa
        $this->assertQueryContentContains('li', 'O campo placa é obrigatório.');
    }

    public function testShowActionWithValidIdDisplaysVeiculo()
    {

        $veiculo = new Veiculo();
        $veiculo->setPlaca(TestUtils::placaAleatoria());
        $veiculo->setModelo('Worker 17.250');
        $veiculo->setMarca('Volkswagen');
        $veiculo->setAno(2012);
        $veiculo->setCor('Branco');
        $veiculo->setUpdatedAt(new \DateTime());

        $entityManager = $this->getApplicationServiceLocator()->get('doctrine.entitymanager.orm_default');
        $entityManager->persist($veiculo);
        $entityManager->flush();

        $this->dispatch('/veiculos/show/' . $veiculo->getId(), 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertMatchedRouteName('veiculos');
        $this->assertQuery('ul.list-group');
    }

    public function testShowActionWithInvalidId()
    {
        //veiculo não existe
        $this->dispatch('/veiculos/show/9999', 'GET');

        $this->assertResponseStatusCode(302); // redirect
        $this->assertRedirectTo('/veiculos');
        $this->reset(true);
        $this->dispatch('/veiculos', 'GET');
        // verifica se a mensagem de erro foi exibida
        $this->assertQuery('div.alert-danger');
    }

    public function testDeleteActionWithValidId()
    {
        $veiculo = new Veiculo();
        $veiculo->setPlaca(TestUtils::placaAleatoria());
        $veiculo->setModelo('Worker 17.250');
        $veiculo->setMarca('Volkswagen');
        $veiculo->setAno(2012);
        $veiculo->setCor('Branco');
        $veiculo->setUpdatedAt(new \DateTime());

        $entityManager = $this->getApplicationServiceLocator()->get('doctrine.entitymanager.orm_default');
        $entityManager->persist($veiculo);
        $entityManager->flush();
        $this->dispatch('/veiculos/delete/' . $veiculo->getId(), 'DELETE');

        $this->assertResponseStatusCode(302); // redirect
        $this->assertRedirectTo('/veiculos');
        $this->reset(true);
        $this->dispatch('/veiculos', 'GET');
        $this->assertQuery('div.alert-success');
    }

    public function testDeleteActionWithInvalidId()
    {
        //veiculo não existe
        $this->dispatch('/veiculos/delete/9999', 'DELETE');

        $this->assertResponseStatusCode(302); // redirect
        $this->assertRedirectTo('/veiculos');
        $this->reset(true);
        $this->dispatch('/veiculos', 'GET');
        $this->assertQuery('div.alert-danger');
    }
}
