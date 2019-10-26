<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdTask
 *
 * @ORM\Table(name="ad_task")
 * @ORM\Entity
 */
class AdTask
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_task", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="ad_task_id_task_seq", allocationSize=1, initialValue=1)
     */
    private $idTask;

    /**
     * @var string
     *
     * @ORM\Column(name="description_task", type="string", length=100, nullable=false)
     */
    private $description_task;

    /**
     * @var Date
     *
     * @ORM\Column(name="fcinit_task", type="date", nullable=false)
     */
    private $fcinit_task;

    /**
     * @var \integer
     *
     * @ORM\Column(name="userwt_task", type="integer", nullable=false)
     */
    private $userwt_task;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="state_task", type="integer", nullable=false)
     */
    private $state_task;

    /**
     * @var \integer
     *
     * @ORM\Column(name="useradd_task", type="integer", nullable=false)
     */
    private $useradd_task;

    /**
     * @var \integer
     *
     * @ORM\Column(name="evento_task", type="integer", nullable=false)
     */
    private $evento_task;

    /**
     * Get idTask
     *
     * @return integer
     */
    public function getidTask()
    {
        return $this->idTask;
    }

     /**
     * Set idTask
     *
     * @param integer $idTask
     *
     * @return AdTask
     */
    public function setidTask($idTask)
    {
        $this->idTask = $idTask;

        return $this;
    }

    /**
     * Set description_task
     *
     * @param string $description_task
     *
     * @return AdTask
     */
    public function setdescription_task($description_task)
    {
        $this->description_task = $description_task;

        return $this;
    }

    /**
     * Get description_task
     *
     * @return string
     */
    public function getdescription_task()
    {
        return $this->description_task;
    }

    /**
     * Set fcinit_task
     *
     * @param Date $fcinit_task
     *
     * @return AdTask
     */
    public function setfcinit_task($fcinit_task)
    {
        $this->fcinit_task = $fcinit_task;

        return $this;
    }

    /**
     * Get fcinit_task
     *
     * @return Date
     */
    public function getfcinit_task()
    {
        return $this->fcinit_task;
    }

    /**
     * Set userwt_task
     *
     * @param \integer $userwt_task
     *
     * @return AdTask
     */
    public function setuserwt_task($userwt_task)
    {
        $this->userwt_task = $userwt_task;

        return $this;
    }

    /**
     * Get userwt_task
     *
     * @return \integer
     */
    public function getuserwt_task()
    {
        return $this->userwt_task;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return AdTask
     */
    public function setid($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getid()
    {
        return $this->id;
    }

    /**
     * Set state_task
     *
     * @param integer $state_task
     *
     * @return AdTask
     */
    public function setstate_task($state_task)
    {
        $this->state_task = $state_task;

        return $this;
    }

    /**
     * Get state_task
     *
     * @return integer
     */
    public function getstate_task()
    {
        return $this->state_task;
    }

    /**
     * Set useradd_task
     *
     * @param \integer $useradd_task
     *
     * @return AdTask
     */
    public function setuseradd_task($useradd_task)
    {
        $this->useradd_task = $useradd_task;

        return $this;
    }

    /**
     * Get useradd_task
     *
     * @return \integer
     */
    public function getuseradd_task()
    {
        return $this->useradd_task;
    }
    
    
    
    /**
     * Set evento_task
     *
     * @param \integer $evento_task
     *
     * @return AdTask
     */
    public function setevento_task($evento_task)
    {
        $this->evento_task = $evento_task;

        return $this;
    }

    /**
     * Get evento_task
     *
     * @return \integer
     */
    public function getevento_task()
    {
        return $this->evento_task;
    }
}
