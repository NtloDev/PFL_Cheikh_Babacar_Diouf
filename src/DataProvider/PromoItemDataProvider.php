<?php
// api/src/DataProvider/BlogPostItemDataProvider.php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Promo;
use App\Repository\PromoRepository;

final class PromoItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $promoRepository;
    public function __construct(PromoRepository $promoRepository)
    {
        return $this->promoRepository=$promoRepository;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName==='getPromo' || $operationName==='getApprenantsOfPromo' || $operationName==='getPromoReferentielCompetences' || $operationName==='getPromoGroupeApprenants'|| $operationName==='getFormateursGroupeReferentiel')
        {
            return false;
        }
        return Promo::class === $resourceClass;

    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Promo
    {

        if($operationName=='getPromoApprenantsEnAttente'){

            $test=$this->promoRepository->findOnePromobyApprenantsAttente($id);
            //dd($test);
            return $this->promoRepository->findOnePromobyApprenantsAttente($id);
        }
    }
}