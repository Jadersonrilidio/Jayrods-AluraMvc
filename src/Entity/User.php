<?php

namespace Jayrods\AluraMvc\Entity;

use Exception;

class User implements Entity
{
    /**
     * @var ?int
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var ?string
     */
    private ?string $password;

    /**
     * 
     * @param  ?int  $id
     * @param  string  $email
     * @param  ?string  $password
     * 
     * @return void
     */
    public function __construct(?int $id, string $email, ?string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
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
    public function email()
    {
        return $this->email;
    }

    /**
     * 
     */
    public function password()
    {
        return $this->password;
    }
}
