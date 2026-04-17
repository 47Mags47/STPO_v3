# configs
## supervisor 
### default.conf
[program:STPOV3-queue-default]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO_v3/artisan queue:work --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO_v3/storage/logs/queue/default.log
stopwaitsecs=3600

[program:STPOV3-queue-SFR-FSD-ReadSFRFile]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO_v3/artisan queue:work --queue=SFR-FSD-ReadSFRFile --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO_v3/storage/logs/queue/SFR-FSD-ReadSFRFile.log
stopwaitsecs=3600

[program:STPOV3-queue-SFR-FSD-ReadPaymentFile]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO_v3/artisan queue:work --queue=SFR-FSD-ReadPaymentFile --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO_v3/storage/logs/queue/SFR-FSD-ReadPaymentFile.log
stopwaitsecs=3600

[program:STPOV3-queue-SFR-FSD-ReadTransitFile]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO_v3/artisan queue:work --queue=SFR-FSD-ReadTransitFile --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO_v3/storage/logs/queue/SFR-FSD-ReadTransitFile.log
stopwaitsecs=3600

[program:STPOV3:queue-SFR-FSD-WriteSFRFile]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/STPO_v3/artisan queue:work --queue=SFR-FSD-WriteSFRFile --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/STPO_v3/storage/logs/queue/SFR-FSD-WriteSFRFile.log
stopwaitsecs=3600
