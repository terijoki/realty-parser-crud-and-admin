#!/usr/bin/env bash

# Generate migration for Entities
php bin/console d:m:diff

# Execute migration
php bin/console d:m:m

# Clear cache
php bin/console c:c

# Load Fixttures
php bin/console d:f:l

mkdir var/images/banks
mkdir var/images/developers
mkdir var/images/buildings
mkdir var/images/news