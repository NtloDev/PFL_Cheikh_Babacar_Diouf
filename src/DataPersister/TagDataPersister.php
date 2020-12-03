<?php

namespace App\DataPersister;
use App\Entity\Tag;
use App\DataPersister\TagDataPersister;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class TagDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof Tag;
    }

    public function persist($data, array $context = [])
    {
        $data->setLibelLe($data->getLibelLe());
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