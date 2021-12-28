#!/usr/bin/env bash

rm -fr app/config/parameters.yml
rm -fr app/cache/*
rm -fr app/logs/*

composer install

mkdir -p app/cache
mkdir -p app/logs
mysql -ujenkins -pjenkins -e "CREATE DATABASE jenkinsbuild"
cd app/config/travis-sql
for i in *; do mysql -ujenkins -pjenkins jenkinsbuild < ${i}; done;
cd ../../..
php app/console doctrine:cache:clear-metadata
php app/console cache:clear
php app/console assets:install --symlink web --no-debug
php app/console assetic:dump
php app/console asm:translations:dummy

ant

mysql -ujenkins -pjenkins -e "DROP DATABASE jenkinsbuild"
