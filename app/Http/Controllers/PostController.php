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

        //available properties for index method with callback function or without callback function
        //without callback function for eager loading
        $this->withAll = [
            'category',
            'tags'
        ];


        /*
        //with callback function for eager loading
        $this->withAll = [
            'category'=>function($query){
            //you can apply any query here
            },
            'tags'=>function($query){
            //you can apply any query here
            },
            'someOtherRelation'
        ];
        */


        // this can be used with callback function or without callback function like withAll for count relation data eager loading
        $this->withCount = [
            'category',
            'tags'
        ];


        // this can be used with callback function or without callback function like withAll for whereHas relation data eager loading
        $this->withAggregate = [
            'category' => 'name'
        ];

        //if you want to apply scopes without value for default index method
        $this->scopes = [
            'active'
        ];

        //if you want to apply scopes with value for default index method
        $this->scopeWithValue = [
            'active' => 1
        ];
        //end of index method properties


        //update method if you want to apply before update method like index method
        //$this->updateScopes = [];
        //$this->updateScopeWithValue = [];



        // available properties for show method with callback function or without callback function
        $this->loadAll = [
            'category',
            'tags'
        ];

        /*
          //with callback function for eager loading
          $this->loadAll = [
              'category'=>function($query){
              //you can apply any query here
              },
              'tags'=>function($query){
              //you can apply any query here
              },
             'someOtherRelation'
            ];
         */


        // this can be used with callback function or without callback function like loadAll for count relation data lazy loading
        $this->loadCount = [
            'category',
            'tags'
        ];
        // this can be used with callback function or without callback function like loadAll for whereHas relation data lazy loading
        $this->loadAggregate = [
            'category' => 'name'
        ];
        $this->loadScopes = [
            'active'
        ];
        $this->loadScopeWithValue = [
            'active' => 1
        ];
        //end of show method properties

        //properties for delete method
        $this->deleteScopes = [
            'active'
        ];
        $this->deleteScopeWithValue = [
            'active' => 1
        ];


        //available properties for changeStatus method
        $this->changeStatusScopes = [
            'active'
        ];
        $this->changeStatusScopeWithValue = [
            'active' => 1
        ];

        //available properties for restoreTrashed method
        $this->restoreScopes = [
            'active'
        ];
        $this->restoreScopeWithValue = [
            'active' => 1
        ];
    }
    //
}
