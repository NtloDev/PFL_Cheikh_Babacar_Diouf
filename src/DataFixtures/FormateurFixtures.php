<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Profil;
use App\Entity\Formateur;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

abstract class FormateurFixtures extends Fixture implements DependentFixtureInterface
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
            $form = new Formateur();
            $harsh = $this->encoder->encodePassword($form, 'passer');
            $form->setProfil($this->getReference(ProfileFixtures::FORMATEUR_REFERENCE));
            $form->setUsername($faker->unique()->randomElement(['babacar','aminata','Oumar','Laye']));
            $form->setPassword($faker->randomElement([ $harsh, $harsh, $harsh, $harsh]));
            $form->setPrenom($faker->randomElement(['babacar','aminata','Oumar','Laye']));
            $form->setNom($faker->randomElement(['Diouf','Lo','Anne', 'Sall']));
            $form->setEmail($faker->randomElement(['babacar@sa.sn','aminata@sa.sn','Oumar@sa.sn','laye@sa.sn']));
            $form->setTelephone($faker->randomElement(['778458574','778548596','774859652','777777777']));
            $form->setArchive($faker->randomElement(['true','false','true','false']));
            $form->setGenre($faker->randomElement(['F','M','F','F']));
            $manager->persist($form);

        $manager->flush();
    }
}