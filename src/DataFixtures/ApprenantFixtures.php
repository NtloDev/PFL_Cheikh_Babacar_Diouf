<?php

namespace App\DataFixtures;

use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use App\Entity\Apprenant;
use App\Entity\Profil;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
         
        $faker = Faker\Factory::create('fr_FR');
            $appr = new Apprenant();
            $harsh = $this->encoder->encodePassword($appr, 'passer');
            $appr->setProfil($this->getReference(ProfileFixtures::APPRENANT_REFERENCE));
            $appr->setUsername($faker->unique()->randomElement(['Laye']));
            $appr->setPassword($faker->randomElement([ $harsh, $harsh, $harsh, $harsh]));
            $appr->setPrenom($faker->randomElement(['babacar','aminata','Oumar','Laye']));
            $appr->setNom($faker->randomElement(['Diouf','Lo','Anne', 'Sall']));
            $appr->setEmail($faker->randomElement(['babacar@sa.sn','aminata@sa.sn','Oumar@sa.sn','laye@sa.sn']));
            $appr->setTelephone($faker->randomElement(['778458574','778548596','774859652','777777777']));
            $appr->setArchivage($faker->randomElement([0]));
            $appr->setGenre($faker->randomElement(['F','M','F','F']));
            $manager->persist($appr);

        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            UserFixtures::Class,
        );
    }
}
