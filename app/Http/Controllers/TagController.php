<?php

namespace App\Http\Controllers;

use Anil\FastApiCrud\Controller\CrudBaseController;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\Tag\TagResource;
use App\Models\Tag;
use Exception;

class TagController extends CrudBaseController
{


    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct(
            model: Tag::class,
            storeRequest: StoreTagRequest::class,
            updateRequest: UpdateTagRequest::class,
            resource: TagResource::class,
        );
    }
}
