<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 04.11.19
 * Time: 20:00
 */
namespace Library\Api;

use Library\Exception\DocumentCreateException;
use Library\Exception\DocumentStatusException;
use Library\Exception\DocumentUpdateException;

class Document
{
    /** @var string */
    private $uuid;

    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Add new document
     * @param array $content
     * @return Document
     * @throws DocumentCreateException
     */
    public static function addRecord(array $content)
    {
        $Document = new \Models\Document();
        $Document->setPayload($content);
        if (!$Document->save()) {
            throw new DocumentCreateException($Document->getMessages());
        }

        $Document->isDraft();

        return new self($Document->getUuid());
    }

    /**
     * @return \Models\Document
     */
    public function getRecord(): \Models\Document
    {
        return \Models\Document::findFirst([
            'uuid = :uuid:',
            'bind' => ['uuid' => $this->uuid]
        ]);
    }

    /**
     * @param $page
     * @param $limit
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public static function getRecordsList($page, $limit)
    {
        $offset = ($page - 1) * $limit;

        return \Models\Document::find([
            'limit' => [
                'number' => $limit,
                'offset' => $offset
            ],
            'order' => 'id DESC'
        ]);
    }

    /**
     * @param $content
     * @return bool
     * @throws DocumentUpdateException
     */
    public function update($content)
    {
        $Document = $this->getRecord();
        $Document->setPayload($content);
        if (!$Document->save()) {
            throw new DocumentUpdateException($Document->getMessages());
        }

        return true;
    }

    /**
     * @return bool
     * @throws DocumentStatusException
     */
    public function publish()
    {
        $Document = $this->getRecord();
        try {
            $Document->isPublish();
        } catch (DocumentStatusException $e) {
            throw $e;
        }

        return false;
    }
}
