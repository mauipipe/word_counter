Feature:
  In order to count the word occurrences in different stream
  As as console user
  I need a command that consume a source text stream and return a list odored by count and occurrence name

  Scenario: retrieve word occurrences from an internal file source
    Given there is a "small_text.txt" in my system
    When the "php" command "/../../bin/count_word.php --source=resources/small_text.txt"
    Then the result would be equal to:
    """
    running resources/small_text.txt
page=1
semi=1
protected=1
wolfgang=2
amadeus=2
mozart=7
from=4
wikipedia=1
the=3
free=1
encyclopedia=1
redirects=1
here=1
for=1
other=1
uses=1
see=2
disambiguation=1
c=1
1780=1
detail=1
portrait=1
by=1
johann=1
nepomuk=1
della=1
croce=1
german=1
v=1
lf=1
a=2
ama=1
de=1
s=1
mo=1
tsa=1
t=1
english=1
fn=1
1=1
27=1
january=1
1756=1
5=1
december=1
1791=1
baptised=1
as=1
johannes=1
chrysostomus=1
wolfgangus=1
theophilus=1
2=1
was=1
prolific=1
and=3
influential=1
composer=1
of=2
classical=1
era=1
born=1
in=1
salzburg=1
showed=1
prodigious=1
ability=1
his=1
earliest=1
childhood=1
already=1
competent=1
on=1
keyboard=1
violin=1
he=1
composed=1
age=1
five=1
performed=1
before=1
european=1
royalty=1

This process used 0sec for its computations
It spent 0 ms in system calls
real Usage 2097152
peak usage 846448
    """
