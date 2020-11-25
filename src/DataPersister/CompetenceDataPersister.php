<?php

namespace App\DataPersister;
use App\Entity\Competence;
use Doctrine\ORM\EntityManagerInterface;
use App\DataPersister\CompetenceDataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CompetenceDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->_entityManager = $entityManager;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Competence;
    }

    public function persist($data, array $context = [])
    {
        $data->setLibelle($data->getLibelle());
        $data->setArchive(true);

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setArchive(true);
        //dd($data);

        $this->_entityManager->flush();
    }
}