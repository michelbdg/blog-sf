<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        PostRepository $postRepository
    ): Response
    {
        return $this->render('page/home.html.twig', [
            'posts' => $postRepository->findAll()
        ]);
    }

    // Route for displaying a single category with all its post
    #[Route('/{category}', name: 'category')]
    public function category(
        CategoryRepository $categoryRepository,
        Request $request
    ): Response
    {
        $category = $request->$this->get('category');
        return $this->render('page/home.html.twig', [
            'posts' => $categoryRepository->findOne(
                ['name' => $category]
            )->getPosts()
        ]);
    }
}
