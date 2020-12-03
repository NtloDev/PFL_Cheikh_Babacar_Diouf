<?php

namespace App\DataPersister;
use App\Entity\GroupeDeTags;
use App\DataPersister\GroupeDeTagsDataPersister;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class GroupeDeTagsDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof GroupeDeTags;
    }

    public function persist($data, array $context = [])
    {
        $data->setLibelle($data->getLibelle());
        $data->setArchive(false);

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {

        $data->setArchive(true);

        $this->_entityManager->flush();
    }
}