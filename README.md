# **emails Task**
to test you should have latest version of `docker` and `docker-compose`

## Test
1- `make init`

2- visit `http://localhost:8008/sheet/upload`

3- upload file and add _subject, body_ then submit

4- visit `http://localhost:15671/#/queues` username and password are rabbitmq

5- you will find `sheet_process` queue has one ready message to run

6- run `docker container exec -it mail_php bash`

7-  in the container terminal run `php yii rabbitmq/consume sheet_process`

8- `send_email` will have ready queues as much as valid emails in sheet

9- validation file added to `web/processedFiles`

10- to view processed Files list visit `http://localhost:8008/sheet/list`

11- you can download or view the file report.

12- OPTIONAL: Run `php yii rabbitmq/consume send_email` in php container opened in `step 6` to validate send email consume