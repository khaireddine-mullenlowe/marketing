#!/usr/bin/env bash

php bin/console etl:run ../app/Etl/offer_base.xml
php bin/console etl:run ../app/Etl/offer_sale.xml
php bin/console etl:run ../app/Etl/offer_aftersale.xml
php bin/console etl:run ../app/Etl/terms_property.xml
php bin/console etl:run ../app/Etl/offer_funding.xml
php bin/console etl:run ../app/Etl/offer_myaudi_user.xml
