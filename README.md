# Laratasks #

Demonstrates laravel queues and demonstrates a notification and reminder system


## Notes from links: ##

---

In .env 

#Replace this line.
QUEUE_CONNECTION=sync 

#With this line.
QUEUE_CONNECTION=database

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
- inside ```schedule()``` method of App\Console\Kernel class
Can run artisan commands, ex.: ```$schedule->command('migrate:refresh --seed')->daily();```
- lots of time constraints available
- to run locally: php artisan schedule:work
- use cron to run on production machine
---
Mail
- make email: ```php artisan make:mail [mailName] --markdown=emails.etc```

---
Other tips:
- ```Log::info('this is logged')```

---

Notifications:
- use the 'Notifiable' trait on models to notify, added to user model by default
- various channels: mail, slack nexmo (SMS)
- add ```implements shouldQueue ``` after making a notification with ```make:notification```
- to notify: ``` $user->notify(new Notification()) ```
- notify non user: ``` Notification::route('mail', 'email@email.com')->route(etc...)->notify(new Notification())```
- make notifications table: ```php artisan notifications:table``` - see gotchas (4)

---
---

1. Set default queue to 'database' not sync

To add to the priority queue: ```dispatch((new Job)->onQueue('priority')); ``` * see gotchas (1)

---


Run this worker for this project with Supervisor/CRON:
-  ```php artisan queue:work --queue=priority,default --tries=2``` -> runs priority queue items first, allows 2 attempts before failing

- can run this line locally for development

---

# Gotchas #
1. secondary queues are not created in the config file, you can essentially dispatch to any string you want as long as the worker
knows to look for it
2. dd() inside an item being processed by the queue worker is displayed inside the terminal
3. DON'T make a custom notifications table like I tried, laravel makes one itself

