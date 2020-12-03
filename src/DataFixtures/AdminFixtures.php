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

class AdminFixtures extends Fixture implements DependentFixtureInterface
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
            $admin->setProfil($this->getReference(ProfileFixtures::ADMIN_REFERENCE))
                  ->setUsername($faker->unique('babacar')->randomElement(['babacar']))
                  ->setPassword($faker->randomElement([ $harsh, $harsh, $harsh, $harsh]))
                  ->setPrenom($faker->randomElement(['babacar','aminata','Oumar','Laye']))
                  ->setNom($faker->randomElement(['Diouf','Lo','Anne', 'Sall']))
                  ->setEmail($faker->randomElement(['babacar@sa.sn','aminata@sa.sn','Oumar@sa.sn','laye@sa.sn']))
                  ->setTelephone($faker->randomElement(['778458574','778548596','774859652','777777777']))
                  ->setArchivage($faker->randomElement([0]))
                  ->setGenre($faker->randomElement(['F','M','F','F']));
            $manager->persist($admin);

        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            UserFixtures::Class,
        );
    }
}