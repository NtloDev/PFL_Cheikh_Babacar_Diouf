<?php

namespace App\DataFixtures;

use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Profil;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

abstract class AdminFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
         
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create('fr_FR');
            $admin = new Admin();
            $harsh = $this->encoder->encodePassword($admin, 'passer');
            $admin->setProfil($this->getReference(ProfileFixtures::ADMIN_REFERENCE));
            $admin->setUsername($faker->unique()->randomElement(['babacar','aminata','Oumar','Laye']));
            $admin->setPassword($faker->randomElement([ $harsh, $harsh, $harsh, $harsh]));
            $admin->setPrenom($faker->randomElement(['babacar','aminata','Oumar','Laye']));
            $admin->setNom($faker->randomElement(['Diouf','Lo','Anne', 'Sall']));
            $admin->setEmail($faker->randomElement(['babacar@sa.sn','aminata@sa.sn','Oumar@sa.sn','laye@sa.sn']));
            $admin->setTelephone($faker->randomElement(['778458574','778548596','774859652','777777777']));
            $admin->setArchive($faker->randomElement(['true','false','true','false']));
            $admin->setGenre($faker->randomElement(['F','M','F','F']));
            $manager->persist($admin);

        $manager->flush();
    }
}