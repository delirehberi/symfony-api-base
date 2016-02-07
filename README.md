apicrud-sym
===============

A Symfony project created on February 5, 2016, 11:43 pm.

Installation
===============

### 1- Install dependencies

```
composer install
```

### 2- Generate JWT Keys


```
openssl genrsa -out var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
```