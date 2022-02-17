<?php
namespace Deployer;

require 'recipe/common.php';
require 'recipe/laravel.php';
require 'contrib/rsync.php';
require 'contrib/php-fpm.php';
require 'contrib/yarn.php';

// Project name
set('application', 'www.forexact.com');

// Project repository
set('repository', 'git@github.com:curder/nova-demo.git');

set('php_fpm_version', '');
set('php_fpm_service', 'php-fpm');
set('default_timeout', 3600);
set('php_fpm_command', 'sudo /sbin/service {{php_fpm_service}} reload'); // default 'sudo systemctl reload {{php_fpm_service}}'
set('http_user', 'nginx');
set('keep_releases', 3);
// Shared files/dirs between deploys
set('shared_dirs', [
    'storage',
]);
set('shared_files', [
    '.env',
]);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Rsync
set('rsync_src', __DIR__);
set('rsync_dest','{{release_path}}');
set('rsync', [
    'exclude' => [
        '.idea/',
        '.drone.yml',
        '.env*',
        '.git*',
        '.phpunit.result.cache',
        'deploy.php',
        'hosts.yaml',
        '/vendor/',
        '/node_modules/',
    ],
    'exclude-file'  => false,
    'include'       => [],
    'include-file'  => false,
    'filter'        => [],
    'filter-file'   => false,
    'filter-perdir' => false,
    'flags'         => 'rz', // Recursive, with compress
    'options'       => ['delete'],
    'timeout'       => 600,
]);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts
import(__DIR__ . '/hosts.yaml');

// Tasks

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'yarn:install',
    'yarn:run:prod',
    'deploy:publish',
    'php-fpm:reload',
]);

task('yarn:run:prod', function () {
    cd('{{release_or_current_path}}');
    run('yarn run prod');
});

after('deploy:failed', 'deploy:unlock');

// rsync local to remote server.
task('deploy:rsync', [
    'deploy:release',
    'rsync',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'deploy:publish',
    'php-fpm:reload',
])->desc('Deploy the project using rsync from local');
