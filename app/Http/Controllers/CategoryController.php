<?php

namespace App\Http\Controllers;

use Anil\FastApiCrud\Controller\CrudBaseController;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Exception;

class CategoryController extends CrudBaseController
{

    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct(
            model: Category::class,
            storeRequest: StoreCategoryRequest::class,
            updateRequest: UpdateCategoryRequest::class,
            resource: CategoryResource::class,
        );
    }

}
