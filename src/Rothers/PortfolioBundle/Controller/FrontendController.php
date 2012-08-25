<?php

namespace Rothers\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/")
 */
class FrontendController extends Controller
{

    /**
     * @Route("", name="frontend_portfolio_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository("PortfolioBundle:Portfolio")->findAll();
        return array('entities' => $entities);
    }

    /**
     * @Route("portfolio/{link}", name="frontend_portfolio_show")
     * @Template()
     */
    public function showAction($link)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $portfolio = $em->getRepository("PortfolioBundle:Portfolio")->findOneBy(array("link" => $link));
        return array('entity' => $portfolio);
    }
    
    
    /**
     * @Route("/about-me", name="about_me")
     * @Template()
     * @return type
     */
    public function aboutAction()
    {
        return array();
    }

}
