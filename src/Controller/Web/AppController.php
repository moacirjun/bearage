<?php

namespace App\Controller\Web;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/{reactRouting}", defaults={"reactRouting": null}, name="app_index")
     */
    public function index()
    {
        // $view = $this->view();
        // $view->setTemplate('app/index.html.twig');

        return $this->render('app/index.html.twig');
    }
}
