#### Pre-requisites
  - PHP >= 7.0.0
  - MySQL
  - Composer
#### Setup 
 - Composer install
    ~~~~
    $ composer install
    ~~~~
 - Genarate autoload
    ~~~~
    $ composer dump-autoload
    ~~~~
 - Copy env
    ~~~~
    $ cp .env.example .env
#### Run web server
~~~~
$ php -S 127.0.0.1:8000 -t public
~~~~
#### API Document
 - Get gross price
    - Path: /cart/{user_id}
    - Method: GET
    - Header
        - Authorization: $2y$12$0/O/xU1uTShyNx7SGnQr.eVTKCYrBCnDgbsmfL/T8W660PN.kjpsq
    - Response:
        - 200
            ~~~~
            {
                "message": "success",
                "data": 36013.4
            }
        - 400
            ~~~~
            {
                "message": "User not found"
            }
        - 404
        - 401
 - Edit Coefficient
    - Path: /fee/{type}
    - Method: POST
    - Params:
        - fee: required|number
    - Header:
        - Authorization: $2y$12$UPyFy2fhM5tp8mVrYh8wV.uKoqWCPaMEdx7P260LZZp2G72tNtkC6
    - Response:
        - 200:
            ~~~~
            {
                "message": "success",
                "data": {
                    "id": "1",
                    "type": "jewelry",
                    "fee": "11"
                }
            }
        - 400
            ~~~~
            {
                "message": "Coefficient not found"
            }
        - 404
        - 401
        - 422
 - Edit Coefficient
     - Path: /coefficient/{name}
     - Method: POST
     - Params:
         - value: required|number
     - Header:
         - Authorization: $2y$12$UPyFy2fhM5tp8mVrYh8wV.uKoqWCPaMEdx7P260LZZp2G72tNtkC6
     - Response:
         - 200:
             ~~~~
             {
                 "message": "success",
                 "data": {
                     "id": "1",
                     "name": "weight",
                     "value": "12"
                 }
             }
         - 400
             ~~~~
             {
                 "message": "Coefficient not found"
             }
         - 404
         - 401
         - 422
#### Run unit test
~~~~
$ ./vendor/bin/phpunit
~~~~

#### Database example
~~~~
$ test.sql