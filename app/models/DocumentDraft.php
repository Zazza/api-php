<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 03.11.19
 * Time: 13:31
 */
namespace Models;

use Phalcon\Mvc\Model;

class DocumentDraft extends Model
{
    /** @var int */
    private $document_ptr_id;

    public function getSource()
    {
        return 'document_draft';
    }

    public function initialize()
    {
        $this->belongsTo('document_ptr_id', '\Models\Document', 'id', ['alias' => 'Document']);
    }

    public function setDocumentId($id)
    {
        $this->document_ptr_id = $id;
    }
}
