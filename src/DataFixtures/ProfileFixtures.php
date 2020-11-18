<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
            $profiles = ["ADMIN","FORMATEUR","CM","APPRENANT"];
            for ($i=0; $i<4 ; $i++) {
                $profile= new profil();
                $profile ->setLibelle($profiles[$i]);
                $this->addReference($i,$profile);
                $manager->persist($profile);
            }
            $manager->flush();
            
        }

        
}