<?php

namespace App\Controller;

use App\Command\Product\ProductCommand;
use App\Command\Product\ProductHandle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(private readonly ProductHandle $productHandle)
    {
    }

    #[Route('/', name: 'product')]
    public function show(): Response
    {
        return new Response('index page');
    }

    #[Route(path: '/api/v1/calculate-price-and-quantity', methods: ['POST'])]
    public function calculatePriceAndQuantity(Request $request): JsonResponse
    {
        $request = json_decode($request->getContent(), true);
        $handle = $this->productHandle->handle(new ProductCommand($request['date']));

        return new JsonResponse($handle);
    }
}