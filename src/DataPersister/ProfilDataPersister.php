<?php

namespace App\DataPersister;
use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use App\DataPersister\ProfilDataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class ProfilDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof Profil;
    }

    public function persist($data, array $context = [])
    {
        $data->setLibelle($data->getLibelle());
        $data->setArchivage(true);

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setArchivage(true);
        //dd($data);

        $users = $data->getUsers();
        foreach ($users as $user) {

           $user->setArchivage(true);
        }

        $this->_entityManager->flush();
    }
}