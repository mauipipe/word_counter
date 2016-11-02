[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mauipipe/word_counter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mauipipe/word_counter/?branch=master)


# Word Counter
simple script to retrieve word occurrences ordered by occurrence and name.

# usage

The word counter is able to return the ordered count of the occurrences from 3 different text stream
* Sdtin: cat <text_file_path> | php bin/count_word
* Internal text file: php bin/count_word --source="<text_file_path>"
* Internal text file of random size: php bin/count_word --random=*<file_size>
* Wikipedia raw API: php bin/count_word --source="<wikipedia_raw_api_url>"

## Notice *<file_size>
The file size prefix allowed are KB,M,GB with only integer number
