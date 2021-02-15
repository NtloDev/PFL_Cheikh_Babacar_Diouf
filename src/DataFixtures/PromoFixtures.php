<?php

namespace App\DataFixtures;

use App\Entity\Promo;
use App\Repository\ReferentielRepository;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Entity\NiveauDevaluation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PromoFixtures extends Fixture implements  DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $j=1;
        $referentiel = $this->getReference(ReferentielFixtures::getReferencekey($j));
        for($i=0 ;$i<=9 ;$i++){
            $appr[$i] = $this->getReference(ApprenantFixtures::getReferencekey($i));
        }
        for($l=0 ;$l<=4 ;$l++){
            $form[$l] = $this->getReference(FormateurFixtures::getReferencekey($l));
        }

        $Groupe = $this->getReference(GroupeFixtures::getReferencekey($j));
        $date= new DateTime();
            $promo = new Promo();
            $promo->setLangue('FRANCAIS')
                ->setTitre('Titre de la promo')
                ->setDescription('Description de la promo')
                ->setLieu('Lieu de la promo')
                ->setFabrique('SONATEL')
                ->setDateDebut($date)
                ->setDateFin($date)
                ->setArchive(0);
        $promo->addReferentiel($referentiel);
        for($k=0 ;$k<=9 ;$k++) {
            $promo->addApprenant($appr[$k]);
            $Groupe->addApprenant($appr[$k]);
        }
        for($m=0 ;$m<=4 ;$m++) {
            $promo->addFormateur($form[$m]);
        }

        $promo->addGroupe($Groupe);

        $manager->persist($promo);
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            ReferentielFixtures::Class,
        );
    }
}
