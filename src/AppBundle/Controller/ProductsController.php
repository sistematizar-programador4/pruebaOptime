<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Products;
use AppBundle\Entity\Category;

class ProductsController extends Controller {
    /**
    * @Route("/create-products")
    */
    public function createAction(Request $request) {

        $product = new Products();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder($product)
        ->add('code', TextType::class)
        ->add('name', TextType::class)
        ->add('description', TextareaType::class)
        ->add('mark', TextType::class)
        ->add('price', NumberType::class)
        ->add('category', EntityType::class, [
            'class' => Categories::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                ->where('c.active = 1');
            },
        ])
        ->add('save', SubmitType::class, array('label' => 'New products','attr' => ['class' => 'btn waves-effect waves-light submit']))
        ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {

            $product = $form->getData();
            $validator = $this->get('validator');
            $errors = $validator->validate($product);
            if (count($errors) > 0) {
                $products = $this->getDoctrine()
                ->getRepository('AppBundle:Products')
                ->findAll();

                return $this->render(
                    'products/new.html.twig',
                    array('form' => $form->createView(),'errors' => $errors)
                    );
            }

            $em->persist($product);
            $em->flush();
        
            return $this->redirect('/show-products');
    
        }
    
        return $this->render(
        'products/new.html.twig',
        array('form' => $form->createView(),'errors' => '')
        );
    
    }

    /**
    * @Route("/show-products")
    */  
    public function showAction(Request $request) {
        $filter = $request->query->get('filter');

        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Products')->createQueryBuilder('o')
        ->where('o.name LIKE :product')
        ->setParameter('product', '%'.$filter.'%')
        ->getQuery()
        ->getResult();

        return $this->render(
            'products/list.html.twig',
            array('products' => $products)
        );
    }

    /**
    * @Route("/update-products/{id}")
    */  
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Products')->find($id);

        if (!$product) {
        throw $this->createNotFoundException(
        'There are no products with the following id: ' . $id
        );
        }
    
        $form = $this->createFormBuilder($product)
        ->add('code', TextType::class)
        ->add('name', TextType::class)
        ->add('description', TextareaType::class)
        ->add('mark', TextType::class)
        ->add('price', NumberType::class)
        ->add('category', EntityType::class, [
            'class' => Categories::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                ->where('c.active = 1');
            },
        ])
        ->add('save', SubmitType::class, array('label' => 'New products','attr' => ['class' => 'btn waves-effect waves-light submit']))
        ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {

            $product = $form->getData();
            $validator = $this->get('validator');
            $errors = $validator->validate($product);
            if (count($errors) > 0) {

                return $this->render(
                    'products/new.html.twig',
                    array('form' => $form->createView(),'errors' => $errors)
                    );
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        
            return $this->redirect('/show-products');
    
        }
    
        return $this->render(
            'products/new.html.twig',
            array('form' => $form->createView(),'errors' => '')
            );
    
    }

    /**
    * @Route("/delete-products/{id}")
    */ 
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Products')->find($id);
    
        if (!$product) {
        throw $this->createNotFoundException(
        'There are no products with the following id: ' . $id
        );
        }
    
        $em->remove($product);
        $em->flush();
    
        return $this->redirect('/show-products');
    
    }

}
