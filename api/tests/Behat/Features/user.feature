Feature: User Feature
    Scenario: Get list of users
        Given I set payload
        """
        {
          "username": "admin",
          "password": "password"
        }
        """
        Given I log in
        When I request to "GET" "/users"
        Then The response status code should be 200
        And The "content-type" header response should exist
        And The "content-type" header response should be "application/ld+json; charset=utf-8"
