<?php

namespace Bundle\Everzet\BehatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
 * This file is part of the EverzetBehatBundle.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BehatBundle Test Actions Controller.
 *
 * @author      Konstantin Kudryashov <ever.zet@gmail.com>
 */
class TestsController extends Controller
{
    public function pageAction($page)
    {
        return $this->render('Everzet\\BehatBundle:Tests:page', array(
            'page' => preg_replace('/page(\d+)/', 'Page #\\1', $page)
        ));
    }

    public function redirectAction()
    {
        return $this->redirect($this->generateUrl('behat_tests_page', array('page' => 'page1')));
    }

    public function formAction()
    {
        return $this->render('Everzet\\BehatBundle:Tests:form');
    }

    public function submitAction()
    {
        $data = $this['request']->request->all();

        return $this->render('Everzet\\BehatBundle:Tests:submit', array(
            'method'        => $this['request']->getMethod()
          , 'name'          => $data['name']
          , 'age'           => $data['age']
          , 'speciality'    => $data['speciality']
        ));
    }
}
