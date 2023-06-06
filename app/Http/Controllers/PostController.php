<?php

namespace App\Http\Controllers;

use Anil\FastApiCrud\Controller\CrudBaseController;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Exception;

class PostController extends CrudBaseController
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct(
            model: Post::class,
            storeRequest: StorePostRequest::class,
            updateRequest: UpdatePostRequest::class,
            resource: PostResource::class,
        );

        $this->withAll = [
            'category',
            'tags'
        ];
        $this->withCount = [
            'category',
            'tags'
        ];
        $this->withAggregate = [
            'category' => 'name'
        ];
    }
    //
}
