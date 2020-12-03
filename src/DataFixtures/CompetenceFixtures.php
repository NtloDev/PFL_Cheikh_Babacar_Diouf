<?php

namespace App\DataFixtures;

use App\Entity\NiveauDevaluation;
use ContainerDsYugym\getNiveauDevaluationRepositoryService;
use Faker;
use App\Entity\Competence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompetenceFixtures extends Fixture
{
    public static function getReferenceKey($p)
    {
        return sprintf('Competence_%s',$p);
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($p=0; $p<13 ;$p++)
        {
            $competence = new Competence();
            $competence->setLibelle('Competence'.$p)
                ->setDescription('Description'.$p)
                ->setArchive(0);
            $this->addReference(self::getReferenceKey($p),$competence);

            $manager->persist($competence);
            for ($n=1;$n<=3 ;$n++)
            {
                $niveau = new NiveauDevaluation();
                $niveau->setLibelle('niveau'.$n)
                       ->setCriteres('Criteres'.$n)
                       ->setActions('Action'.$n)
                       ->addCompetence($competence);
                $manager->persist($niveau);
            }

        }

        $manager->flush();
    }
}
