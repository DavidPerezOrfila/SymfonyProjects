<?php

namespace AppBundle\Controller;

use AppBundle\Entity\tapas;
use AppBundle\Form\TapasType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TapasController extends Controller
{
    /**
     * @Route("/", name="app_tapas_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:tapas');
        $p = new tapas();
        $p
            ->setNazwa('Patatas Bravas')
            ->setOpis('Deliciosas patatas con dos salsas picantes')
            ->setCena('3')
            ;
        $m->persist($p);
        $m->flush();
        $tapas = $repo->findAll();

        return $this->render(':tapas:index.html.twig',
            [
                'tapas'=> $tapas,
            ]
        );
    }

    /**
     * @Route("/insert", name="app_tapas_insert")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function insertAction()
    {
        $tapas= new tapas();
        $form= $this->createForm(TapasType::class, $tapas);
        return $this->render(':tapas:form.html.twig',
            [
                'form'      =>$form->createView(),
                'action'    =>$this->generateUrl('app_tapas_doInsert')
            ]

        );
    }

    /**
     * @Route("/doInsert", name="app_tapas_doInsert")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function doInsert(Request $request)
    {
        $tapas= new tapas();
        $form= $this->createForm(TapasType::class, $tapas);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $m = $this->getDoctrine()->getManager();

            $m->persist($tapas);
            $m->flush();
            $this->addFlash('messages', 'dodany cover');
            return $this->redirectToRoute('app_producto_index');
        }
        $this->addFlash('messages', 'sprawdzic swoje dane');
        return $this->render('tapas/form.html.twig',
            [
                'form'      =>$form->createView(),
                'action'    =>$this->generateUrl('app_tapas_doInsert')
            ]

        );
    }

    /**
     * @Route(path="/updateTapas/{id}", name="app_tapas_update")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:tapas');

        $tapas = $repository->find($id);
        $form = $this->createForm(TapasType::class, $tapas);

        return $this->render(':tapas:form.html.twig', [
            'form'      =>$form->createView(),
            'action'    =>$this->generateUrl('app_tapas_doUpdate', ['id' => $id])
        ]);
    }

    /**
     * @Route(path="/doUpdateTapas/{id}", name="app_tapas_doUpdate")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function doUpdateAction($id, Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:tapas');

        $tapas = $repository->find($id);
        $form = $this->createForm(TapasType::class, $tapas);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m->flush();
            $this->addFlash('messages', 'aktualizowany tapas');
            return $this->redirectToRoute('app_tapas_index');
        }
        $this->addFlash('messages', 'sprawdzic swoją formę');
        return $this->render(':tapas:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_tapas_doUpdate', ['id' => $id]),
            ]
        );
    }

    /**
     * @Route("/remove", name="app_tapas_remove")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $m= $this->getDoctrine()->getManager();
        $repository = $m ->getRepository('tapas');

        $tapas = $repository->find($id);
        $m->remove($tapas);
        $m->flush();

        return $this->redirectToRoute('app_tapas_index');
    }


}
