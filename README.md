
```angular2html

 copy .env.example .env
 edit .env
 php artisan key:generate
 php artisan migrate
 php artisan db:seed
```

## if you want any scope to be executed dynamically , in query params just pass the filters object from frontend in json format


```

//its url can be like this
http://localhost:8000/api/v1/posts?filters={"tagIds":[1,2],"categoryIds":[1,2],"queryFilter":"test"}
```
```php
//in the model your scope should be like  scope followed by ucfirst of the scope name for example



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
// scopes are better for query building  and reusability
```
