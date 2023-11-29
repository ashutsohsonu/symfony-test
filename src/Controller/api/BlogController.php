<?php

namespace App\Controller\api;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="blog_list")
     */
    public function list(BlogRepository $blogPostRepository): JsonResponse
    {
        $posts = $blogPostRepository->findAll();
        $data = [];

        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'comment' => $post->getComment(),
                'createdAt' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $post->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return $this->json($data);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="blog_show")
     */
    public function show(Blog $blogPost): JsonResponse
    {
        $data = [
            'id' => $blogPost->getId(),
            'title' => $blogPost->getTitle(),
            'comment' => $blogPost->getComment(),
            'createdAt' => $blogPost->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $blogPost->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];

        return $this->json($data);
    }

    /**
     * @Route("/", methods={"POST"}, name="blog_create")
     */
    public function create(Request $request): JsonResponse
    {
        // Handle the request and create a new blog post entity
        // Persist the entity to the database

        return $this->json(['message' => 'Blog post created successfully'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="blog_update")
     */
    public function update(Request $request, Blog $blogPost): JsonResponse
    {
        // Handle the request and update the existing blog post entity
        // Persist the entity to the database

        return $this->json(['message' => 'Blog post updated successfully']);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="blog_delete")
     */
    public function delete(Blog $blogPost): JsonResponse
    {
        // Delete the blog post entity from the database

        return $this->json(['message' => 'Blog post deleted successfully']);
    }
}