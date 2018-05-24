@servers(['web' => ['tim@81.169.238.183']])

@task('deploy', ['on' => 'web'])
    cd /var/www/thelfensdrfer.de/subdomains/tool
    git fetch --all
    git reset --hard origin/master
    composer install --no-ansi --no-interaction --no-progress --no-scripts --optimize-autoloader --no-dev
    php artisan migrate --force
    php artisan cache:clear
@endtask
