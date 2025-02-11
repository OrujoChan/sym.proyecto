<?php

namespace App\BLL;

use App\Entity\Carta;
use App\Repository\CartaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class BaseBLL
{
    protected EntityManagerInterface $em;
    protected ValidatorInterface $validator;
    protected RequestStack $requestStack;
    protected Security $security;
    protected CartaRepository $cartaRepository;

    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        RequestStack $requestStack,
        Security $security,
        CartaRepository $cartaRepository
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->requestStack = $requestStack;
        $this->security = $security;
        $this->cartaRepository = $cartaRepository;
    }

    private function validate($entity)
    {
        $errors = $this->validator->validate($entity);
        if (count($errors) > 0) {
            $strError = '';
            foreach ($errors as $error) {
                if (!empty($strError))
                    $strError .= '\n';
                $strError .= $error->getMessage();
            }
            throw new BadRequestHttpException($strError);
        }
    }

    protected function guardaValidando($entity): array
    {
        $this->validate($entity);
        $this->em->persist($entity);
        $this->em->flush();
        return $this->toArray($entity);
    }

    public function entitiesToArray(array $entities)
    {
        if (is_null($entities))
            return null;
        $arr = [];
        foreach ($entities as $entity)
            $arr[] = $this->toArray($entity);
        return $arr;
    }
}
