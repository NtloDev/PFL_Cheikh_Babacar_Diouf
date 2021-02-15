<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Entity\Competence;
use App\Entity\GroupeDeCompetences;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function sprintf;

class GroupeDeCompetenceFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceKey($p)
    {
        return sprintf('GroupeDeCompetence_%s',$p);
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($j=0; $j<3 ;$j++) {
            $competence[] = $this->getReference(CompetenceFixtures::getReferencekey($j));
        }
        for ($i=0; $i<5 ;$i++) {
            $groupedecompetence = new GroupeDeCompetences();
            $this->addReference(self::getReferenceKey($i),$groupedecompetence);
            $groupedecompetence->setLibelle($faker->text)
                               ->setDescription($faker->realtext())
                               ->setArchive(0);
            for($k=1; $k<=3 ; $k++)
            {
                $groupedecompetence->addCompetence($faker->unique(true)->randomElement($competence));
            }

            $manager->persist($groupedecompetence);
        }


        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            CompetenceFixtures::Class,
        );
    }
}
