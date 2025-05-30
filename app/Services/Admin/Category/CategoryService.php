<?php

namespace App\Services\Admin\Category;

use App\Models\Category;
use App\Services\BaseService;
use Throwable;

class CategoryService extends BaseService
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function createOrUpdate($data, $id = null)
    {
        try {
            return parent::createOrUpdate($data, $id);
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
