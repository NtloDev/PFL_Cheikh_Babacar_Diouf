<?php
// api/src/Controller/CreateMediaObjectAction.php

namespace App\Controller;

use App\Entity\Referentiel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\User;
use ApiPlatform\Core\Api\IriConverterInterface;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\services\Userservice;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function count;
use function dd;
use function fopen;
use function gmdate;

class ReferentielController extends AbstractController
{

    /**
     * @Route(
     * name="create_referentiel",
     * path="api/admin/referentiels",
     * methods={"POST"},
     * defaults={
     * "_controller"="\app\Controller\ReferentielController::create_referentiel",
     * "_api_resource_class"=Referentiel::class,
     * "_api_collection_operation_name"="create_referentiel"
     * }
     * )
     */

    public function create_referentiel(ValidatorInterface $validator,IriConverterInterface $iriconverter,Request $request, SerializerInterface $_serializer,UserPasswordEncoderInterface $encoder,EntityManagerInterface $entity)
    {
        //dd($request);
        //$user_data=json_decode($request->getContent(), true) ;
        $ref_data=$request->request->all();
        //dd($ref_data['GroupeDeCompetences']);
        //$grpComps = $ref_data['GroupeDeCompetences'];
        //$grpTab = $iriconverter->getItemFromIri($ref_data['GroupeDeCompetences']);
        //$grpComps = json_decode($grpComps, true);
        //dd($grpComps) ;
        /*foreach ($grpComps as $grpComp){

            $grpTab = $iriconverter->getItemFromIri($grpComp);
            //dd($grpComp)  ;
        }*/
        //dd($grpComps);
        $ref= $_serializer->denormalize($ref_data,"App\Entity\\Referentiel",true);
        $pdf=$request->files->get("Programme");
        if($pdf)
        {
            $pdfblob=fopen($pdf->getRealPath(),"rb");
            $ref->setProgramme($pdfblob);
        }


        $errors = $validator->validate($ref);
        if(count($errors)){
            $errors = $_serializer->serialize($errors,"json");
            return['error'=>$errors];
        }
        $ref->SetArchive(false);
        //dd($user);
        $entity -> persist($ref);
        $entity -> flush();
        return $this->json("succes",201);
    }
}
