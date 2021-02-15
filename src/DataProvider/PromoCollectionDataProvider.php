<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Repository\PromoRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Promo;
use function dd;

final class PromoCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $promoRepository;
    public function __construct(PromoRepository $promoRepository)
    {
        return $this->promoRepository=$promoRepository;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName!=='getPromos' )
        {
            return Promo::class === $resourceClass;
        }
        return false;
    }
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        if($operationName=='getPromoGroupePrincipal'){

            return $this->promoRepository->findPromobyGrpPrincipal();
        }
        elseif($operationName=='getPromoApprenantAttente'){

            return $this->promoRepository->findPromobyApprenantsAttente();
        }
    }
}