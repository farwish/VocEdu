# voc

## categories 

https://github.com/lazychaser/laravel-nestedset#setting-up-from-scratch


## auto create four db related files

``` 
$ php artisan make:model Question -m    # -m will auto create migration file for you
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

## about Nova localization

https://github.com/franzdumfart/laravel-nova-localizations

## about Seed

``` 
$ php artisan migrate:fresh --seed

OR

$ php artisan db:seed --class=CategorySeeder
```


## jwt-auth

https://jwt-auth.readthedocs.io/en/develop/quick-start/

## swagger in laravel

annotation usage: https://github.com/DarkaOnLine/L5-Swagger/blob/master/tests/storage/annotations/OpenApi/Anotations.php

install and configuration: https://github.com/DarkaOnLine/L5-Swagger/wiki/Installation-&-Configuration
```
$ php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
$ php artisan l5-swagger:generate
```

always auto generate document, add below setting in .env file:
``` 
# l5-swagger: this setting for always auto generate new document on dev.
L5_SWAGGER_GENERATE_ALWAYS=true
```

swagger json docs: https://swagger.io/docs/specification/describing-parameters/

swagger-php docs: https://zircote.github.io/swagger-php/Getting-started.html

swagger-php 'ref' using example: https://github.com/zircote/swagger-php/tree/master/Examples/using-refs

swagger-php article: https://juejin.cn/post/6844903872222199822


