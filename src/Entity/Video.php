<?php

namespace Jayrods\AluraMvc\Entity;

use Exception;
use InvalidArgumentException;

class Video implements Entity
{
    /**
     * @var ?int
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $title;

    /**
     * 
     * @param  string  $url
     * @param  ?int  $id
     * @param  string  $title
     * 
     * @return void
     */
    public function __construct(?int $id, string $url, string $title)
    {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
    }

    private function setUrl(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('False URL provided');
        }

        $this->url = $url;
    }

    /**
     * 
     * @param  int  $id
     * 
     * @return void
     */
    public function identify($id)
    {
        if (!is_null($this->id)) {
            throw new Exception('Error: Id is already defined');
        }

        $this->id = $id;
    }

    /**
     * 
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * 
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * 
     */
    public function title()
    {
        return $this->title;
    }
}
