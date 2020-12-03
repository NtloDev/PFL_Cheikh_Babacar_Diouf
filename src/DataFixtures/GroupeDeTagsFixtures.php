<?php

namespace App\DataFixtures;

use App\Entity\GroupeDeTags;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupeDeTagsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $grptags= New GroupeDeTags();
        $grptags->setLibelle($faker->text);
        for($j=0 ;$j<=5 ;$j++)
        {
            $tag[] = $this->getReference(TagFixtures::getReferencekey($j));
            $grptags->addTag($faker->unique(true)->randomElement($tag));
        }

        $manager->persist($grptags);

        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            TagFixtures::Class,
        );
    }
}
