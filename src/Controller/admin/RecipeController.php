<?php

namespace App\Controller\admin;
// use\App\Entity\Recipe;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\Json;


#[Route('/admin/recettes', name:'admin.recipe.')]

class RecipeController extends AbstractController
{
   
    #[Route('/', name: 'index')]
    public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $em): Response
    {
      // dd($em->getRepository(Recipe::class));
       $recipes = $repository ->findWithDuration(100);
    //    dd($recipes);
    // $recipes[0]->setTitle('Pâtes bolognaise');
    // $em->flush();
    
    // pour ansere de donnees
    $recipe = new Recipe();
    // $recipe->setTitle('Barbe papa')
    //         ->setContent('Mettez du sucre')
    //         ->setDuration(2)
    //         ->setCreatedAt(new \DateTimeImmutable())
    //         ->setUpdatedAt(new \DateTimeImmutable());
    // $em->persist($recipe);
    

    // supprimer de base de donnees
    
    // $em->remove($recipes[0]);
    // $em->flush();
    
    

    
      return $this->render('admin/recipe/index.html.twig',[
        'recipes'=>$recipes
      ]); 
        
    }
    #[Route('/create', name:'create')]
    public function create( Request $request, EntityManagerInterface $em){
      $recipe = new Recipe();
      $form = $this->createForm(RecipeType::class,$recipe);
      $form->handleRequest($request);  
      
      if($form->isSubmitted() && $form->isValid()){
        // $recipe->setCreatedAt(new \DateTimeImmutable());
        // $recipe->setUpdatedAt(new \DateTimeImmutable());
        $em->persist($recipe);
        $em->flush();
        $this->addFlash('success','La recette a bien été crée');
        return $this->redirectToRoute('recipe.index'); 
      }
      
      return $this->render('admin/recipe/create.html.twig',[
        
        'form'=>$form
      ]);
    }
   
    
    #[Route('/{id}', name:'edit', methods:['GET','POST'],requirements:['id'=>Requirement::DIGITS])]
    
    public function edit(Recipe $recipe , Request $request, EntityManagerInterface $em){
      $form = $this->createForm(RecipeType::class,$recipe);
      $form->handleRequest($request);  
      
      if($form->isSubmitted() && $form->isValid()) {
        // $recipe->setCreatedAt(new \DateTimeImmutable());
        // $recipe->setUpdatedAt(new \DateTimeImmutable());
          $em->flush();
        $this->addFlash('success','La recette a bien ete modifie');
          return $this->redirectToRoute('recipe.index');
    }      
      return $this->render('admin/recipe/recipe/edit.html.twig',[
        'recipe'=>$recipe,
        'form'=>$form
      ]);
    }
   

    #[Route('/{id}', name:'delete', methods:['DELETE'],requirements:['id'=>Requirement::DIGITS])]

    public function delete(Recipe $recipe, EntityManagerInterface $em){
      
      $em->remove($recipe);
      $em->flush();

      $this->addFlash('success','the recipe has been deleted !!!');
 
      return $this->redirectToRoute('recipe.index');

      
    
      
    }

    
}
