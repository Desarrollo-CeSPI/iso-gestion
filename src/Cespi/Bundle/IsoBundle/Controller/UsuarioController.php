<?php

namespace Cespi\Bundle\IsoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cespi\Bundle\IsoBundle\Entity\Usuarios;
use Cespi\Bundle\IsoBundle\Form\UsuarioType;
use Cespi\Bundle\IsoBundle\Form\PasswordType;


class UsuarioController extends Controller
{
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        $entity = $em->getRepository('CespiIsoBundle:Usuarios')->find($id);
        return $this->render('CespiIsoBundle:Usuario:index.html.twig', array(
            'entity' => $entity,
        ));
    }
    
    
    public function editPasswordAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        
        $entity = $em->getRepository('CespiIsoBundle:Usuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuarios entity.');
        }

        $editForm = $this->createEditPasswordForm($entity);
        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
        
    }
    
    
    /**
     * Displays a form to edit an existing Usuarios entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        $entity = $em->getRepository('CespiIsoBundle:Usuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuarios entity.');
        }

        $editForm = $this->createEditForm($entity);
        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    
    
     /**
    * Creates a form to edit a Usuarios entity.
    *
    * @param Usuarios $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditPasswordForm(Usuarios $entity)
    {
        $form = $this->createForm(new PasswordType(), $entity, array(
            'action' => $this->generateUrl('usuario_updatepassword', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'marg btn btn-primary btn-sm')));

        return $form;
    }
    
    /**
     * Edits an existing Usuarios entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        $entity = $em->getRepository('CespiIsoBundle:Usuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuarios entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('usuario', array('id' => $id)));
        }

        return $this->render('CespiIsoBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
         //   'delete_form' => $deleteForm->createView(),
        ));
    }
    
    
     /**
     * Finds and displays a Usuarios entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        
        $entity = $em->getRepository('CespiIsoBundle:Usuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuarios entity.');
        }


        return $this->render('CespiIsoBundle:Usuario:index.html.twig', array(
            'entity'      => $entity,
          ));
    }
    
    
     /**
     * Edits an existing Usuarios entity.
     *
     */
    public function updatepasswordAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        $entity = $em->getRepository('CespiIsoBundle:Usuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuarios entity.');
        }

       
        $editForm = $this->createEditPasswordForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('usuario', array('id' => $id)));
        }

        return $this->render('CespiIsoBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
         //   'delete_form' => $deleteForm->createView(),
        ));
    }
    

      /**
    * Creates a form to edit a Usuarios entity.
    *
    * @param Usuarios $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuarios $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'marg btn btn-primary btn-sm')));

        return $form;
    }
}
