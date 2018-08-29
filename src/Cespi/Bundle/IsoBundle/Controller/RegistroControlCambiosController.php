<?php

namespace Cespi\Bundle\IsoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cespi\Bundle\IsoBundle\Entity\RegistroControlCambios;
use Cespi\Bundle\IsoBundle\Form\RegistroControlCambiosType;
use Cespi\Bundle\IsoBundle\Form\RegistroControlCambiosEditType;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\User\User;
use Cespi\Bundle\IsoBundle\Entity\Usuarios;



/**
 * RegistroControlCambios controller.
 *
 */
class RegistroControlCambiosController extends Controller
{

    private function verificarRegistro (Request $request){
        $em = $this->getDoctrine()->getManager();
        $idRegistro = $request->get('idRegistro');
        $registro  = $em->getRepository('CespiIsoBundle:Registro')->findOneById($idRegistro);
       
        if (!$registro) {
            throw $this->createNotFoundException('No se encuentra el registro.');
        }
        
        return $registro;
    
    }

    /**
     * Lists all RegistroControlCambios entities.
     *
     */
    public function indexAction(Request $request)
    {
        
        
		  /*
			ALTER TABLE  `registro_control_cambios` ADD FOREIGN KEY (  `id_registro` ) REFERENCES  `iso`.`registro` (
				`id`
				) ON DELETE RESTRICT ON UPDATE RESTRICT ;
		  */
        
        $em = $this->getDoctrine()->getManager();
    	  $registro = $this->verificarRegistro ($request);
        
        $entities = $em->getRepository('CespiIsoBundle:RegistroControlCambios')->findByIdRegistro($registro->getId());

        return $this->render('CespiIsoBundle:RegistroControlCambios:index.html.twig', array(
            'entities' => $entities,
            'registro' => $registro
        ));
    }
    /**
     * Creates a new RegistroControlCambios entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new RegistroControlCambios();
 
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {

				
            $em = $this->getDoctrine()->getManager();            
            $idRegistro = $request->get('cespi_bundle_isobundle_registrocontrolcambios');
            $idRegistro = $idRegistro['idRegistro'];
            $registro  = $em->getRepository('CespiIsoBundle:Registro')->findOneById($idRegistro);
            $usuario_encontrado  = $em->getRepository('CespiIsoBundle:Usuarios')->findOneById($this->getUser()->getId());
            $entity->setIdRegistro($registro);
            $entity->setUser($usuario_encontrado);
    			
    			
            $em->persist($entity);
            $em->flush();
       
            return $this->redirect($this->generateUrl('registrocontrolcambios', array('idRegistro' => $idRegistro)));
            //return $this->redirect($this->generateUrl('registrocontrolcambios_show', array('id' => $entity->getId())));
        }else{
            
            print_R($form->getErrorsAsString());
            die();
            
        }

        return $this->render('CespiIsoBundle:RegistroControlCambios:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    

    /**
    * Creates a form to create a RegistroControlCambios entity.
    *
    * @param RegistroControlCambios $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(RegistroControlCambios $entity)
    {
        $form = $this->createForm(new RegistroControlCambiosType(), $entity, array(
            'action' => $this->generateUrl('registrocontrolcambios_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RegistroControlCambios entity.
     *
     */
    public function newAction(Request $request)
    {
        $registro = $this->verificarRegistro ($request);        
        $entity = new RegistroControlCambios();
		  $entity->setIdRegistro($registro->getId());
        $entity->setUser($this->getUser()->getId());
        //$entity->setUpdatedAt(new \DateTime());
        $form   = $this->createCreateForm($entity);

        return $this->render('CespiIsoBundle:RegistroControlCambios:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'registro' => $registro
        ));
    }

    /**
     * Finds and displays a RegistroControlCambios entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:RegistroControlCambios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RegistroControlCambios entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:RegistroControlCambios:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing RegistroControlCambios entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:RegistroControlCambios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RegistroControlCambios entity.');
        }

        $registro = $entity->getIdRegistro();
        $entity->setIdRegistro($registro);       
        $entity->setUser($this->getUser()->getId());
        
    
        $entity->setUpdatedAt(null);
       
   
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:RegistroControlCambios:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a RegistroControlCambios entity.
    *
    * @param RegistroControlCambios $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RegistroControlCambios $entity)
    {
        $form = $this->createForm(new RegistroControlCambiosEditType(), $entity, array(
            'action' => $this->generateUrl('registrocontrolcambios_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing RegistroControlCambios entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:RegistroControlCambios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RegistroControlCambios entity.');
        }

   
        $registro = $entity->getIdRegistro();
        $entity->setIdRegistro ($registro->getId());
        $entity->setUpdatedAt(null);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);


        if ($editForm->isValid()) {
           
            $entity->setIdRegistro ($registro);
            
            $usuario_encontrado  = $em->getRepository('CespiIsoBundle:Usuarios')->findOneById($this->getUser()->getId());
            $entity->setUser($usuario_encontrado);
    	
            
            $entity->setUpdatedAt(new \DateTime());
 
            //$em->merge($entity);

            $em->flush();

            return $this->redirect($this->generateUrl('registrocontrolcambios_edit', array('id' => $id)));
        }

        return $this->render('CespiIsoBundle:RegistroControlCambios:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a RegistroControlCambios entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CespiIsoBundle:RegistroControlCambios')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RegistroControlCambios entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('registrocontrolcambios'));
    }

    /**
     * Creates a form to delete a RegistroControlCambios entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('registrocontrolcambios_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
