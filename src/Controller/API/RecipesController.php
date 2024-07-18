<?php 
namespace App\Controller\API;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecipesController extends AbstractController{

    


    #[Route('/api/recette')]
    public function index(Request $request, RecipeRepository $repository): JsonResponse
    {
        $recipes = $repository->findAll();
        $data = [];

        foreach ($recipes as $recipe) {
            $data[] = [
                'id' => $recipe->getId(),
                'title' => $recipe->getTitle(),
                'createdAt' => $recipe->getCreatedAt(),
                'updatedAt' => $recipe->getUpdatedAt(),
                'duration' => $recipe->getDuration(),
                'content' => $recipe->getContent()
            ];
        }
        
        // Write JSON data to file for logging or other purposes
       
        
        return $this->json($data);
        
        
    }


}