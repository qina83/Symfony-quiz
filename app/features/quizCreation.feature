# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature:
    In order to play to a quiz game
    as player
    I want to start with a new quiz, answer to question and know my score

    Scenario: Creation of new quiz
        Given a player named "player1"
        When player start a new quiz
        Then his score must be 0
        And next question must be 0

    Scenario: Answer correctly to a question
        Given a player named "player1"
        And player start a new quiz
        And player answer correctly to a question
        Then his score must be 1
        And next question must be 1

    Scenario: Answer wrongly to a question
        Given a player named "player1"
        And player start a new quiz
        And player answer wrongly to a question
        Then his score must be 0
        And next question must be 1