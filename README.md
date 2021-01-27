

## BlackCart E-Commerce API Challenge

### Information

- The API controller has been implemented in ApiController class
- GetProductRequest class is responsible for request validation  
- ProductsRepository - Logical interface between Product && ApiController
- Application test in GetProductTest class
  - test for invalid parameter
  - test for valid request
  - test for compare db and json information counts
- the implementation required a change route prefix at Index: app/Providers/RouteServiceProvider.php:40


### Installation
- cp .env.example .env 
- creating a database and fill DB_* values
- composer install
- php artisan migrate --seed

#### Settings for demo shopify

    https://demo4radek.myshopify.com/admin/
    radek@iip.pl /radek1234

    SHOPIFY_API_KEY=8c92d558cc5a89e59532f04dac694450
    SHOPIFY_API_PASSWORD=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
    SHOPIFY_API_SHARED_SECRET=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
    SHOPIFY_API_HOST=demo4radek.myshopify.com
    SHOPIFY_API_VERSION=2021-01

#### Settings for demo woocommerce

    https://plugins.yithemes.com/bf6001124e4afeb602367deb0d953af8/wp-admin/

    WOOCOMMERCE_API_HOST=plugins.yithemes.com/bf6001124e4afeb602367deb0d953af8
    WOOCOMMERCE_API_KEY=ck_524794ca7e437f752d65c3b3f1a1b44a8a32a57b
    WOOCOMMERCE_API_SHARED_SECRET=cs_fca36f7307f86565c4c59ff9d71138357e2d162f
    WOOCOMMERCE_API_VERSION=wc/v3


### Importing data 

    php artisan shopify:demo-update
    php artisan woocommerce:demo-update


### Testing API 

1. Run Laravel development server

        php artisan serve --port=8888

2. Tests - Web Browser

    http://localhost:8888/stores/1/products
   
    http://localhost:8888/stores/2/products
   
    http://localhost:8888/stores/error/products
   
3. Tests - console+curl

    curl -X GET http://localhost:8888/stores/1/products
   
    curl -X GET http://localhost:8888/stores/1/products
   
    curl -X GET http://localhost:8888/stores/2/products
   
    curl -X GET http://localhost:8888/stores/error/products

4. Tests - Application test
   
        php artisan test














  





