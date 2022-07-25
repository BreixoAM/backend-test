# Backend test

## Installation

Clone repository `git@github.com:BreixoAM/backend-test.git`

Build and install dependencies (docker needed) `make start`

## Execute tests

### Unit tests

`make unit`

### Behat tests

`make behat`

### Manual testing

`curl --request GET 'localhost:8080/api/beers/search?food=banana'`
