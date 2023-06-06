```angular2html

php artisan tinker

//paste this code
\App\Models\Category::factory(4)->has(
        \App\Models\Post::factory()->count(3)->has(
            \App\Models\Tag::factory()->count(5)
        )
    )
->create();
```
