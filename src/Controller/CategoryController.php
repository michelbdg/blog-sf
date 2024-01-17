<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/{category}', name: 'category')]
    public function category(
        Category $category,
        Request $request,
        PostRepository $postRepository
    ): Response {
        $category = $request->$this->get('category');;
        return $this->render('category/category.html.twig', [
            'category' => $category,
            'posts' => $postRepository->findBy(['category' => $category]),
        ]);
    }
}
