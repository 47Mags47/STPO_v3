# configs
## supervisor 
### queue.conf
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
stdout_logfile=/var/www/STPO/storage/logs/queue/default.log
stopwaitsecs=3600

[program:queue-SFR-FSD-ReadSFRFile]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO/artisan queue:work --queue=SFR-FSD-ReadSFRFile --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO/storage/logs/queue/SFR-FSD-ReadSFRFile.log
stopwaitsecs=3600

[program:queue-SFR-FSD-ReadPaymentFile]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO/artisan queue:work --queue=SFR-FSD-ReadPaymentFile --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO/storage/logs/queue/SFR-FSD-ReadPaymentFile.log
stopwaitsecs=3600

[program:queue-SFR-FSD-ReadTransitFile]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO/artisan queue:work --queue=SFR-FSD-ReadTransitFile --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO/storage/logs/queue/SFR-FSD-ReadTransitFile.log
stopwaitsecs=3600

[program:queue-SFR-FSD-WriteSFRFile]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO/artisan queue:work --queue=SFR-FSD-WriteSFRFile --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO/storage/logs/queue/SFR-FSD-WriteSFRFile.log
stopwaitsecs=3600

### reverb.conf
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
