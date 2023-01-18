<?php

namespace Jayrods\AluraMvc\Entity;

use Exception;

class Video implements Entity
{
    /**
     * @var ?int
     */
    public $id;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $title;

    /**
     * @var ?string
     */
    public ?string $filePath = null;

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

    /**
     * 
     */
    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * 
     * @param  int  $id
     * 
     * @return void
     */
    public function identify($id): void
    {
        if (!is_null($this->id)) {
            throw new Exception('Error: Id is already defined');
        }

        $this->id = $id;
    }

    /**
     * 
     */
    public function id(): ?int
    {
        return $this->id;
    }

    /**
     * 
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * 
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * 
     */
    public function filePath(): ?string
    {
        return $this->filePath ?? null;
    }

    // /**
    //  * //todo
    //  */
    // public function __serialize(): array
    // {
    //     return array(
    //         'id'    => $this->id(),
    //         'url'   => $this->url(),
    //         'title' => $this->title(),
    //         'image' => $this->filePath()
    //     );
    // }
}
