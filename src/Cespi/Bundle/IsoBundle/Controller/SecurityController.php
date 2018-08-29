<?php
namespace Cespi\Bundle\IsoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityController extends Controller
{

      /**
     * @Route("/login", name="login")
     
     */
public function loginAction()
{
    $authenticationUtils = $this->get('security.authentication_utils');

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('CespiIsoBundle:Security:login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
}


   /**
     * @Route("/login_check", name="_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="_demo_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
        $this->get('security.token_storage')->setToken(null);
        $this->get('request')->getSession()->invalidate();
    
        return $this->redirect($this->generateUrl('cespi_iso_homepage'));
        
        
    }


}