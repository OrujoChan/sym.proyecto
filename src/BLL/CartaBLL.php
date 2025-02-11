<?php

namespace App\BLL;

use App\Entity\Carta;
use App\Entity\Usuario;
use App\Repository\CartaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class CartaBLL extends BaseBLL
{
    protected CartaRepository $cartaRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        RequestStack $requestStack,
        Security $security,
        CartaRepository $cartaRepository,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($em, $validator, $requestStack, $security, $cartaRepository);
        $this->cartaRepository = $cartaRepository;
        $this->entityManager = $entityManager;
    }

    public function getCartasConOrdenacion(?string $ordenacion)
    {
        $tipoOrdenacion = 'asc';
        $session = $this->requestStack->getSession();
        $cartasOrdenacion = $session->get('cartasOrdenacion');

        if (!is_null($ordenacion)) {
            if (!is_null($cartasOrdenacion) && $cartasOrdenacion['ordenacion'] === $ordenacion) {
                $tipoOrdenacion = $cartasOrdenacion['tipoOrdenacion'] === 'asc' ? 'desc' : 'asc';
            }

            $session->set('cartasOrdenacion', [
                'ordenacion' => $ordenacion,
                'tipoOrdenacion' => $tipoOrdenacion
            ]);
        } else {
            $ordenacion = 'id';
        }

        return $this->cartaRepository->findCartasConOrdenacion($ordenacion, $tipoOrdenacion);
    }

    public function toArray(Carta $carta): array
    {
        return [
            'id' => $carta->getId(),
            'nombre' => $carta->getNombre(),
            'descripcion' => $carta->getDescripcion(),
            'imagen' => $carta->getImagen(),
            'categoria' => $carta->getCategoria(),
            'precio' => $carta->getPrecio(),
            'fechaAdicion' => is_null($carta->getFechaAdicion()) ? '' : $carta->getFechaAdicion()->format('d/m/Y'),
        ];
    }

    public function nueva(array $data): void
    {
        $entityManager = $this->entityManager;

        $carta = new Carta();
        $carta->setNombre($data['nombre']);
        $carta->setDescripcion($data['descripcion']);
        $carta->setCategoria($data['categoria']);
        $carta->setPrecio($data['precio']);
        $carta->setImagen($data['imagen']);
        $carta->setFechaAdicion(new \DateTime());

        $usuario = $entityManager->getReference(Usuario::class, $data['usuario']->getId());
        $carta->setUsuario($usuario);

        $entityManager->persist($carta);
        $entityManager->flush();
    }


    public function getCartas()
    {
        $cartas = $this->cartaRepository->findAll();
        return $this->entitiesToArray($cartas);
    }
}
