<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Build With

-   [PHP 7.3.27](https://php.net) - The web language used
-   [Laravel 7.x](https://laravel.com) - The web framework used
-   [Composer v2.0.9](https://getcomposer.org) - Dependency Management
-   [Spattie](https://github.com/spatie/laravel-permission) - Associate users with roles and permissions
-   [Prettus 2.7](https://github.com/andersao/l5-repository) - Repositories to abstract the database layer

## Pre Requisite

-   Auth Using JWT
-   No Role for super-admin, just all permissons, configure via Gate::before at AuthServiceProvider ( seed the db )

## App Structure

    App
    ├── Commands                # Generated Custom Command Files
        ├── Stub                # Templating Files
        ├── (other files)       # Generator Setting Files

    ├── Modules
        ├── (name)              # Base and Common dir are root Templates
            ├── Api             # Action and Response method, Basically No Changes in here
            ├── Domain
                ├── Service     # Controllers
                ├── *Filter     # Additional Validation Rules
            ├── Repository
                ├── *RepositoryEloquent   # Model bindings
                ├── *Interface
            ├── (name)          # Model files
            ├── *Dto            # Set which model field that can be processed

## Commands

#### Generate Module

```
generate:module <name>          # Generate All Module Resources
generate:module <name> -a       # Default value (All)
generate:module <name> -api     # Generate Api Resources
generate:module <name> -d       # Generate Domain Resources
generate:module <name> -dto     # Generate Dto Resource
generate:module <name> -r       # Generate Repository Resource
```

#### Generate Api / Domain

```
generate:api/domain <name>      # Generate All Api Resources
generate:api/domain <name> -a   # Default value (All)
generate:api/domain <name> -c   # Generate Create Resources
generate:api/domain <name> -d   # Generate Delete Resources
generate:api/domain <name> -e   # Generate EditResources
generate:api/domain <name> -f   # Generate Fetch Resources
generate:api <name> -i          # Generate Index Resources (Api Only)
generate:domain <name> -l       # Generate List Resources (Domain Only)

Filter Files will auto generated
```

#### Generate Repository

```
generate:repository <name>      # Generate All Repository Resources
generate:repository <name> -a   # Default value (All)
generate:repository <name> -e   # Generate Eloquent Resources
generate:repository <name> -i   # Generate Interface Resources
```

#### Generate Job

```
generate:job <name> <name_space> <model>      # Generate Job Resources
```

### Contributors

-   **[Kamim](https://github.com/nahja97)**
-   **[Nahja97](https://github.com/nahja97)**

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
