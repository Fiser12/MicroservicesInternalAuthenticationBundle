# Microservices Internal Authentication Bundle

## Description

The purpose of this bundle is solved the internal comunications between symfony microservices for the authentification based in solved JWT.

If you have one microservice that generate the JWT and the clients send this to another microservices, this bundle is for the communication of the another microservice with the session microservice.

This system integrates the microservices authentication with a symfony system authentication.

## Configuration
### Installation

The code is in packagist hosted:
https://packagist.org/packages/fiser/microservices-internal-authentication

For install you can do:

```
composer require fiser/microservices-internal-authentication
```

### Configuration files
Paste in your security file of symfony this:
```
security:
    providers:
        user_api_provider:
            id: "fiser.microservices_internal_authentication.security.user_provider"

    firewalls:
        main:
            anonymous: ~
            guard:
                authenticators:
                    - "fiser.microservices_internal_authentication.security.authenticator"
            provider: user_api_provider

    access_control:
        - { path: ^/recipes/, roles: ROLE_USER }
```

In your config.yml you need to define this elements for configure the bundle:

```

TODO

```
