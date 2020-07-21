<?php

namespace Dolphin\Ting\Http\Controller;

use JsonSerializable;

class JsonResponse implements JsonSerializable
{
    /**
     * @var int
     */
    private $code;
    /**
     * @var array
     */
    private $data;
    /**
     * @var string
     */
    private $note;

    public function __construct ($date = [], $code = 0, $note = '')
    {
        $this->setCode($code);
        $this->setData($date);
        $this->setNote($note);
    }

    public function jsonSerialize()
    {
        return [
            'code' => $this->getCode(),
            'data' => $this->getData(),
            'note' => $this->getNote()
        ];
    }

    /**
     * @return int
     */
    public function getCode () : int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode (int $code) : void
    {
        $this->code = $code;
    }

    /**
     * @return array
     */
    public function getData ()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData ($data) : void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getNote () : string
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote (string $note) : void
    {
        $this->note = $note;
    }
}