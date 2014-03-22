#Visitor
==============

Register your visitors, Page hists, and count for Laravel 4

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
php artisan migrate --package="weboap/visitor"
``` 

to migrate visitor table


## Step 4 

Publish Configuration

Run

``` php
php artisan config:publish weboap/visitor
``` 

to publish config to 
``` php
app/config/packages/weboap/visitor
``` 


## Step 5 (Optional)

Visit 
http://dev.maxmind.com/geoip/geoip2/geolite2/

download GeoLite2-City.mmdb

place it in

``` php
app/storage/geo/
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


Visitor::all();  // all records


Visitor::clicks(); //total of all clicks


Visitor::range($date_start, $date_end); // visitors count in a date range;


```


Enjoy!
 



