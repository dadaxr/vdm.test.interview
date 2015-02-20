---
## VDM Test Interview
1. cloner le repo
2. faire un vhost pointant sur le dossier /public/
3. installer & activer le [driver php mongo] (http://pecl.php.net/package/mongo)
4. **configurer votre environnement : renommer le fichier '.env.example' ( à la racine du projet )  en '.env'**
*Attention a bien saisir le user/mdp fourni dans l'email pour vous connecter à l'instance mongo distante*
5. tester la connexion au serveur mongodb via l'url : *http://your.domain.com/api/vdm/*


#Ligne de commande :

ouvrir un terminal, se mettre à la racine du projet et executer la commande pour alimenter la bdd :


    php artisan (permet de lister les commandes dispo)

    php artisan vdm:sniffer

> option par défaut : 10 posts, possibilité de surcharger via l'option --posts-count=X

    php artisan vdm:sniffer --posts-count=20



# API REST

tester les routes :

> http://your.domain.com/api/vdm/

> http://your.domain.com/api/vdm/posts

> http://your.domain.com/api/vdm/posts/54e6792e33b55c78130001b0

> http://your.domain.com/api/vdm/posts?from=2015-02-20

> http://your.domain.com/api/vdm/posts?to=2015-02-21

> http://your.domain.com/api/vdm/posts?from=2015-02-20&to=2015-02-21

> http://your.domain.com/api/vdm/posts?author=Seuneuceufeu

* - pour optimiser l'affichage dans le navigateur rajouter le dd=true :*

> http://your.domain.com/api/vdm/posts/54e6792e33b55c78130001b0&dd=true


## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/downloads.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
