<?php

namespace Deployer;

if (! isset($_SERVER['PHP_SELF']) || 'dep' != substr($_SERVER['PHP_SELF'], -3)) {
    header("HTTP/1.0 404 Not Found");
    exit;
}

require 'recipe/statamic.php';
require_once 'contrib/npm.php';
require_once 'contrib/discord.php';

define('HOSTNAME_PRODUCTION', '@TODO');
define('HOSTNAME_STAGING', '');

define('STAGE_PRODUCTION', 'production');
define('STAGE_STAGING', 'staging');

define('BRANCH_PRODUCTION', 'main');
define('BRANCH_STAGING', 'staging');

set('keep_releases', 3);
set('application', 'MQR - Applicazione Statamic');
set('host', HOSTNAME_PRODUCTION);
set('default_stage', STAGE_PRODUCTION);
set('branch', BRANCH_STAGING);
set('repository', 'git@github.com:davideprevosto/statamic-test.git');
set('git_tty', true);

set('discord_channel', 'deploy');
set(
    'discord_webhook',
    ''
);
set(
    'discord_notify_text',
    function () {
        return [
            'text' => parse(
                ':information_source: **{{application}}** - **{{user}}** is deploying branch `{{branch}}` to _{{target}}_'
            ),
        ];
    }
);
set(
    'discord_success_text',
    function () {
        return [
            'text' => parse(
                ':white_check_mark: **{{application}}** - Branch `{{branch}}` deployed to _{{target}}_ successfully'
            ),
        ];
    }
);
set(
    'discord_failure_text',
    function () {
        return [
            'text' => parse(
                ':no_entry_sign: **{{application}}** - Branch `{{branch}}` has failed to deploy to _{{target}}_'
            ),
        ];
    }
);

add(
    'shared_files',
    [
        '.env',
        'public/robots.txt',
    ]
);
add(
    'shared_dirs',
    [
    ]
);
add('writable_dirs', []);
set('allow_anonymous_stats', false);

host(STAGE_PRODUCTION)
    ->setHostname(HOSTNAME_PRODUCTION)
    ->setRemoteUser('@TODO')
    ->setPort(22)
    ->set('labels', ['stage' => STAGE_PRODUCTION])
    ->set('branch', BRANCH_PRODUCTION)
    ->set('deploy_path', '@TODO')
    ->set(
        'bin/php',
        function () {
            return '/RunCloud/Packages/php81rc/bin/php';
        }
    )
    ->set(
        'bin/composer',
        function () {
            return '{{bin/php}} {{deploy_path}}/.dep/composer.phar';
        }
    );

host(STAGE_STAGING)
    ->setHostname(HOSTNAME_STAGING)
    ->setRemoteUser('staging')
    ->setPort(22)
    ->set('labels', ['stage' => STAGE_STAGING])
    ->set('branch', BRANCH_STAGING)
    ->set('deploy_path', '')
    ->set('cachetool_args', '--cli')
    ->set(
        'bin/php',
        function () {
            return '/RunCloud/Packages/php81rc/bin/php';
        }
    )
    ->set(
        'bin/composer',
        function () {
            return '{{bin/php}} {{deploy_path}}/.dep/composer.phar';
        }
    );


task(
    'artisan:migrate:seed',
    function () {
        $output = run('{{bin/php}} {{release_path}}/artisan migrate --seed --force');
        writeln('<info>' . $output . '</info>');
    }
)->desc('Esegue artisan migrate --seed');

task(
    'artisan:opcache:clear',
    function () {
        $output = run('{{bin/php}} {{release_path}}/artisan opcache:clear');
        writeln('<info>' . $output . '</info>');
    }
)->desc('Esegue opcache:clear');

task(
    'artisan:config:clear',
    function () {
        $output = run('{{bin/php}} {{release_path}}/artisan config:clear');
        writeln('<info>' . $output . '</info>');
    }
)->desc('Esegue php artisan config:clear');

task(
    'artisan:route:cache',
    function () {
        $output = run('{{bin/php}} {{release_path}}/artisan route:cache');
        writeln('<info>' . $output . '</info>');
    }
)->desc('Esegue php artisan route:cache');

task(
    'artisan:health',
    function () {
        $output = run('{{bin/php}} {{release_path}}/artisan config:clear');
        writeln('<info>' . $output . '</info>');

        $output = run('{{bin/php}} {{release_path}}/artisan health:check --fail-command-on-failing-check');
        writeln('<info>' . $output . '</info>');


        $output = run('{{bin/php}} {{release_path}}/artisan config:clear');
        writeln('<info>' . $output . '</info>');
    }
)->desc('Esegue health');

task('deploy', [
    'discord:notify',

    'deploy:prepare',
    'deploy:vendors',
    'deploy:clear_paths',

    'artisan:storage:link',

    'artisan:event:cache',
    'artisan:route:cache',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:optimize',
    'artisan:migrate:seed',
    'artisan:health',

    'statamic:search:update',
    'statamic:stache:clear',
    'statamic:stache:warm',

    'deploy:symlink',

    'artisan:opcache:clear',
    'artisan:queue:restart',

    'deploy:unlock',
    'deploy:cleanup',

    'discord:notify:success',
]);

after('deploy:failed', 'deploy:unlock');

after('deploy:failed', 'discord:notify:failure');
