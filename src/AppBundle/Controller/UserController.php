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
        $user1 = new User();
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
        $m->flush();
        /*$repository = $m->getRepository('AppBundle:User');*/

    }
}
