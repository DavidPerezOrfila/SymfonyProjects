<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * indexAction
     *
     * @Route(
     *     path="/",
     *     name="app_user_index"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        /*$user1 = new User();
        $user1->setEmail('paco@tucorreo.com');
        $user1->setPassword('1234');
        $user1->setUsername('paco');
        $m->persist($user1);
        $user2 = new User();
        $user2->setEmail('lucia@mimail.es');
        $user2->setPassword('4321');
        $user2->setUsername('user2');
        $m->persist($user2);

        $user3 = new User();
        $user3->setEmail('miguel36@yatellegara.com');
        $user3->setPassword('123456');
        $user3->setUsername('user3');
        $m->persist($user3);
        $m->flush();*/

        $repository = $m->getRepository('AppBundle:User');
        $users = $repository->findAll();
        return $this->render(':user:index.html.twig',
            [
                'users' => $users,
            ]
        );
    }

    /**
     * @Route(
     *     path="/insert",
     *     name="app_user_insert"
     * )
     */
    public function insertAction()
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        return $this->render(':user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_user_doInsert')
            ]
        );
    }
    /**
     * @Route(
     *     path="/do-insert",
     *     name="app_user_doInsert"
     * )
     */
    public function doInsert(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m = $this->getDoctrine()->getManager();
            $m->persist($user);
            $m->flush();
            $this->addFlash('messages', 'User added');
            return $this->redirectToRoute('app_user_index');
        }
        $this->addFlash('messages', 'Review your form data');
        return $this->render(':user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_user_doInsert')
            ]
        );
    }
    /**
     * updateAction
     *
     * @Route(
     *     path="/update/{id}",
     *     name="app_user_update"
     * )
     *
     */
    public function updateAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:User');
        $user = $repository->find($id);
        $form = $this->createForm(UserType::class, $user);
        return $this->render(':user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_user_doUpdate', ['id' => $id])
            ]
        );
    }
    /**
     * doUpdateAction
     * No se puede crear un new User y pasarlo a la form por qué no pasará la constraint de entidad única al ser
     * un usuario nuevo. Entonces antes que nada tienes que preguntar a la BBDD por ese usuario. Esta es la razón
     * porqué necesitamos la variante $id como argumento para el action
     *
     *
     * @Route(
     *     path="/do-update/{id}",
     *     name="app_user_doUpdate"
     * )
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function doUpdateAction($id, Request $request)
    {
        $m          = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:User');
        $user       = $repository->find($id);
        $form       = $this->createForm(UserType::class, $user);
        // usuario actualizado con los datos recuperados
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m->flush();
            $this->addFlash('messages', 'User updated');
            return $this->redirectToRoute('app_user_index');
        }
        $this->addFlash('messages', 'Review your form');
        return $this->render(':user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_user_doUpdate', ['id' => $id]),
            ]
        );
    }

    /**
     * We are using here param converters: https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
     *
     * @Route(
     *     path="/remove/{id}",
     *     name="app_user_remove"
     * )
     * @ParamConverter(name="user", class="AppBundle:User")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(User $user)
    {
        $m = $this->getDoctrine()->getManager();
        $m->remove($user);
        $m->flush();
        $this->addFlash('messages', 'User removed');
        return $this->redirectToRoute('app_user_index');
    }
}
