<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 03.11.19
 * Time: 13:31
 */
namespace Models;

use Library\Exception\DocumentStatusException;
use Phalcon\Mvc\Model;

class Document extends Model
{
    /** @var int */
    private $id;

    /** @var string */
    private $uuid;

    /** @var string */
    private $payload;

    /** @var string */
    private $createAt;

    /** @var string */
    private $modifyAt;

    public function getSource()
    {
        return 'document';
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    public function isDraft()
    {
        $DocumentDraft = new \Models\DocumentDraft();
        $DocumentDraft->setDocumentId($this->id);
    }

    public function isPublish()
    {
        $DocumentDraft = \Models\DocumentDraft::findFirst([
            'document_ptr_id = :id:',
            'bind' => ['id' => $this->id]
        ]);
        if (!$DocumentDraft->delete()) {
            throw new DocumentStatusException();
        }

        $DocumentPublish = new \Models\DocumentPublish();
        $DocumentPublish->setDocumentId($this->getId());
    }
}
