<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Userservice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route(
     * name="create_user",
     * path="api/admin/users",
     * methods={"POST"},
     * defaults={
     * "_controller"="\app\Controller\UserController::create_user",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="create_user"
     * }
     * )
     */
        
    public function create_user(Userservice $use,Request $request, SerializerInterface $serialize,UserPasswordEncoderInterface $encoder,EntityManagerInterface $entity)
    {
        //$test = $use->uploadimage();
        //dd($test);
        $User_json = $request->request->all();
        $image = $request->files->get("avatar");      
        $User = $serialize ->denormalize($User_json,"App\Entity\User",true);
        $image = fopen($image->getRealPath(),"rb");
        $User -> setAvatar($image);
        $User ->setArchive(0);
        $User -> SetPassword($encoder->encodePassword($User, 'passer'));
        $entity -> persist($User);
        $entity -> flush();
        fclose($image);
        return $this->json("succes",201);
    }
}
