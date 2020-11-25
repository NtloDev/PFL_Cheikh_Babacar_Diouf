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
    public const ADMIN_REFERENCE = 'ADMIN';
    public const APPRENANT_REFERENCE = 'APPRENANT';
    public const CM_REFERENCE = 'CM';
    public const FORMATEUR_REFERENCE = 'FORMATEUR';

    public function load(ObjectManager $manager)
    {

        // $product = new Product();
        // $manager->persist($product);
            $profiles = ['ADMIN','APPRENANT','CM','FORMATEUR'];
            for ($i=0; $i<count($profiles) ; $i++) {
                $profile= new profil();
                $profile ->setLibelle($profiles[$i]);
                $profile ->setArchivage(0);
                if($profiles[$i]== 'ADMIN'){
                    $this->addReference(self::ADMIN_REFERENCE,$profile);
                }
                elseif($profiles[$i]=='APPRENANT'){
                    $this->addReference(self::APPRENANT_REFERENCE,$profile);
                }
                elseif($profiles[$i]== 'CM'){
                    $this->addReference(self::CM_REFERENCE,$profile);
                }
                elseif($profiles[$i]== 'FORMATEUR'){
                    $this->addReference(self::FORMATEUR_REFERENCE,$profile);
                }
                //$this->setReference($i,$profile);
                $manager->persist($profile);
            }
            $manager->flush();
            
        }

        
}