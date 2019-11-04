<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 03.11.19
 * Time: 13:31
 */
namespace Models;

use Phalcon\Mvc\Model;

class Api extends Model
{
    /** @var string */
    private $uuid;

    /** @var string */
    private $payload;

    /** @var string */
    private $createAt;

    /** @var string */
    private $modifyAt;

    public function initialize()
    {
        $this->setSource('robots');
    }

    public function beforeValidationOnCreate()
    {
        $this->uuid = new \Phalcon\Db\RawValue("uuid()");
        $this->createAt = new \Phalcon\Db\RawValue("now()");
    }

    public function beforeUpdate()
    {
        $this->modifyAt = new \Phalcon\Db\RawValue("now()");
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return json_decode($this->payload);
    }

    /**
     * @param array $payload
     */
    public function setPayload($payload)
    {
        $this->payload = json_encode($payload);
    }

    /**
     * @return string
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @return string
     */
    public function getModifyAt()
    {
        return $this->modifyAt;
    }
}
