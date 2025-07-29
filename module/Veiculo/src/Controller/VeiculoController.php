<?php

namespace Veiculo\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Veiculo\Form\VeiculoForm;
use Veiculo\Entity\Veiculo;

class VeiculoController extends AbstractActionController
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $repository = $this->entityManager->getRepository(Veiculo::class);
        $veiculos = $repository->findAll();

        foreach ($veiculos as $veiculo) {
            $dadosVeiculos[] = [
                'id' => $veiculo->getId(),
                'modelo' => $veiculo->getModelo(),
                'placa' => $veiculo->getPlaca(),
                'marca' => $veiculo->getMarca(),
                'ano' => $veiculo->getAno(),
                'cor' => $veiculo->getCor(),
                'renavam' => $veiculo->getRenavam(),
            ];
        }
        return new ViewModel(['veiculos' => $dadosVeiculos, 'colunas' => Veiculo::getTabulatorConfig()]);
    }

    // Método para listar veículos via api
    public function listarJsonAction()
    {
        $dados = [];
        try {
            $veiculos = $this->entityManager->getRepository(Veiculo::class)->findBy([], ['modelo' => 'ASC']);

            foreach ($veiculos as $veiculo) {
                $dados[] = [
                    'id' => $veiculo->getId(),
                    'nome' => $veiculo->getModelo() . ' - ' . $veiculo->getPlaca(),
                ];
            }
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage('Erro ao listar veículos: ' . $e->getMessage());
            return $this->redirect()->toRoute('veiculos');
        }

        return new JsonModel($dados);
    }

    public function createAction()
    {
        $form = new VeiculoForm();

        try {
            /** @var \Laminas\Http\PhpEnvironment\Request $request */
            $request = $this->getRequest();
            if ($request->isPost()) {

                $data = $request->getPost();

                $form->setData($data);
                if ($form->isValid()) {
                    $veiculo = new Veiculo();
                    $form->setDataToEntity($veiculo); // você pode criar esse método no form
                    $this->entityManager->persist($veiculo);
                    $this->entityManager->flush();

                    $this->flashMessenger()->addSuccessMessage('Veículo salvo com sucesso!');
                    return $this->redirect()->toRoute('veiculos');
                }
            }
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage('Erro ao salvar veículo: ' . $e->getMessage());
        }

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        return $viewModel->setTemplate('veiculo/veiculo/form');
    }

    public function editAction()
    {
        try {
            $id = (int) $this->params()->fromRoute('id');

            $veiculo = $this->entityManager->find(Veiculo::class, $id);

            if (!$veiculo) {
                throw new \Exception('Veículo não encontrado.');
            }

            $form = new VeiculoForm();
            $form->bind($veiculo);

            /** @var \Laminas\Http\PhpEnvironment\Request $request */
            $request = $this->getRequest();
            if ($request->isPost()) {
                $data = $request->getPost();
                $form->setData($data);

                if ($form->isValid()) {

                    $veiculo->setUpdatedAt(new \DateTime());
                    $this->entityManager->flush();

                    $this->flashMessenger()->addSuccessMessage('Veículo alterado com sucesso!');

                    return $this->redirect()->toRoute('veiculos');
                }
            }
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage('Erro ao salvar o veículo: ' . $e->getMessage());
        }

        $viewModel = new ViewModel([
            'form' => $form,
            'id' => $id,
            'isEdit' => true,
        ]);

        return $viewModel->setTemplate('veiculo/veiculo/form');
    }

    public function showAction()
    {
        try {

            $id = (int) $this->params()->fromRoute('id');

            if (!$id) {
                throw new \Exception('ID do veículo não fornecido.');
            }

            $veiculo = $this->entityManager->find(Veiculo::class, $id);

            if (!$veiculo) {
                throw new \Exception('Veículo não encontrado.');
            }
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage('Erro ao exibir veículo: ' . $e->getMessage());
            return $this->redirect()->toRoute('veiculos');
        }

        return new ViewModel([
            'veiculo' => $veiculo,
        ]);
    }

    public function deleteAction()
    {
        try {

            $id = (int) $this->params()->fromRoute('id');
            $veiculo = $this->entityManager->find(Veiculo::class, $id);

            if (!$veiculo) {
                throw new \Exception('Veículo não encontrado.');
            }

            $this->entityManager->remove($veiculo);
            $this->entityManager->flush();

            $this->flashMessenger()->addSuccessMessage('Veículo excluído com sucesso!');
        } catch (\Exception $e) {
            if ($e instanceof \Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException) {
                $this->flashMessenger()->addErrorMessage('Não é possível excluir o veículo, pois ele está vinculado a um motorista.');
            } else {
                $this->flashMessenger()->addErrorMessage('Erro ao excluir veículo: ' . $e->getMessage());
            }
        }
        return $this->redirect()->toRoute('veiculos', ['action' => 'index']);
    }
}
