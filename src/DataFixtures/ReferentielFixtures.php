<?php

namespace App\DataFixtures;
use App\Entity\Referentiel;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function sprintf;

class ReferentielFixtures extends Fixture
{
    public static function getReferenceKey($p)
    {
        return sprintf('Referentiel_%s',$p);
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($p = 0; $p < 4; $p++) {
            $referentiel = new Referentiel();
            $referentiel->setPresentation('Presentation' . $p)
                ->setProgramme('Programme' . $p)
                ->setCriteresDevaluation('CriteresDevaluation' . $p)
                ->setCriteresDadmission('CriteresDadmission' . $p)
                ->setArchive(0);
            $this->addReference(self::getReferenceKey($p),$referentiel);




            $manager->persist($referentiel);

        }

        $manager->flush();
    }
}
