<?php

namespace App\Http\Controllers;


use Anil\FastApiCrud\Controller\CrudBaseController;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Exception;
use Plank\Mediable\Facades\MediaUploader;

class MediaController extends CrudBaseController
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct(
            model: Media::class,
            storeRequest: StoreMediaRequest::class,
            updateRequest: UpdateMediaRequest::class,
            resource: MediaResource::class
        );
    }

    public function store()
    {
        $data = resolve($this->storeRequest)->validated();
        $media = MediaUploader::fromSource($data['file'])
            ->toDestination('local', 'media')
            ->onDuplicateIncrement()
            ->upload();
        return $this->resource::make($media);
    }
    //
}
