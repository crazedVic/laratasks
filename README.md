# Laratasks #

Demonstrates laravel queues and demonstrates a notification and reminder system


## Notes from links: ##
---

Queues
- multiple queues allowed with multiple names, different queues can have different priorities
- config @ config/queue.php
- Make Queue table: ```php artisan queue:table```, ```php artisan migrate```
- Start Queue:  ```php artisan queue:work```

Jobs
- stored in app/Jobs
- ```php artisan make:job [jobName]```
- ```[jobName]::dispatch([$params])``` , also dispatchIf/dispatchUnless
- can delay, ex.: ```->delay(now()->addMinute())```
- can chain jobs
- can change max attempts, ex.: ```php artisan queue:work --tries=3``` or right inside job: ```public $tries = X```
- job processing goes inside ```handle()``` function

Failed Jobs
- Make failed jobs table: ```php artisan queue:failed-table```, ```php artisan migrate```
---
Schedules
- inside ```schedule()``` methd of App\Console\Kernel class
Can run artisan commands, ex.: ```$schedule->command('migrate:refresh --seed')->daily();```
- lots of time constraints available
- to run locally: php artisan schedule:work
- use cron to run on production machine
---
Mail Queue
- make email: ```php artisan make:mail [mailName]```

---
Other tips:
- ```Log::info('this is logged')```