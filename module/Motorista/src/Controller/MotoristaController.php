<?php

namespace Motorista\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Motorista\Form\MotoristaForm;
use Motorista\Entity\Motorista;
use Veiculo\Entity\Veiculo;

class MotoristaController extends AbstractActionController
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $repository = $this->entityManager->getRepository(Motorista::class);
        $motoristas = $repository->findAll();

        foreach ($motoristas as $motorista) {
            $dadosMotoristas[] = [
                'id' => $motorista->getId(),
                'nome' => $motorista->getNome(),
                'rg' => $motorista->getRg(),
                'cpf' => $motorista->getCpf(),
                'telefone' => $motorista->getTelefone(),
            ];
        }

        return new ViewModel(['motoristas' => $dadosMotoristas, 'colunas' => $repository->findAll()[0]->getTabulatorConfig()]);
    }

    public function createAction()
    {
        $form = new MotoristaForm();

        try {
            if ($this->getRequest()->isPost()) {
                $data = $this->params()->fromPost();

                $veiculosIds = $this->params()->fromPost('veiculos', []);

                $options = [];
                $veiculos = $this->entityManager->getRepository(Veiculo::class)->findBy([
                    'id' => $veiculosIds
                ]);
                foreach ($veiculos as $veiculo) {
                    $options[$veiculo->getId()] = $veiculo->getModelo();
                }

                $form->get('veiculos')->setValueOptions($options);

                $form->setData($data);

                if ($form->isValid()) {
                    $motorista = new Motorista();
                    $form->setDataToEntity($motorista);

                    // Relaciona os veículos à entidade
                    foreach ($veiculos as $veiculo) {
                        $motorista->addVeiculo($veiculo);
                    }

                    $this->entityManager->persist($motorista);
                    $this->entityManager->flush();
                    $this->flashMessenger()->addSuccessMessage('Motorista adicionado com sucesso!');
                    return $this->redirect()->toRoute('motoristas');
                }
            }
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage('Erro ao criar motorista: ' . $e->getMessage());
            return $this->redirect()->toRoute('motoristas');
        }

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        return $viewModel->setTemplate('motorista/motorista/form');
    }

    public function editAction()
    {

        try {
            $id = (int) $this->params()->fromRoute('id');

            $motorista = $this->entityManager->find(Motorista::class, $id);

            $veiculoSelecionados = [];
            foreach ($motorista->getVeiculos() as $veiculo) {
                $veiculoSelecionados[] = [
                    'id' => $veiculo->getId(),
                    'nome' => $veiculo->getModelo() . ' - ' . $veiculo->getPlaca()
                ];
            }

            $form = new MotoristaForm();
            $form->bind($motorista);
            $form->get('veiculos')->setAttribute('data-selected', json_encode($veiculoSelecionados));

            if ($this->getRequest()->isPost()) {

                $postData = $this->params()->fromPost();

                $options = [];
                $veiculosIds = $postData['veiculos'] ?? [];
                $veiculos = $this->entityManager->getRepository(Veiculo::class)->findBy([
                    'id' => $veiculosIds
                ]);
                foreach ($veiculos as $veiculo) {
                    $options[$veiculo->getId()] = $veiculo->getModelo();
                }

                $form->get('veiculos')->setValueOptions($options);
                $form->setData($postData);

                if ($form->isValid()) {

                    $form->setDataToEntity($motorista);
                    $motorista->setUpdatedAt(new \DateTime());

                    // Remove veículos antigos
                    foreach ($motorista->getVeiculos() as $veiculo) {
                        $motorista->removeVeiculo($veiculo);
                    }

                    // Adiciona os veículos selecionados
                    if (!empty($veiculosIds)) {
                        $veiculos = $this->entityManager->getRepository(Veiculo::class)->findBy([
                            'id' => $veiculosIds
                        ]);

                        foreach ($veiculos as $veiculo) {
                            $motorista->addVeiculo($veiculo);
                        }
                    }

                    $this->entityManager->flush();

                    $this->flashMessenger()->addSuccessMessage('Motorista editado com sucesso!');

                    return $this->redirect()->toRoute('motoristas');
                }
            }
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage('Erro ao editar motorista: ' . $e->getMessage());
            return $this->redirect()->toRoute('motoristas');
        }

        $viewModel = new ViewModel([
            'form' => $form,
            'id' => $id,
            'isEdit' => true,
        ]);

        return $viewModel->setTemplate('motorista/motorista/form');
    }

    public function showAction()
    {

        try {

            $id = (int) $this->params()->fromRoute('id');

            if (!$id) {
                throw new \Exception('ID do motorista não fornecido.');
            }

            $motorista = $this->entityManager->find(Motorista::class, $id);

            if (!$motorista) {
                throw new \Exception('Motorista não encontrado.');
            }
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage('Erro ao exibir motorista: ' . $e->getMessage());
            return $this->redirect()->toRoute('motoristas');
        }

        return new ViewModel([
            'motorista' => $motorista,
        ]);
    }

    public function deleteAction()
    {
        try {
            $id = (int) $this->params()->fromRoute('id');
            $motorista = $this->entityManager->find(Motorista::class, $id);

            if (!$motorista) {
                throw new \Exception('Motorista não encontrado.');
            }

            $this->entityManager->remove($motorista);
            $this->entityManager->flush();
            $this->flashMessenger()->addSuccessMessage('Motorista excluído com sucesso!');
        } catch (\Exception $e) {
            if ($e instanceof \Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException) {
                $this->flashMessenger()->addErrorMessage('Não é possível excluir o motorista, pois ele está vinculado a um ou mais veículos.');
            } else {
                $this->flashMessenger()->addErrorMessage('Erro ao excluir motorista: ' . $e->getMessage());
            }
        }
        return $this->redirect()->toRoute('motoristas', ['action' => 'index']);
    }
}
