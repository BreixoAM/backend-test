Feature:
    Get the details of a beer

    Scenario: I can get a beer by id
        Given I send a "GET" request to "/api/beers/1"
        Then the response status code should be 200
        And the response content should be:
        """
        {
            "id": 1,
            "name": "Buzz",
            "description": "A light, crisp and bitter IPA brewed with English and American hops. A small batch brewed only once.",
            "imageUrl": "https:\/\/images.punkapi.com\/v2\/keg.png",
            "tagLine": "A Real Bitter Experience.",
            "firstBrewed": "09\/2007"
        }
        """

    Scenario: I get a Not Found exception if the id is not valid
        Given I send a "GET" request to "/api/beers/22222222"
        Then the response status code should be 404
