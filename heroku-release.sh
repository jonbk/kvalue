#!/bin/bash
set -e

php bin/console doctrine:migration:migrate -n
php bin/console cache:clear
php bin/console cache:warmup
