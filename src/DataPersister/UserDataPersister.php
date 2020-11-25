<?php

namespace App\DataPersister;
use App\Entity\User;
use App\DataPersister\UserDataPersister;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        $data->setLibele($data->getLibele());
        $data->setArchivage(true);

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        
        $data->setArchivage(true);

        $this->_entityManager->flush();
    }
}