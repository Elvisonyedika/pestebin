# About the application

You work for a very big legal company with about 50,000 employees globally that is very serious on privacy and non disclosure and intellectual property protection. Lawyers on different teams usually share a lot of memos and snippets of old cases and reports. A member of the team discovers [Pastebin](https://pastebin.com/) but due to concerns on violating the company’s privacy policy decides against using it. Instead they come to you to build something similar for use within the company.

You are saddled with working on the API while a colleague builds the web frontend. 
The service should take a bunch of text and return a short url to the caller.
The service should allow you to set an expiry for content so that it self destructs after the said expiry date, however, expiry is optional.

## Running the application
### Docker
Download and install docker on your system.

Start the docker engine.

### Application
Make a copy of .env.example and rename it to .env.

Execute the docker command `docker compose up -d` in terminal.

### Documentation (SWAGGER)
Go to the url below to find list of all endpoints and usages.

http://localhost:8080/api/documentation
