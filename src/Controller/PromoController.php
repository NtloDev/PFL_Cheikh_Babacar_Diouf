<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Promo;
use App\Entity\Referentiel;
use App\Entity\Groupe;
use App\Entity\Apprenant;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use function count;
use function dd;

class PromoController extends AbstractController
{
    /**
     * @Route(
     *     path="/api/admin/promos",
     *     name="addPromo",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\PromoController::addPromo",
     *          "__api_resource_class"=Promo::class,
     *          "__api_collection_operation_name"="addPromo"
     *     }
     * )
     */
    public function addPromo(IriConverterInterface $iriconverter,Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager, \Swift_Mailer $mailer, ProfilRepository $repoProfil)
    {
        $promo_data=$request->request->all();
        //dd($promo_data);
        $promo= $serializer->denormalize($promo_data,"App\Entity\Promo",true);
        //dd($promo);
        $promo->setArchive(0);
        // $referentiel= $iriconverter->getItemFromIri($promo_data["referentiels"]);
        //dd($referentiel);
        $doc = $request->files->get("document");
        $file = IOFactory::identify($doc);
        $reader = IOFactory::createReader($file);
        $spreadsheet = $reader->load($doc);
        $fichierexcel = $spreadsheet->getActivesheet()->toArray();
        //dd($fichierexcel);
        $password = "sonatel";
        for ($i = 0; $i < count($fichierexcel); $i++) {

            $user = new Apprenant();
            $cnt=count($fichierexcel);
            //dd($cnt);
            //dd($fichierexcel[0][1]);
            $user->setUsername($fichierexcel[$i][0])
                ->setPassword($encoder->encodePassword($user, $password))
                ->setNom($fichierexcel[$i][1])
                ->setPrenom($fichierexcel[$i][2])
                ->setTelephone($fichierexcel[$i][3])
                ->setEmail($fichierexcel[$i][4])
                ->setGenre($fichierexcel[$i][5])
                ->setArchivage(0);
            $user->setProfil($repoProfil->findOneByLibelle("Apprenant"));

            $groupe= new groupe();
            $groupe->setLibelle("Groupe Principal")
                   ->setArchive(0)
                   ->setType("Principal")
                   ->addApprenant($user);
            $promo->addGroupe($groupe);

            //dd($user);
            $manager->persist($user);

            $manager->flush();


            $message = (new\Swift_Message)
                ->setSubject('SONATEL ACADEMY')
                ->setFrom('cbabacardiouf@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("Bonsoir Cher(e) candidat(e) à 
                la sonatel Academy. \n Après les différentes étapes de sélection que tu as passé avec brio, nous t’informons que ta candidature a été retenue pour intégrer la promotion cette anné de la première école de codage gratuite du Sénégal.\n Rendez-vous sur www.sonatelacademy.sn et voici vos informations de connexion :\n Username: " . $user->getUsername() . " \n Password : " . $password . " ");
                //dd($message);
            $mailer->send($message);
            return new JsonResponse($message, Response::HTTP_CREATED, [], true);

        }

        //dd($promo);
        $errors = $validator->validate($promo);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        //$manager->persist($groupe);
        //dd($promo);
        $manager->persist($promo);
        $manager->flush();
        return $this->json($serializer->normalize($promo), Response::HTTP_CREATED);
    }
}
