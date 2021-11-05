<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'eco');

// Project repository
set('repository', 'git@github.com:pvs9/eco.git');

set('git_cache', true);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

set('composer_options', 'install --optimize-autoloader --no-dev');

set('keep_releases', 2);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('84.201.175.83')
    ->user('ezk')
    ->set('http_user', 'ezk')
    ->set('deploy_path', '/var/www/eco');

// Tasks

//task('npm', function () {
//    run('cd {{release_path}} && npm ci && npm run prod');
//});

task('rr-binary', function () {
    run('cd {{release_path}} && vendor/bin/rr get');
});

//after('deploy:vendors', 'npm');
after('deploy:vendors', 'rr-binary');


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

//task('rr-restart', function () {
//    /** rr restart подвисает и не завершает деплой */
//    run('sudo supervisorctl restart roadrunner');
//});
//
//after('deploy:symlink', 'rr-restart');
