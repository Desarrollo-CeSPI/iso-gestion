<?php

namespace Cespi\Bundle\IsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AclEntries
 */
class AclEntries
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var integer
     */
    private $aceOrder;

    /**
     * @var integer
     */
    private $mask;

    /**
     * @var boolean
     */
    private $granting;

    /**
     * @var string
     */
    private $grantingStrategy;

    /**
     * @var boolean
     */
    private $auditSuccess;

    /**
     * @var boolean
     */
    private $auditFailure;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\AclObjectIdentities
     */
    private $objectentity;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\AclSecurityIdentities
     */
    private $securityentity;

    /**
     * @var \Cespi\Bundle\IsoBundle\Entity\AclClasses
     */
    private $class;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fieldName
     *
     * @param string $fieldName
     * @return AclEntries
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    /**
     * Get fieldName
     *
     * @return string 
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * Set aceOrder
     *
     * @param integer $aceOrder
     * @return AclEntries
     */
    public function setAceOrder($aceOrder)
    {
        $this->aceOrder = $aceOrder;

        return $this;
    }

    /**
     * Get aceOrder
     *
     * @return integer 
     */
    public function getAceOrder()
    {
        return $this->aceOrder;
    }

    /**
     * Set mask
     *
     * @param integer $mask
     * @return AclEntries
     */
    public function setMask($mask)
    {
        $this->mask = $mask;

        return $this;
    }

    /**
     * Get mask
     *
     * @return integer 
     */
    public function getMask()
    {
        return $this->mask;
    }

    /**
     * Set granting
     *
     * @param boolean $granting
     * @return AclEntries
     */
    public function setGranting($granting)
    {
        $this->granting = $granting;

        return $this;
    }

    /**
     * Get granting
     *
     * @return boolean 
     */
    public function getGranting()
    {
        return $this->granting;
    }

    /**
     * Set grantingStrategy
     *
     * @param string $grantingStrategy
     * @return AclEntries
     */
    public function setGrantingStrategy($grantingStrategy)
    {
        $this->grantingStrategy = $grantingStrategy;

        return $this;
    }

    /**
     * Get grantingStrategy
     *
     * @return string 
     */
    public function getGrantingStrategy()
    {
        return $this->grantingStrategy;
    }

    /**
     * Set auditSuccess
     *
     * @param boolean $auditSuccess
     * @return AclEntries
     */
    public function setAuditSuccess($auditSuccess)
    {
        $this->auditSuccess = $auditSuccess;

        return $this;
    }

    /**
     * Get auditSuccess
     *
     * @return boolean 
     */
    public function getAuditSuccess()
    {
        return $this->auditSuccess;
    }

    /**
     * Set auditFailure
     *
     * @param boolean $auditFailure
     * @return AclEntries
     */
    public function setAuditFailure($auditFailure)
    {
        $this->auditFailure = $auditFailure;

        return $this;
    }

    /**
     * Get auditFailure
     *
     * @return boolean 
     */
    public function getAuditFailure()
    {
        return $this->auditFailure;
    }

    /**
     * Set objectentity
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\AclObjectIdentities $objectentity
     * @return AclEntries
     */
    public function setObjectentity(\Cespi\Bundle\IsoBundle\Entity\AclObjectIdentities $objectentity = null)
    {
        $this->objectentity = $objectentity;

        return $this;
    }

    /**
     * Get objectentity
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\AclObjectIdentities 
     */
    public function getObjectentity()
    {
        return $this->objectentity;
    }

    /**
     * Set securityentity
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\AclSecurityIdentities $securityentity
     * @return AclEntries
     */
    public function setSecurityentity(\Cespi\Bundle\IsoBundle\Entity\AclSecurityIdentities $securityentity = null)
    {
        $this->securityentity = $securityentity;

        return $this;
    }

    /**
     * Get securityentity
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\AclSecurityIdentities 
     */
    public function getSecurityentity()
    {
        return $this->securityentity;
    }

    /**
     * Set class
     *
     * @param \Cespi\Bundle\IsoBundle\Entity\AclClasses $class
     * @return AclEntries
     */
    public function setClass(\Cespi\Bundle\IsoBundle\Entity\AclClasses $class = null)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return \Cespi\Bundle\IsoBundle\Entity\AclClasses 
     */
    public function getClass()
    {
        return $this->class;
    }
}
