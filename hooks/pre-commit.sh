#!/bin/sh

#git diff HEAD  --name-only | grep ".php$"
git status --porcelain | grep -e '^[AM]\(.*\).php$' | cut -c 3-

echo "Starting: php-cs-fixer"

PHP_CS_FIXER="app/Vendor/bin/php-cs-fixer"
HAS_PHP_CS_FIXER=false

if [ -x ${PHP_CS_FIXER} ]; then
    HAS_PHP_CS_FIXER=true
fi

if ${HAS_PHP_CS_FIXER}; then
    git diff HEAD  --name-only | grep ".php$" | while read filename; do

        DOCKERIZED_PHP_CS_FIXER="docker-compose run cashfy-app bash -c \"app/Vendor/bin/php-cs-fixer fix --config=./.php_cs.dist --verbose '$filename'\"";
        echo ${DOCKERIZED_PHP_CS_FIXER}
        docker-compose run cashfy-app bash -c "app/Vendor/bin/php-cs-fixer fix --config=./.php_cs.dist --verbose '$filename'"
        #git add "$filename";
    done
else
    echo ""
    echo "Please install php-cs-fixer, e.g.:"
    echo ""
    echo "  composer require --dev fabpot/php-cs-fixer:dev-master"
    echo ""
fi

echo "Finishing: php-cs-fixer"