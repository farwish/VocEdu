# voc

## categories 

https://github.com/lazychaser/laravel-nestedset#setting-up-from-scratch


## auto create four db related files

``` 
$ php artisan make:model Question -m
$ php artisan make:factory QuestionFactory --model=Question
$ php artisan make:seed QuestionSeeder
```

## many to many 

Many-to-many relation table is derived from the alphabetical order of the related model names.

Eloquent will join the two related model names in alphabetical order. However, you are free to override this convention. You may do so by passing a second argument to the belongsToMany method:

return $this->belongsToMany('App\Models\Role', 'role_user');

``` 
$ php artisan make:migration create_exam_member_table
```

## Nova localization

https://github.com/franzdumfart/laravel-nova-localizations

## Seed

``` 
$ php artisan migrate:fresh --seed

OR

$ php artisan db:seed --class=CategorySeeder
```


## jwt-auth

https://jwt-auth.readthedocs.io/en/develop/quick-start/


