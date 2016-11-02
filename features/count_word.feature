Feature:
  In order to count the word occurrences in different stream
  As as console user
  I need a command that consume a source text stream and return a list odored by count and occurrence name

  @word_counter @internal_file @small
  Scenario: retrieve word occurrences from an internal file source ordered by occurrences and name
    Given there is a "small_text.txt" in my system
    When the "php" command "/../../bin/count_word --source=features/fixtures/small_text.txt"
    Then the result would be equal to:
    """
    mozart=7
    from=4
    and=3
    the=3
    a=2
    amadeus=2
    of=2
    see=2
    wolfgang=2
    1=1
    2=1
    5=1
    27=1
    1756=1
    1780=1
    1791=1
    ability=1
    age=1
    already=1
    ama=1
    as=1
    baptised=1
    before=1
    born=1
    by=1
    c=1
    childhood=1
    chrysostomus=1
    classical=1
    competent=1
    composed=1
    composer=1
    croce=1
    de=1
    december=1
    della=1
    detail=1
    disambiguation=1
    earliest=1
    encyclopedia=1
    english=1
    era=1
    european=1
    five=1
    fn=1
    for=1
    free=1
    german=1
    he=1
    here=1
    his=1
    in=1
    influential=1
    january=1
    johann=1
    johannes=1
    keyboard=1
    lf=1
    mo=1
    nepomuk=1
    on=1
    other=1
    page=1
    performed=1
    portrait=1
    prodigious=1
    prolific=1
    protected=1
    redirects=1
    royalty=1
    s=1
    salzburg=1
    semi=1
    showed=1
    t=1
    theophilus=1
    tsa=1
    uses=1
    v=1
    violin=1
    was=1
    wikipedia=1
    wolfgangus=1
    """

  @word_counter @wikipedia_page @small
  Scenario: retrieve word occurrences from Wikipedia raw API ordered by occurrences and name
    When the "php" command "/../../bin/count_word --source='https://en.wikipedia.org/w/index.php?title=Adalbert&action=raw'"
    Then the result would be equal to:
    """
    adalbert=38
    of=24
    german=14
    given=6
    name=6
    archbishop=5
    and=4
    margrave=4
    noble=4
    albert=3
    austrian=3
    bright=3
    died=3
    mainz=3
    prince=3
    1000=2
    1828=2
    1868=2
    1875=2
    1937=2
    also=2
    bavaria=2
    bohemian=2
    born=2
    duke=2
    football=2
    hamburg=2
    ii=2
    image=2
    include=2
    language=2
    magdeburg=2
    meaning=2
    missionary=2
    names=2
    or=2
    player=2
    politician=2
    see=2
    shining=2
    the=2
    tuscany=2
    von=2
    710=1
    723=1
    820=1
    875=1
    886=1
    910=1
    915=1
    936=1
    956=1
    971=1
    981=1
    985=1
    997=1
    1030=1
    1048=1
    1055=1
    1072=1
    1083=1
    1124=1
    1137=1
    1145=1
    1162=1
    1200=1
    1467=1
    1484=1
    1763=1
    1798=1
    1805=1
    1811=1
    1814=1
    1827=1
    1832=1
    1836=1
    1850=1
    1855=1
    1863=1
    1873=1
    1874=1
    1888=1
    1896=1
    1900=1
    1907=1
    1909=1
    1913=1
    1917=1
    1933=1
    1941=1
    1969=1
    1976=1
    1982=1
    2004=1
    8th=1
    a=1
    actor=1
    adal=1
    adalberht=1
    adalberto=1
    adalbrecht=1
    adelbart=1
    adelbert=1
    admiral=1
    albrecht=1
    alsace=1
    alternative=1
    artist=1
    astronomer=1
    austria=1
    ballenstedt=1
    begas=1
    berht=1
    bishop=1
    blanc=1
    bohemia=1
    botanist=1
    both=1
    bulgarian=1
    caption=1
    category=1
    century=1
    composer=1
    count=1
    czerny=1
    de=1
    derived=1
    egmond=1
    elbert=1
    falk=1
    from=1
    gender=1
    ger=1
    gyrowetz=1
    i=1
    iii=1
    infobox=1
    is=1
    italy=1
    ivrea=1
    kr=1
    kraus=1
    ladenberg=1
    languages=1
    leaders=1
    lorraine=1
    male=1
    masculine=1
    max=1
    may=1
    means=1
    mystic=1
    name2=1
    naval=1
    northumbrian=1
    officer=1
    painter=1
    pediatrician=1
    pilch=1
    pomerania=1
    pomeranian=1
    prague=1
    pronunciation=1
    prussia=1
    prussian=1
    refer=1
    related=1
    religious=1
    romanian=1
    royal=1
    saint=1
    salzburg=1
    saxony=1
    schnee=1
    schnizlein=1
    singer=1
    size=1
    spellings=1
    stifter=1
    surname=1
    to=1
    type=1
    u=1
    which=1
    words=1
    writer=1
    zafirov=1
    """

  @word_counter @stdin @nightly
  Scenario: retrieve word occurrences ordered by occurrences and name from stdin ordered by frequency and name
    When value "/fixtures/small_text.txt" is piped "php" command "/../../bin/count_word"
    Then the result would be equal to:
    """
    mozart=7
    from=4
    and=3
    the=3
    a=2
    amadeus=2
    of=2
    see=2
    wolfgang=2
    1=1
    2=1
    5=1
    27=1
    1756=1
    1780=1
    1791=1
    ability=1
    age=1
    already=1
    ama=1
    as=1
    baptised=1
    before=1
    born=1
    by=1
    c=1
    childhood=1
    chrysostomus=1
    classical=1
    competent=1
    composed=1
    composer=1
    croce=1
    de=1
    december=1
    della=1
    detail=1
    disambiguation=1
    earliest=1
    encyclopedia=1
    english=1
    era=1
    european=1
    five=1
    fn=1
    for=1
    free=1
    german=1
    he=1
    here=1
    his=1
    in=1
    influential=1
    january=1
    johann=1
    johannes=1
    keyboard=1
    lf=1
    mo=1
    nepomuk=1
    on=1
    other=1
    page=1
    performed=1
    portrait=1
    prodigious=1
    prolific=1
    protected=1
    redirects=1
    royalty=1
    s=1
    salzburg=1
    semi=1
    showed=1
    t=1
    theophilus=1
    tsa=1
    uses=1
    v=1
    violin=1
    was=1
    wikipedia=1
    wolfgangus=1
    """

  @word_counter @internal_random
  Scenario: retrieve word occurrences from a random size internal file ordered by occurrences and name
    Given my system have no random generated file "random_test.txt"
    When the "php" command "/../../bin/count_word --random=1M --test"
    Then there is a "random_size_text.txt" in my system
    And a valid result is return

  @word_counter @validation
  Scenario: return an error message when mandatory params are not sent
    When the "php" command "/../../bin/count_word --wrong-param"
    And error message should appear:
    """
    missing mandatory parameter: --source,--random
    """
