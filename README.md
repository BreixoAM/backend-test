# Backend test

## Installation

Clone repository `git clone git@github.com:BreixoAM/backend-test.git`

Build and install dependencies (docker needed) `make start`

**The first time it takes a while to install all the dependencies, specially because of phpstan.**

## Execute tests

### Unit tests

`make unit`

### Behat tests

`make behat`

### Manual testing

Get beer by id:

`curl --request GET 'localhost:8080/api/beers/1'`

Search beer by food:

`curl --request GET 'localhost:8080/api/beers/search?food=banana'`
