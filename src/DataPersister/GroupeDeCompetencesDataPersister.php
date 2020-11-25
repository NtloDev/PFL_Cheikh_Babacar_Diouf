<?php

namespace App\DataPersister;
use App\Entity\GroupeDeCompetences;
use Doctrine\ORM\EntityManagerInterface;
use App\DataPersister\GroupeDeCompetencesDataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class GroupeDeCompetencesDataPersister implements ContextAwareDataPersisterInterface
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
return $data instanceof GroupeDeCompetences;
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