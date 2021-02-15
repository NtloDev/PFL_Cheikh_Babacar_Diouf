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
use function sprintf;

class ApprenantFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    public static function getReferenceKey($p)
    {
        return sprintf('apprenant_%s',$p);
    }
    

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
         
        $faker = Faker\Factory::create('fr_FR');

        $j=1;

            for($i=0 ;$i<=9 ;$i++){
                $appr = new Apprenant();
                $harsh = $this->encoder->encodePassword($appr, 'passer');
                $appr->setProfil($this->getReference(ProfileFixtures::APPRENANT_REFERENCE))
                    ->setUsername($faker->unique()->randomElement(['Laye','Fatou','Moussa','Ameth','Jean','Falou','Weuz','Abdou','Ansou','Tapha']))
                    ->setPassword($faker->randomElement([ $harsh, $harsh, $harsh, $harsh]))
                    ->setPrenom($faker->randomElement(['babacar','aminata','Oumar','Laye','Fatou','Moussa','Ameth','Jean','Falou','Weuz','Abdou','Ansou','Tapha']))
                    ->setNom($faker->randomElement(['Diouf','Lo','Anne', 'Sall','Niang','Mbaye','Mendy','Ndiaye','Fall','Toure']))
                    ->setEmail($faker->randomElement(['babacar@sa.sn','aminata@sa.sn','Oumar@sa.sn','laye@sa.sn']))
                    ->setTelephone($faker->randomElement(['778458574','778548596','774859652','777777777']))
                    ->setArchivage($faker->randomElement([0]))
                    ->setGenre($faker->randomElement(['F','M','F','F']))
                    ->setStatut('Attente');
                $this->setReference(self::getReferenceKey($i),$appr);
                $manager->persist($appr);
            }


        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            UserFixtures::Class,
        );
    }
}
