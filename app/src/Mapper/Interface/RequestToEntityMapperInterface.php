<?php

namespace App\Mapper\Interface;

use App\Interfaces\PersistableInterface;

interface RequestToEntityMapperInterface
{

    public function toNewEntity(PersistableInterface $persistable): object;

    public function toExistingEntity(PersistableInterface $persistable, object $entity): object;
}
