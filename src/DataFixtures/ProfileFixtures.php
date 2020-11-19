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
    public const ADMIN_REFERENCE = "ADMIN";
    public const FORMATEUR_REFERENCE = "FORMATEUR";
    public const APPRENANT_REFERENCE = "APPRENANT";
    public const CM_REFERENCE = "CM";

    public function load(ObjectManager $manager)
    {

        // $product = new Product();
        // $manager->persist($product);
            $profiles = ["ADMIN","FORMATEUR","CM","APPRENANT"];
            for ($i=0; $i<count($profiles) ; $i++) {
                $profile= new profil();
                $profile ->setLibelle($profiles[$i]);
                if($profile[$i]= 'ADMIN'){
                    $this->addReference(self::ADMIN_REFERENCE,$profile);
                }
                elseif($profile[$i]= 'FORMATEUR'){
                    $this->addReference(self::FORMATEUR_REFERENCE,$profile);
                }
                elseif($profile[$i]= 'APPRENANT'){
                    $this->addReference(self::APPRENANT_REFERENCE,$profile);
                }
                elseif($profile[$i]= 'CM'){
                    $this->addReference(self::CM_REFERENCE,$profile);
                }
                //$this->addReference($i,$profile);
                $manager->persist($profile);
            }
            $manager->flush();
            
        }

        
}