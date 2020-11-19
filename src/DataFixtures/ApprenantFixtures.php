<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Profil;
use App\Entity\Apprenant;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

abstract class ApprenantFixtures extends Fixture implements DependentFixtureInterface
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
            $appr->setUsername($faker->unique()->randomElement(['babacar','aminata','Oumar','Laye']));
            $appr->setPassword($faker->randomElement([ $harsh, $harsh, $harsh, $harsh]));
            $appr->setPrenom($faker->randomElement(['babacar','aminata','Oumar','Laye']));
            $appr->setNom($faker->randomElement(['Diouf','Lo','Anne', 'Sall']));
            $appr->setEmail($faker->randomElement(['babacar@sa.sn','aminata@sa.sn','Oumar@sa.sn','laye@sa.sn']));
            $appr->setTelephone($faker->randomElement(['778458574','778548596','774859652','777777777']));
            $appr->setArchive($faker->randomElement(['true','false','true','false']));
            $appr->setGenre($faker->randomElement(['F','M','F','F']));
            $manager->persist($appr);

        $manager->flush();
    }
}