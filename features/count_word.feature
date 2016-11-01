Feature:
  In order to count the word occurrences in different stream
  As as console user
  I need a command that consume a source text stream and return a list odored by count and occurrence name

  Scenario: retrieve word occurrences from an internal file source
    Given there is a "text.txt" in my system
    When the command "php /../../bin/word_count.php"
    Then the result would be equal to:
    """
    {
      "hi":2,
      "boo":1
    }
    """
