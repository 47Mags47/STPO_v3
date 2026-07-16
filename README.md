# configs
## supervisor 
### reverb.conf
```
[program:reverb]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO/artisan reverb:start
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/STPO/storage/logs/reverb.log
stopwaitsecs=3600
```
### queue.conf
```
[program:queue-default]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO/artisan queue:work --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO/storage/logs/queue/default.log
stopwaitsecs=3600

[program:queue-notifications]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO/artisan queue:work --queue=notifications --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO/storage/logs/queue/notifications.log
stopwaitsecs=3600

[program:queue-files]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO/artisan queue:work --queue=files --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO/storage/logs/queue/files.log
stopwaitsecs=3600

[program:queue-SFR-FSD]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO/artisan queue:work --queue=SFR-FSD --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=8
redirect_stderr=true
stdout_logfile=/var/www/STPO/storage/logs/queue/SFR-FSD.log
stopwaitsecs=3600
```
