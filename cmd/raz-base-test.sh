#!/bin/sh
php app/console doctrine:schema:drop --force
php app/console doctrine:schema:update --dump-sql
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load