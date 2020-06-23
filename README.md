
## Coding challenge for Back-End Software Engineer

### How to setup locally
Instructions:
- clone repo to local device
- on the project directory, open terminal, excecute in your terminal `composer install`
- after installing composer dependencies, setup your local MySQL server, then create your a test DB
- copy project directory .env.example to .env, and then set local MySQL DB credentials and DB name
- then, execute `php artisan migrate --seed` in your terminal

## API Endpoint

##### # POST api/property
 - Create new Property

Payload:
- suburb  => required|string
- state   => required|string
- country => required|string

##### # GET /api/property/{id}
 - Get Property Record with Property Analytic & Analytic Type

Payload: None

##### # GET api/property/analytic/{id}
 - Get Property Analytic with Property & Analytic Type

Payload: NONE


##### # PUT /api/property/analytic/{id}
 - Update Property Analytic

Payload:
- property_id      => required|exists:properties,id|integer
- analytic_type_id => required|exists:analytic_types,id|integer
- value            => required|string

##### # POST api/property/summary/all

- Get All Summary by Property(suburb, state, country)

Payload:
- demography => ['required', Rule::in(['suburb', 'state', 'country']) ]
- name       => 'required|string',

note: i've included postman collection in the project root folder `Property API.postman_collection.json`