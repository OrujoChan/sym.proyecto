<?php

namespace App\Controller;

use App\BLL\CartaBLL;
use App\Entity\Carta;
use App\Repository\CartaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): RedirectResponse
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('cartas');
    }

    #[Route('/cartas', name: 'cartas')]
    public function cartas(CartaRepository $CartaRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $cartas = $CartaRepository->findAll(); // Renamed from $imagenes

        return $this->render('pages/cartas.html.twig', [
            'cartas' => $cartas, // Updated variable name
        ]);
    }

    #[Route('/nueva', name: 'nueva', methods: ['GET', 'POST'])]
    public function nueva(Request $request, CartaBLL $cartaBLL): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $errores = [];
        $mensaje = null;

        // Get the logged-in user
        $usuario = $this->getUser();

        if (!$usuario) {
            throw $this->createAccessDeniedException('Debe estar autenticado para crear una carta.');
        }

        if ($request->isMethod('POST')) {
            try {
                $data = [
                    'nombre' => trim($request->request->get('nombre')),
                    'descripcion' => trim($request->request->get('descripcion')),
                    'categoria' => trim($request->request->get('categoria')),
                    'precio' => floatval($request->request->get('precio')),
                    'imagen' => null,
                    'fechaAdicion' => date('d/m/Y'),
                    'usuario' => $usuario, // Pass the user
                ];

                // Handle file upload
                $imagenFile = $request->files->get('imagen');
                if ($imagenFile) {
                    $fileName = uniqid() . '.' . $imagenFile->guessExtension();
                    $imagenFile->move(Carta::RUTA_IMAGENES_CARTAS, $fileName);
                    $data['imagen'] = $fileName;
                } else {
                    throw new \Exception("Debe subir una imagen.");
                }

                $cartaBLL->nueva($data);
                $mensaje = "Se ha guardado la carta correctamente";
            } catch (\Exception $e) {
                $errores[] = $e->getMessage();
            }
        }

        return $this->render('pages/nueva.html.twig', [
            'errores' => $errores,
            'mensaje' => $mensaje,
        ]);
    }


    #[Route('/cartas/{id}', name: 'show_card')]
    public function show(CartaRepository $CartaRepository, int $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $carta = $CartaRepository->find($id); // Renamed from $imagen

        if (!$carta) {
            throw $this->createNotFoundException('La carta no existe.');
        }

        return $this->render('pages/single-card.html.twig', [
            'carta' => $carta, // Updated variable name
        ]);
    }
}
