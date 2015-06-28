#Visitor
==============

Register your visitors, Page hits for Laravel 5  

for laravel 4 use ver v1.0.0

### Installation


The recommended way to install Winput is through composer.

## Step 1

Just add to  `composer.json` file:

``` json
{
    "require": {
        "weboap/visitor": "dev-master"
    }
}
```

then run 
``` php
php composer.phar update
```

## Step 2

Add
``` php
'Weboap\Visitor\VisitorServiceProvider'
``` 

to the list of service providers in app/config/app.php

## Step 3 

Migrate the Visitor Table
Run

``` php
php artisan vendor:publish
``` 
then

``` php
php artisan migrate
``` 
to migrate visitor table

the config.php will be copied to /config at the same time

``` php
/config/visitor.php
```

costumize it accordinly



## Step 5 (Optional)

Visit 
http://dev.maxmind.com/geoip/geoip2/geolite2/

download GeoLite2-City.mmdb

place it in (create the geo directory)

``` php
storage/geo/
```
or where ever you want just adjust the package config to reflect the new location,
it's used to geo locate visitors




###  Usage



``` php


Visitor::log();   //log in db visitor ip, geo location, hit counter


Visitor::get();
Visitor::get( $ip );   //fetch ip record



Visitor::forget( $ip ); //delete ip from log


Visitor::has( $ip );   // checkk if visitor ip exist in log


Visitor::count()  // return count of all site registred unique visitors


Visitor::all();  // all records as array

Visitor::all(true);  // all records as collection


Visitor::clicks(); //total of all clicks


Visitor::range($date_start, $date_end); // visitors count in a date range;


```
###Credits
This product Uses GeoLite2 data created by MaxMind, whenever available.

Enjoy!
 


