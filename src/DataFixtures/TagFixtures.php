<?php

namespace App\DataFixtures;

use App\Entity\GroupeDeTags;
use Faker;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function sprintf;

class TagFixtures extends Fixture
{
    public static function getReferenceKey($p)
    {
        return sprintf('Tag_%s',$p);
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i=0; $i<=5 ; $i++)
        {
            $tag= New Tag();
            $tag->setLibelle($faker->text);
            $this->addReference(self::getReferenceKey($i),$tag);
            $manager->persist($tag);
        }


        $manager->flush();
    }
}
