<?php

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Motorista\Entity\Motorista;
use Veiculo\Entity\Veiculo;
use ApplicationTest\Utils\TestUtils;

//testes para o controller MotoristaController
class MotoristaControllerTest extends AbstractHttpControllerTestCase
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
        $this->dispatch('/motoristas', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Motorista');
        $this->assertControllerName('motorista\controller\motorista');
        $this->assertMatchedRouteName('motoristas');
        //verfica se a tabela de motoristas foi renderizada
        $this->assertQuery('div#tabela-motoristas');
    }

    public function testCreateWithValidDataRedirects()
    {
        $this->dispatch('/motoristas/create', 'POST', [
            'nome' => 'Motorista Teste',
            'cpf' => TestUtils::gerarNumerosAleatorios(11, 0, 9),
            'rg' => TestUtils::gerarNumerosAleatorios(20, 0, 9),
            'telefone' => TestUtils::gerarNumerosAleatorios(11, 0, 9),
            'veiculos' => []
        ]);

        $this->assertResponseStatusCode(302); //redirect
        $this->assertRedirectTo('/motoristas');

        $this->reset(true);
        $this->dispatch('/motoristas', 'GET');
        // verifica se a mensagem de sucesso foi exibida
        $this->assertQuery('div.alert-success');
    }

    public function testCreateWithInvalidData()
    {
        $this->dispatch('/motoristas/create', 'POST', [
            'nome' => '',
            'cpf' => '',
            'rg' => '',
            'telefone' => '',
            'veiculos' => []
        ]);

        $this->assertResponseStatusCode(200);
        $this->assertQuery('li');
        // verifica se validou o campo nome
        $this->assertQueryContentContains('li', 'O campo nome é obrigatório.');
    }

    public function testEditGetFormLoads()
    {
        $motorista = new Motorista();
        $motorista->setNome('João Teste');
        $motorista->setCpf(TestUtils::gerarNumerosAleatorios(11, 0, 9));
        $motorista->setRg(TestUtils::gerarNumerosAleatorios(20, 0, 9));
        $motorista->setTelefone('31999999999');

        $motorista->setUpdatedAt(new \DateTime());

        // Criando veículo associado
        $veiculo = new Veiculo();
        $veiculo->setPlaca(TestUtils::placaAleatoria());
        $veiculo->setModelo('Worker 17.250');
        $veiculo->setMarca('Volkswagen');
        $veiculo->setAno(2012);
        $veiculo->setCor('Branco');
        $veiculo->setUpdatedAt(new \DateTime());

        // Associar e persistir
        $motorista->addVeiculo($veiculo);

        $entityManager = $this->getApplicationServiceLocator()->get('doctrine.entitymanager.orm_default');
        $entityManager->persist($veiculo);
        $entityManager->persist($motorista);
        $entityManager->flush();

        $this->dispatch('/motoristas/edit/' . $motorista->getId(), 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Motorista');
        $this->assertControllerName('motorista\controller\motorista');
        $this->assertMatchedRouteName('motoristas');
        // verifica se o formulário de motorista foi renderizado
        $this->assertQuery('form#motorista_form');
    }

    public function testEditActionWithValidId()
    {

        $this->dispatch('/motoristas/edit/1', 'POST', [
            'nome' => 'Motorista Teste',
            'cpf' => TestUtils::gerarNumerosAleatorios(11, 0, 9),
            'rg' => TestUtils::gerarNumerosAleatorios(7, 0, 9),
            'telefone' => TestUtils::gerarNumerosAleatorios(11, 0, 9),
            'veiculos' => []
        ]);

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/motoristas');

        $this->reset(true);
        $this->dispatch('/motoristas', 'GET');
        // verifica se a mensagem de sucesso foi exibida
        $this->assertQuery('div.alert-success'); // ajuste conforme seu HTML
    }

    public function testEditWithInvalidData()
    {

        $motorista = new Motorista();
        $motorista->setNome('João Teste 2');
        $motorista->setCpf(TestUtils::gerarNumerosAleatorios(11, 0, 9));
        $motorista->setRg(TestUtils::gerarNumerosAleatorios(20, 0, 9));
        $motorista->setTelefone('31999999999');
        $motorista->setUpdatedAt(new \DateTime());

        $entityManager = $this->getApplicationServiceLocator()->get('doctrine.entitymanager.orm_default');
        $entityManager->persist($motorista);
        $entityManager->flush();


        $this->dispatch('/motoristas/edit/' . $motorista->getId(), 'POST', [
            'nome' => '',
            'cpf' => '',
            'rg' => '',
            'telefone' => '',
            'veiculos' => []
        ]);

        $this->assertResponseStatusCode(200);
        $this->assertQuery('li');
        // verifica se validou o campo nome
        $this->assertQueryContentContains('li', 'O campo nome é obrigatório.');
    }

    public function testShowActionWithValidIdDisplaysMotorista()
    {

        $motorista = new Motorista();
        $motorista->setNome('João Teste 2');
        $motorista->setCpf(TestUtils::gerarNumerosAleatorios(11, 0, 9));
        $motorista->setRg(TestUtils::gerarNumerosAleatorios(20, 0, 9));
        $motorista->setTelefone('31999999999');
        $motorista->setUpdatedAt(new \DateTime());

        $entityManager = $this->getApplicationServiceLocator()->get('doctrine.entitymanager.orm_default');
        $entityManager->persist($motorista);
        $entityManager->flush();

        $this->dispatch('/motoristas/show/' . $motorista->getId(), 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertMatchedRouteName('motoristas');
        // verifica se o motorista foi exibido
        $this->assertQuery('ul.list-group');
    }

    public function testShowActionWithInvalidId()
    {
        //motorista não existe
        $this->dispatch('/motoristas/show/9999', 'GET');

        $this->assertResponseStatusCode(302); // redirect
        $this->assertRedirectTo('/motoristas');
        $this->reset(true);
        $this->dispatch('/motoristas', 'GET');
        $this->assertQuery('div.alert-danger');
    }

    public function testDeleteActionWithValidId()
    {
        $motorista = new Motorista();
        $motorista->setNome('João Teste 2');
        $motorista->setCpf(TestUtils::gerarNumerosAleatorios(11, 0, 9));
        $motorista->setRg(TestUtils::gerarNumerosAleatorios(20, 0, 9));
        $motorista->setTelefone('31999999999');
        $motorista->setUpdatedAt(new \DateTime());

        $entityManager = $this->getApplicationServiceLocator()->get('doctrine.entitymanager.orm_default');
        $entityManager->persist($motorista);
        $entityManager->flush();
        $this->dispatch('/motoristas/delete/' . $motorista->getId(), 'DELETE');

        $this->assertResponseStatusCode(302); // redirect
        $this->assertRedirectTo('/motoristas');
        $this->reset(true);
        $this->dispatch('/motoristas', 'GET');
        $this->assertQuery('div.alert-success');
    }

    public function testDeleteActionWithInvalidId()
    {
        //motorista não existe
        $this->dispatch('/motoristas/delete/9999', 'DELETE');

        $this->assertResponseStatusCode(302); // redirect
        $this->assertRedirectTo('/motoristas');
        $this->reset(true);
        $this->dispatch('/motoristas', 'GET');
        $this->assertQuery('div.alert-danger');
    }
}
