<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Base extends Model
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    const DELETED_AT = 'delete_time';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if ($this->defaultValue()) {
            $this->fill($this->defaultValue());
        }
    }

    public function defaultValue()
    {
        return [
            'status' => 1,
        ];
    }

}
