<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends Controller
{
    /**
     * @Route("/", name="app_producto_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Product');
         $p = new Product();
         $p
             ->setName('Meizu MX5')
             ->setDescription('Chino con cierta garantía')
             ->setPrice('300')
             ;
         $m->persist($p);
         $m->flush();
        /*
         * busca un producto
         * */
        /*$p = $repo->findOneBy([
            'name' => 'Meizu MX5',
        ]);*/
        /*para buscar todos los productos*/
        /* $p = $repo->findAll();*/
        /*$p = $repo->find(3);

         $p->setPrice('1100');
         $p->setDescription('Black Friday, nos lo quitan de las manos!');
         $p1 = $repo->findOneBy([
             'name' => 'Meizu MX5'
         ]);

         $m->remove($p1);
         $m->flush();*/

        $products = $repo->findAll();

        return $this->render(':product:index.html.twig',
            [
                'producto'=> $products,
            ]
        );
    }

    /**
     * @Route("/insert", name="app_producto_insert")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function insertAction()
    {
        $product= new Product();
        $form= $this->createForm(ProductType::class, $product);
        return $this->render(':product:form.html.twig',
            [
                'form'      =>$form->createView(),
                'action'    =>$this->generateUrl('app_producto_doInsert')
            ]

        );
    }

    /**
     * @Route("/doInsert", name="app_producto_doInsert")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function doInsert(Request $request)
    {
        $product= new Product();
        $form= $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $m = $this->getDoctrine()->getManager();

            $m->persist($product);
            $m->flush();
            $this->addFlash('messages', 'producto añadido');
            return $this->redirectToRoute('app_producto_index');
        }
        $this->addFlash('messages', 'Revisa tus datos');
        return $this->render('product/form.html.twig',
            [
                'form'      =>$form->createView(),
                'action'    =>$this->generateUrl('app_producto_doInsert')
            ]

        );
    }

    /**
     * @Route(path="/updateProd/{id}", name="app_producto_update")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Product');

        $product = $repository->find($id);
        $form = $this->createForm(ProductType::class, $product);

        return $this->render(':product:form.html.twig', [
            'form'      =>$form->createView(),
            'action'    =>$this->generateUrl('app_producto_doUpdate', ['id' => $id])
        ]);
    }

    /**
     * @Route(path="/doUpdateProd/{id}", name="app_producto_doUpdate")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function doUpdateAction($id, Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Product');

        $product = $repository->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m->flush();
            $this->addFlash('messages', 'Producto Actualizado');
            return $this->redirectToRoute('app_producto_index');
        }
        $this->addFlash('messages', 'Revisa tu formulario');
        return $this->render(':product:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_producto_doUpdate', ['id' => $id]),
            ]
        );
    }

    /**
     * @Route("/remove", name="app_producto_remove")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $m= $this->getDoctrine()->getManager();
        $repository = $m ->getRepository('product');


        $product = $repository->find($id);
        $m->remove($product);
        $m->flush();

        return $this->redirectToRoute('app_producto_index');
    }


}

