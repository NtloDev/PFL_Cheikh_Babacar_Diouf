<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class Userservice
{
    public function uploadimage(Request $request): string
    {
        $image = $request->files->get("avatar");
        $image = fopen($image->getRealPath(),"rb");
        fclose($image);

        
        return $image;
    }
}