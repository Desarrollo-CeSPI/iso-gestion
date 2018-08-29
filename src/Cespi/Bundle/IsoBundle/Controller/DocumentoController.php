<?php

namespace Cespi\Bundle\IsoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cespi\Bundle\IsoBundle\Entity\Documento;
use Cespi\Bundle\IsoBundle\Entity\Usuarios;
use Cespi\Bundle\IsoBundle\Entity\DocumentoUsuarios;
use Cespi\Bundle\IsoBundle\Entity\DocumentoLog;
use Cespi\Bundle\IsoBundle\Form\DocumentoType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Documento controller.
 *
 */
class DocumentoController extends Controller
{

    /**
     * Lists all Documento entities.
     *
     */
     public function indexAction(Request $request)
  
    {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $entities = $this->filtrar($session, $request );
        
        $idTipoDocumento = $session->get('idTipoDocumento_selected' );
        $idEstadoDocumento = $session->get('idEstadoDocumento_selected' );
        
        $tipos_documento = $em->getRepository('CespiIsoBundle:TipoDocumento')->findAll();
        $estados_documento = $em->getRepository('CespiIsoBundle:Estado')->findAll();
        
        return $this->render('CespiIsoBundle:Documento:index.html.twig', array(
            'entities' => $entities,
            'tipos_documento' => $tipos_documento,
            'estados_documento' => $estados_documento,
            'filtros' => array ($idTipoDocumento,$idEstadoDocumento ),
            'url_exportar' => $this->generateUrl('documento_exportar', array('idTipoDocumento' => $idTipoDocumento,'idEstadoDocumento' => $idEstadoDocumento)),
        ));
    }
    
    
 	  private function xlsBOF() {
		 return pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	  }
	  private function xlsEOF() {
		 return pack("ss", 0x0A, 0x00);
	  }
	  
	  private function xlsWriteNumber($Row, $Col, $Value) {
		 return pack("sssss", 0x203, 14, $Row, $Col, 0x0).pack("d", $Value);
		// return pack("d", $Value);
	  }
	  
