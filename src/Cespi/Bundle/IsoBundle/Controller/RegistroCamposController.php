<?php

namespace Cespi\Bundle\IsoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cespi\Bundle\IsoBundle\Entity\Registro;
use Cespi\Bundle\IsoBundle\Entity\RegistroCampos;
use Cespi\Bundle\IsoBundle\Form\RegistroCamposType;

/**
 * RegistroCampos controller.
 *
 */
class RegistroCamposController extends Controller
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
     * Lists all RegistroCampos entities.
     *
     */
    public function indexAction(Request $request)
    {
        $registro = $this->verificarRegistro ($request);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CespiIsoBundle:RegistroCampos')->findByIdRegistro( $registro->getId());

        return $this->render('CespiIsoBundle:RegistroCampos:index.html.twig', array(
            'entities' => $entities,
            'registro' => $registro
        ));
    }
    /**
     * Creates a new RegistroCampos entity.
     *
     */
   
    public function createAction(Request $request)
    {
        $entity = new RegistroCampos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $idRegistro = $request->get('cespi_bundle_isobundle_registrocampos');
            $idRegistro = $idRegistro['idRegistro'];
            $registro  = $em->getRepository('CespiIsoBundle:Registro')->findOneById($idRegistro);
            
            $entity->setIdRegistro ($registro);
            $em->persist($entity);
            $em->flush();

            // return $this->redirect($this->generateUrl('campos_registro_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('campos_registro', array('idRegistro' => $idRegistro)));
        }

        return $this->render('CespiIsoBundle:RegistroCampos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
        
    /**
    * Creates a form to create a RegistroCampos entity.
    *
    * @param RegistroCampos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(RegistroCampos $entity)
    {
        $form = $this->createForm(new RegistroCamposType(), $entity, array(
            'action' => $this->generateUrl('campos_registro_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear','attr' => array('class' => 'marg btn btn-primary btn-sm')));
        return $form;
    }

    /**
     * Displays a form to create a new RegistroCampos entity.
     *
     */
    public function newAction(Request $request)
    {
        $registro = $this->verificarRegistro ($request);
        $entity = new RegistroCampos();
        $entity-> setIdRegistro($registro->getId());
        
        $form  = $this->createCreateForm($entity);

        return $this->render('CespiIsoBundle:RegistroCampos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RegistroCampos entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:RegistroCampos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RegistroCampos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:RegistroCampos:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing RegistroCampos entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:RegistroCampos')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RegistroCampos entity.');
        }

        $registro = $entity->getIdRegistro();
        $entity->setIdRegistro($registro->getId());       
        
        
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:RegistroCampos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a RegistroCampos entity.
    *
    * @param RegistroCampos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RegistroCampos $entity)
    {
        $form = $this->createForm(new RegistroCamposType(), $entity, array(
            'action' => $this->generateUrl('campos_registro_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'marg btn btn-primary btn-sm')));

        return $form;
    }
    /**
     * Edits an existing RegistroCampos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:RegistroCampos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RegistroCampos entity.');
        }

        
        $registro = $entity->getIdRegistro();
        $entity->setIdRegistro ($registro->getId());

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
           
            $entity->setIdRegistro ($registro);
            $em->flush();

            return $this->redirect($this->generateUrl('campos_registro_edit', array('id' => $id)));
        }

        return $this->render('CespiIsoBundle:RegistroCampos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a RegistroCampos entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CespiIsoBundle:RegistroCampos')->find($id);
            $idRegistro = $entity->getIdRegistro()->getId();

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RegistroCampos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl('campos_registro', array('idRegistro' => $idRegistro)));
       
    }

    /**
     * Creates a form to delete a RegistroCampos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('campos_registro_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar','attr' => array('class' => 'btn btn-danger btn-sm')))
            ->getForm()
        ;
    }
}
