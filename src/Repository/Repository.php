<?php

namespace Jayrods\AluraMvc\Repository;

use Jayrods\AluraMvc\Entity\Entity;

interface Repository
{
    public function all(): array;

    public function get(int $identifier): Entity;

    //todo
    // public function add(Entity $entity): Entity; 

    public function remove(int $identifier): bool;

    //todo
    // public function update(Entity $entity): Entity;
}