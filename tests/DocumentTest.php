<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 04.11.19
 * Time: 21:00
 */

use \Library\Api\Document as DocumentApi;

class DocumentTest extends \PHPUnit\Framework\TestCase
{
    public function testAddRecord()
    {
        $content = '{}';

        try {
            $DocumentApi = DocumentApi::addRecord(json_decode($content, true));
        } catch (\Library\Exception\DocumentCreateException $e) {
            print_r($e->getMessage());
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }

        print_r(json_encode($DocumentApi->getRecord()));
    }
}
