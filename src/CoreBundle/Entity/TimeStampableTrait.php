<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 6.02.2016
 * Time: 00:45
 */

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TimeStampableTrait
 * @package CoreBundle\Entity
 */
trait TimeStampableTrait
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $create_time;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $update_time;

    /**
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @param \DateTime $create_time
     * @return TimeStampableTrait
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    /**
     * @param \DateTime $update_time
     * @return TimeStampableTrait
     */
    public function setUpdateTime($update_time)
    {
        $this->update_time = $update_time;
        return $this;
    }


}