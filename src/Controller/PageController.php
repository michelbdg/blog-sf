<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(
        Request $request,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        PaginatorInterface $paginator
    ): Response
    {
        $posts = $paginator->paginate(
            $postRepository->findAll(), // Request
            $request->query->getInt('page', 1), // Page number
            10
        );

        return $this->render('page/home.html.twig', [
            'posts' => $posts,
            'categories' => $categoryRepository->findAll()
        ]);
    }

    // Route for displaying a single category with all its post
    #[Route('/{category}', name: 'category')]
    public function category(
        CategoryRepository $categoryRepository,
        Request $request
    ): Response
    {
        $category = $request->get('category');
        return $this->render('page/home.html.twig', [
            'posts' => $categoryRepository->findOne(
                ['name' => $category]
            )->getPosts()
        ]);
    }
}