	  private function xlsWriteLabel($Row, $Col, $Value) {
		  $L = strlen($Value);
		  return pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L) . $Value;
		  // return $Value;
	  } 

    public function filtrar($session, $request) {
        $em = $this->getDoctrine()->getManager();
    
        
        if ($request->isMethod('GET')) {
          
            if ( $session->has('idTipoDocumento_selected') or $session->has('idTipoDocumento_selected')) {
               
                $idTipoDocumento = $session->get('idTipoDocumento_selected' );
                $idEstadoDocumento = $session->get('idEstadoDocumento_selected' );
               
                $entities = $em->getRepository('CespiIsoBundle:Documento')->filtros($idTipoDocumento,$idEstadoDocumento);         
                
            } else {
                $session->set('idTipoDocumento_selected', 0);
                $session->set('idEstadoDocumento_selected', 0);
                $entities = $em->getRepository('CespiIsoBundle:Documento')->findAll();
            } 
            
        }else{
        
            $idTipoDocumento = $request->get('idTipoDocumento');
            $idEstadoDocumento = $request->get('idEstadoDocumento');
        
            $session->set('idTipoDocumento_selected', $idTipoDocumento);
            $session->set('idEstadoDocumento_selected', $idEstadoDocumento);
            
            $entities = $em->getRepository('CespiIsoBundle:Documento')->filtros($idTipoDocumento,$idEstadoDocumento);         
           
        }
                
        return $entities;
    }     
          
    /**
     * Lists all Documento entities.
     *
     */
    public function exportarAction()
    {
        
        /*
        
        $idTipoDocumento = $this->getRequest()->get('idTipoDocumento');
        $idEstadoDocumento = $this->getRequest()->get('idEstadoDocumento');
        $entities = $this->filtrar($idTipoDocumento, $idEstadoDocumento);

         */
        
        $request = $this->getRequest();
        $session = $request->getSession();
        $entities = $this->filtrar($session,$request);

        
        $em = $this->getDoctrine()->getManager();
        //$entities = $em->getRepository('CespiIsoBundle:Documento')->findAll();
		
		  $salida = array();
		
		  $salida[] = $this->xlsBOF();
		  $salida[] = $this->xlsWriteLabel(0, 0,  "ID");
		  $salida[] = $this->xlsWriteLabel(0, 1,  "Nombre");		  
		  $salida[] = $this->xlsWriteLabel(0, 2,  "Tipo");
		  $salida[] = $this->xlsWriteLabel(0, 3,  utf8_decode("Revision"));
		  $salida[] = $this->xlsWriteLabel(0, 4,  utf8_decode("Fecha de Creacion"));
		  $salida[] = $this->xlsWriteLabel(0, 5,  utf8_decode("Fecha de Aprobacion"));
		  $salida[] = $this->xlsWriteLabel(0, 6,  utf8_decode("Fecha de Revision"));
		  $salida[] = $this->xlsWriteLabel(0, 7,  "Fecha de Vigencia");
		  $salida[] = $this->xlsWriteLabel(0, 8,  "Ruta");
		  $salida[] = $this->xlsWriteLabel(0, 9,  "Estado");
		  $salida[] = $this->xlsWriteLabel(0, 10, "Editor");
		  $salida[] = $this->xlsWriteLabel(0, 11, "Revisor");
		  $salida[] = $this->xlsWriteLabel(0, 12, "Aprobador");
		  $salida[] = $this->xlsWriteLabel(0, 13, "Audiencia");
		  $salida[] = $this->xlsWriteLabel(0, 14, "Responsable");
		  
		  $fila = 0;
		  foreach ($entities as $e) { 
		
			 $this->cargarRoles($e);		
		
			 $fila++ ;

			 $salida[] = $this->xlsWriteLabel($fila,  0, utf8_decode($e->getId()));
			 $salida[] = $this->xlsWriteLabel($fila,  1, utf8_decode($e->getNombre()));
			 $salida[] = $this->xlsWriteLabel($fila,  2, utf8_decode($e->getTipo()));
			 $salida[] = $this->xlsWriteNumber($fila, 3, utf8_decode($e->getRevision()));
			   
  	       if ($e->getFechaCreacion() != null)  
	       	$salida[] = $this->xlsWriteLabel($fila, 4, $e->getFechaCreacion()->format('d/m/Y') );
          else
				$salida[] = $this->xlsWriteLabel($fila, 4, '' );	
  	       if ($e->getFechaAprobado() != null)  
	       	$salida[] = $this->xlsWriteLabel($fila, 5, $e->getFechaAprobado()->format('d/m/Y') );
          else
				$salida[] = $this->xlsWriteLabel($fila, 5, '' );	
	       if ($e->getFechaRevision() != null)  
	       	$salida[] = $this->xlsWriteLabel($fila, 6, $e->getFechaRevision()->format('d/m/Y') );
          else
				$salida[] = $this->xlsWriteLabel($fila, 6, '' );	
  	       if ($e->getFechaRevision() != null)  
	       	$salida[] = $this->xlsWriteLabel($fila, 7, $e->getFechaRevision()->format('d/m/Y') );
          else
				$salida[] = $this->xlsWriteLabel($fila, 7, '' );	
  
			 $salida[] = $this->xlsWriteLabel($fila, 8, utf8_decode($e->getRuta()));
			 
			 $salida[] = $this->xlsWriteLabel($fila, 9, utf8_decode($e->getEstado()));
			 
			 $roles = $em->getRepository('CespiIsoBundle:Rol')->findAll();
          $columna = 10;
         
          foreach ($roles as $rol) {
		        $persounas =''  ;
		        $cant = 0;
              $get = "get" . $rol->getNombre();
              
              foreach ($e->$get() as $persona) {
					$cant++;              	
              	$persounas .= $persona;
					if ($cant < count ($e->$get()))             	
              		$persounas .= "\r\n";
              }
				  $search = "\r\n";
				  $replace = "";
				  $persounas = strrev(implode(strrev($replace), explode($search, strrev($persounas), 2)));
         	 
          	  $salida[] = $this->xlsWriteLabel($fila, $columna, utf8_decode($persounas));
           	  $columna ++;
          }
			 
	 
			
			}
			
			$salida[] = $this->xlsEOF();

			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment; filename=\"documentos_".date("d_m_Y").".xls\"");
			header("Content-Transfer-Encoding: binary");
			header("Pragma: no-cache");
		   header("Expires: 0");
			
			foreach ($salida as $sal) {
				echo $sal;	
			} 
			die();			
			exit;

		  /*return $this->render('CespiIsoBundle:Documento:exportar.html.twig', array(
            'entities' => $entities,
            'salida' => $salida
            
            
        ), $response);*/
    }
    
    
    /**
     * Creates a new Documento entity.
     *
     */
    public function createAction(Request $request)
    {
       
        $entity = new Documento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request); 
        
        /* Por poner campos de fecha 'text' y no 'date' (problema con chrome)*/
        $this->convertirStringAFecha($entity);
        /* */    
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->cargarRolesEnBlancoUsuario($entity);
            $em->persist($entity);
            $em->flush();
            
            
            $id_documento = $entity->getId();
            $relaciones = $request->get('cespi_bundle_isobundle_documento');
            $roles = $em->getRepository('CespiIsoBundle:Rol')->findAll();
            
            foreach ($roles as $rol) {
                if (isset($relaciones[strtolower($rol->getNombre())])){
                    $personas =  $relaciones[strtolower($rol->getNombre())];
                    foreach ($personas as $persona) {
                        $entityDocUsr = new DocumentoUsuarios();
                        $entityDocUsr->setIdRol($rol->getId());
                        $entityDocUsr->setIdUsuario($persona);
                        $entityDocUsr->setIdDocumento($id_documento);
                        $em->persist($entityDocUsr);
                        $em->flush();
                    }
                }
            }
                
           
            /* acl /
                        // creando la ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $acl = $aclProvider->createAcl($objectIdentity);

            // recupera la identidad de seguridad del usuario
            // registrado actualmente
            $securityContext = $this->get('security.context');
            $user = $securityContext->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($user);

            // otorga permiso de propietario
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
            /* acl fin */
                        
            return $this->redirect($this->generateUrl('documento_show', array('id' => $id_documento)));
        }

        return $this->render('CespiIsoBundle:Documento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Documento entity.
    *
    * @param Documento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Documento $entity)
    {
        $form = $this->createForm(new DocumentoType(), $entity, array(
            'action' => $this->generateUrl('documento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear','attr' => array('class' => 'marg btn btn-primary btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new Documento entity.
     *
     */
    public function newAction()
    {
        $entity = new Documento();
        $form   = $this->createCreateForm($entity);

        return $this->render('CespiIsoBundle:Documento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Documento entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:Documento')->find($id);
        
        $logs = $em->getRepository('CespiIsoBundle:DocumentoLog')->findByIdDocumento($entity->getId(),array('updatedAt' => 'DESC'));        // $where 
       
        $esEditor = false;
        if ($this->esEditor($entity->getId())) {
            $esEditor =  true;
        }
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Documento entity.');
        }

		  $this->cargarRoles($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:Documento:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'logs'        => $logs,
            'esEditor' => $esEditor       ));
    }

    
    private function esEditor($idDocumento) {
     /* 
      * 1	Editor
        2	Revisor
        3	Aprobador
        4	Audiencia
        5	Responsable
      */
        if ($this->getUser()->esAdmin()) return true;
        else {
        $em = $this->getDoctrine()->getManager();
        $permiso = $em->getRepository('CespiIsoBundle:DocumentoUsuarios')->findBy(
                    array('idUsuario' => array($this->getUser()), 'idRol' => array(1), 'idDocumento' => $idDocumento)        // $where 
            );
        
        return (!empty($permiso));
        
        }
    }


    private function guardarLog($entity,$first = false) {
        $em = $this->getDoctrine()->getManager();
        $nuevoLog = new DocumentoLog($entity);
        $nuevoLog->setDescripcion($entity->getDescripcion());
        $nuevoLog->setNombre($entity->getNombre());
        $nuevoLog->setRuta($entity->getRuta());
        $nuevoLog->setRevision($entity->getRevision());
        $nuevoLog->setEstado($entity->getEstado());
        $nuevoLog->setFechaAprobado($entity->getFechaAprobado());
        $nuevoLog->setFechaRevision($entity->getFechaRevision());
        $nuevoLog->setFechaCreacion($entity->getFechaCreacion());
        $nuevoLog->setFechaVigencia($entity->getFechaVigencia());
        $nuevoLog->setTipo($entity->getTipo());
        $nuevoLog->setIdDocumento($entity->getId());
        //obtener id de usuario logueado
        $nuevoLog->setuser($this->getUser());
        if ($first) {
            $nuevoLog->setUpdatedAt(new \DateTime("2000-01-01 00:00:00.0"));
        }
        $em->persist($nuevoLog);
        $em->flush();
    }
    
    private function cargarRoles($entity) {

        $em = $this->getDoctrine()->getManager();
        $roles = $em->getRepository('CespiIsoBundle:Rol')->findAll();
        foreach ($roles as $rol) {
            $doc = $em->getRepository('CespiIsoBundle:DocumentoUsuarios')->findBy(
                    array('idDocumento' => array($entity->getId()), 'idRol' => array($rol->getId()))        // $where 
            );
            $rol->usuariosDoc = array();
            foreach ($doc as $d) {
                $idUser = $d->getIdUsuario();
                $rol->usuariosDoc[] = $em->getRepository('CespiIsoBundle:Usuarios')->find($idUser);
            }
        }
        //Generico
        foreach ($roles as $rol) {
            $set = "set" . $rol->getNombre();
            $entity->$set($rol->usuariosDoc);
        }

        return $entity;
    }
    
    
    private function cargarRolesEnBlanco($entity) {

        $em = $this->getDoctrine()->getManager();
        $roles = $em->getRepository('CespiIsoBundle:Rol')->findAll();
        //Generico
        foreach ($roles as $rol) {
            $set = "set" . $rol->getNombre();
            $entity->$set(new ArrayCollection());
           
        }

        return $entity;
    }
    
      private function cargarRolesEnBlancoUsuario($entity) {

        $em = $this->getDoctrine()->getManager();
        $roles = $em->getRepository('CespiIsoBundle:Rol')->findAll();
        //Generico
        foreach ($roles as $rol) {
            $set = "set" . $rol->getNombre();
           // $entity->$set(new ArrayCollection());
            $entity->$set($em->getRepository('CespiIsoBundle:Usuarios')->find(1));
        }

        return $entity;
    }
    
    
    /**
     * Displays a form to edit an existing Documento entity.
     *
     */
    public function editAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('CespiIsoBundle:Documento')->find($id);
           
        
        /* Por poner campos de fecha 'text' y no 'date' (problema con chrome)*/
        $this->convertirFechasAString($entity);
        /* ACL *
        $securityContext = $this->get('security.context');

        // verifica el acceso para ediciÃ³n
        if (false === $securityContext->isGranted('EDIT', $entity))
        {
            throw new AccessDeniedException();
        }
        /* ACL */
        
        if (!$this->esEditor($entity->getId())) {
            throw new AccessDeniedException('Acceso restringido. No sos editor del documento.');
            
        }
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Documento entity.');
        }
        
        $this->cargarRoles($entity);
        
        $editForm = $this->createEditForm($entity);
       
        $deleteForm = $this->createDeleteForm($id);
        
        return $this->render('CespiIsoBundle:Documento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Documento entity.
    *
    * @param Documento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Documento $entity)
    {
        $form = $this->createForm(new DocumentoType(), $entity, array(
            'action' => $this->generateUrl('documento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'marg btn btn-primary btn-sm')));

        return $form;
    }
    
    public function grabarRoles(&$entity, $em, $request){
          
        $id_documento = $entity->getId();
        $relaciones = $request->get('cespi_bundle_isobundle_documento');
        $roles = $em->getRepository('CespiIsoBundle:Rol')->findAll();

		$em2 = $this->getDoctrine()->getManager();
        $entidades = $em2->getRepository('CespiIsoBundle:DocumentoUsuarios')->findByIdDocumento($id_documento);
		foreach ($entidades as $enti){
			$em2->remove($enti);
			$em2->flush();
		}

        foreach ($roles as $rol) {
            if (isset($relaciones[strtolower($rol->getNombre())])) {
                
                $personas = $relaciones[strtolower($rol->getNombre())];
                foreach ($personas as $persona) {
                    $entityd = new DocumentoUsuarios();
                    $entityd->setIdRol($rol->getId());
                    $entityd->setIdUsuario($persona);
                    $entityd->setIdDocumento($id_documento);
                    $em->persist($entityd);
                    $em->flush();
                }
            }
        }
    
    }
   
    private function convertirStringAFecha(&$entity) {
        $entity->setFechaAprobado(date_create_from_format('d/m/Y', $entity->getFechaAprobado())); //sacar cuando se use tipo date
        $entity->setFechaCreacion(date_create_from_format('d/m/Y', $entity->getFechaCreacion())); //sacar cuando se use tipo date
        $entity->setFechaRevision(date_create_from_format('d/m/Y', $entity->getFechaRevision())); //sacar cuando se use tipo date
        $entity->setFechaVigencia(date_create_from_format('d/m/Y', $entity->getFechaVigencia())); //sacar cuando se use tipo date
    }
    private function convertirFechasAString(&$entity) {
        
        $entity->setFechaAprobado($entity->getFechaAprobado()->format('d/m/Y')); //sacar cuando se use tipo date
        $entity->setFechaCreacion($entity->getFechaCreacion()->format('d/m/Y')); //sacar cuando se use tipo date
        $entity->setFechaRevision($entity->getFechaRevision()->format('d/m/Y')); //sacar cuando se use tipo date
        $entity->setFechaVigencia($entity->getFechaVigencia()->format('d/m/Y')); //sacar cuando se use tipo date
        
        
    }
    /**
     * Edits an existing Documento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:Documento')->find($id);
        
        if (!$this->esEditor($entity->getId())) {
            throw new AccessDeniedException('Acceso restringido. No sos editor del documento.');
            
        }
        
        
        $existelog = $em->getRepository('CespiIsoBundle:DocumentoLog')->findOneByIdDocumento($id);
        if (!$existelog) { $this->guardarLog($entity,true); }
        
            
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Documento entity.');
        }
        
        $this->cargarRolesEnBlanco($entity);
                
        $deleteForm = $this->createDeleteForm($id);
         
        /* Por poner campos de fecha 'text' y no 'date' (problema con chrome)*/
        $this->convertirFechasAString($entity);
        /* */  
        $editForm = $this->createEditForm($entity);
        
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
          
        /* Por poner campos de fecha 'text' y no 'date' (problema con chrome)*/    
        $this->convertirStringAFecha($entity);
                
            $this->cargarRolesEnBlancoUsuario($entity);
            $tipo_singuardar = $entity->getTipo();
            $entity->setTipo($tipo_singuardar);
            $em->flush();
            
            $em->refresh($entity);
            
            $entity->setTipo($tipo_singuardar);
            
            $em->flush();
            $this->grabarRoles($entity, $em, $request);
            
            $this->guardarLog($entity);
            
            
            $this->get('session')->getFlashBag()->add('success', 'Se guardaron los cambios');
            
            return $this->redirect($this->generateUrl('documento_edit', array('id' => $id)));
        }else{
            $this->get('session')->getFlashBag()->add('error', 'Verifique los datos ingresados');
        }
        return $this->render('CespiIsoBundle:Documento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Documento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CespiIsoBundle:Documento')->find($id);

            
            if (!$this->esEditor($entity->getId())) {
            throw new AccessDeniedException('Acceso restringido. No sos editor del documento.');
            
        }
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Documento entity.');
            }

            $em->remove($entity);
            $em->flush();
            
            $entities = $em->getRepository('CespiIsoBundle:DocumentoLog')->findByIdDocumento($id);
            foreach($entities as $entity ) {
            $em->remove($entity);
            }
            $em->flush();
            
        }

        return $this->redirect($this->generateUrl('documento'));
    }

    /**
     * Creates a form to delete a Documento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('documento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar','attr' => array('class' => 'btn btn-danger btn-sm')))
            ->getForm()
        ;
    }
}
