<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'status'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function scopeQueryFilter(Builder $query, $search): Builder
    {
        if (empty($search)) {
            return $query;
        }
        return $query->likeWhere(['title', 'description'], $search);
    }

    public function scopeCategoryIds(Builder $query, ...$search): Builder
    {
        if (!count(flatData($search))) {
            return $query;
        }
        return $query->whereHas('category', function (Builder $query) use ($search) {
            $query->whereIn('categories.id', flatData($search));
        });
    }

    public function scopeActive(Builder $query, $value = 1): Builder
    {
        return $query->where('status', $value);
    }


    public function scopeTagIds(Builder $query, ...$values): Builder
    {
        if (!count(flatData($values))) {
            return $query;
        }
        return $query->whereHas('tags', function (Builder $query) use ($values) {
            $query->whereIn('tags.id', flatData($values));
        });
    }


    public function afterCreateProcess(): Post
    {
        $post = $this;
        $request = request();
        if ($request->filled('tags')) {
            $post->tags()->attach($request->input('tags'));
        }
        // your business logic here for after create
        return $post;
    }

    public function beforeUpdateProcess(): Post
    {
        $post = $this;
        $request = request();

        // your business logic here for before update

        return $post;

    }
    public function afterUpdateProcess(): Post
    {
        $post = $this;
        $request = request();
        $post->tags()->sync($request->input('tags', []));

        // your business logic here for after update

        return $post;
    }
    public function beforeDeleteProcess(): Post
    {
        $post = $this;
        $request = request();
        //your business logic here for before delete

        return $post;

    }
    public function afterDeleteProcess():Post
    {
        $post = $this;
        $request = request();
        //your business logic here for after delete

        return $post;


    }

    public function beforeChangeStatusProcess(): Post
    {
        $post = $this;
        $request = request();
        //your business logic here for before change status

        return $post;


    }

    public function afterChangeStatusProcess():Post
    {
        $post = $this;
        $request = request();
        //your business logic here for after change status

        return $post;

    }

    public function beforeRestoreProcess():Post
    {
        $post = $this;
        $request = request();
        //your business logic here for before restore

        return $post;

    }

    public function afterRestoreProcess():Post
    {
        $post = $this;
        $request = request();
        //your business logic here for after restore

        return $post;

    }

    public function beforeForceDeleteProcess():Post
    {
        $post = $this;
        $request = request();
        //your business logic here for before force delete

        return $post;


    }

    public function afterForceDeleteProcess():Post
    {
        $post = $this;
        $request = request();
        //your business logic here for after force delete

        return $post;

    }


}
