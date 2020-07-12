# Billie Mars Time

### How to run the service
Make sure you have the following components installed on your system:
* Docker and Docker Compose

To run the application do the following steps in your terminal:
* `git clone git@github.com:mohammedabdoh/billie-mars-time.git`
* `cd billie-mars-time`
* `make clean install run`

To open the docs run:
* `make api-docs`

To run unit tests and functional tests run:
* `make test`

You can use `curl`, `Postman` or any other HTTP client to use the service.

An example of converting time on Earth:
```
curl http://localhost/mars-time/convert/2020-07-12T12:24:19+00:00
```

**Note:** The endpoint does not require authentication to work. This is only to complete the task. In case
of production ready micro services authentication can have different forms from simple username/password to 
using oAuth2 ;)
