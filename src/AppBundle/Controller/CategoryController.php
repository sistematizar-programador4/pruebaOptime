<?php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Categories;

class CategoryController extends Controller {
    /**
    * @Route("/create-categories")
    */
    public function createAction(Request $request) {

        $category = new Categories();
        $form = $this->createFormBuilder($category)
        ->add('code', TextType::class)
        ->add('name', TextType::class)
        ->add('description', TextareaType::class)
        ->add('active', ChoiceType::class, [
            'choices'  => [
                'Yes' => 1,
                'No' => 0,
            ],
        ])
        ->add('save', SubmitType::class, array('label' => 'New category','attr' => ['class' => 'btn waves-effect waves-light submit']))
        ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {

            $category = $form->getData();
            $validator = $this->get('validator');
            $errors = $validator->validate($category);
            if (count($errors) > 0) {
                $categories = $this->getDoctrine()
                ->getRepository('AppBundle:Categories')
                ->findAll();

                return $this->render(
                    'categories/new.html.twig',
                    array('form' => $form->createView(), 'errors' => $errors)
                    );
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        
            return $this->redirect('/show-categories');
    
        }
    
        return $this->render(
        'categories/new.html.twig',
        array('form' => $form->createView(), 'errors' => '')
        );
    
    }

    /**
    * @Route("/show-categories")
    */  
    public function showAction($errors = '') {

        $categories = $this->getDoctrine()
        ->getRepository('AppBundle:Categories')
        ->findAll();

        return $this->render(
            'categories/list.html.twig',
            array('categories' => $categories,'errors' => $errors)
        );
    }

    /**
    * @Route("/update-categories/{id}")
    */  
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Categories')->find($id);
    
        if (!$category) {
        throw $this->createNotFoundException(
        'There are no categories with the following id: ' . $id
        );
        }
    
        $form = $this->createFormBuilder($category)
        ->add('code', TextType::class)
        ->add('name', TextType::class)
        ->add('description', TextareaType::class)
        ->add('active', ChoiceType::class, [
            'choices'  => [
                'Yes' => 1,
                'No' => 0,
            ],
        ])
        ->add('save', SubmitType::class, array('label' => 'New category','attr' => ['class' => 'btn waves-effect waves-light submit']))
        ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
    
            $category = $form->getData();
            $validator = $this->get('validator');
            $errors = $validator->validate($category);
            if (count($errors) > 0) {
                $categories = $this->getDoctrine()
                ->getRepository('AppBundle:Categories')
                ->findAll();

                return $this->render(
                    'categories/new.html.twig',
                    array('form' => $form->createView(), 'errors' => $errors)
                    );
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        
            return $this->redirect('/show-categories');
    
        }
    
        return $this->render(
        'categories/new.html.twig',
        array('form' => $form->createView(), 'errors' => '')
        );
    
    }

    /**
    * @Route("/delete-categories/{id}")
    */ 
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Categories')->find($id);
    
        if (!$category) {
        throw $this->createNotFoundException(
        'There are no categories with the following id: ' . $id
        );
        }
    
        $em->remove($category);
        $em->flush();
    
        return $this->redirect('/show-categories');
    
    }

}
