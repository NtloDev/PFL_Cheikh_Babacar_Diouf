<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Groupe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function sprintf;

class GroupeFixtures extends Fixture
{
    public static function getReferenceKey($p)
    {
        return sprintf('Groupe_%s',$p);
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $j=1;

            $Groupe = new Groupe();
            $Groupe->setLibelle('Groupe Principal')
                ->setArchive(0)
                ->setType('Principal');
            $this->setReference(self::getReferenceKey($j),$Groupe);

            $manager->persist($Groupe);


        $manager->flush();
    }
}
