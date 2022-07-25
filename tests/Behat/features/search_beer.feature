Feature:
    Search beers

    Scenario: I can search beers by food
        Given I send a "GET" request to "/api/beers/search?food=banana"
        Then the response status code should be 200
        And the response content should be:
        """
        [{
                "id": 20,
                "name": "Rabiator",
                "description": "Imperial Wheat beer / Weizenbock brewed by a homesick German in leather trousers. Think banana bread, bubble gum and David Hasselhoff."
            },
            {
                "id": 25,
                "name": "Bad Pixie",
                "description": "2008 Prototype beer, a 4.7% wheat ale with crushed juniper berries and citrus peel."
            },
            {
                "id": 45,
                "name": "The Physics",
                "description": "A hoppy Amber Ale that won World's Best Amber Beer in the World Beer Awards 2007. Malt and hops are in perfect harmony in this incredibly balanced beer. Biscuity, bitter and packing a surprisingly hoppy punch, this beer ultimately morphed into 5AM Saint."
            },
            {
                "id": 197,
                "name": "Moshi Moshi 15",
                "description": "A riot of C-hops, with layers of grapefruit, lime zest, pine needles, freshly cut grass, pungent resin, layered up on toasty malt with a touch of caramel sweetness."
            },
            {
                "id": 245,
                "name": "Beatnik",
                "description": "We gave our Equity Punks the keys to the brewery and let them brew the beer, as well as join Q&As and tour our HQ. The beer was voted on exclusively by Equity Punks."
            },
            {
                "id": 269,
                "name": "Small Batch: Imperial Pale Weizen",
                "description": "An amplified version of a style we first brewed with Weihenstephan. A full-on deluge of spice and citrus, the new world hops bring spiced orange, lemon peel and fresh grassy and floral notes while the weizen base adds pepper, clove and banana."
            }
        ]
        """
