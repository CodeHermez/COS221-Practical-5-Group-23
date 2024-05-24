## Function: GetRecommendations

## Method: (GET)

#### URL:

```uri
http://localhost/COS221-Practical-5-Group-23/api/GetRecommendations.php
```

### Description

This function handles a GET request to retrieve recommended titles for a user.

### Parameters (if a parameter has an asterisk{*} next to it, it means this key is required)

- *`username` (string): The username of the user

### Returns

aining the response.

- `status` (string): Status of the request, either "success" or "error".

- `timestamp` (integer): The time in at which the request was made.

- `data` (Array<JSON>): If successful, contains the requested user recommendation data in array form of json object elemets.
  
  - `title` (string): The title of the title you want to retrieve
  
  - `genre` (string): the string of genres associated with the title
  
  - `release_date` (integer): The year at which the title was release
  
  - `description` (string): The description of the title
  
  - `content_rating` (string): The age restriction of the title

### Example Request (personal)

```uri
http://localhost/COS221-Practical-5-Group-23/api/GetRecommendations.php?username=alex_wong
```

### Example Response (personal)

```json
{
    "status": "success",
    "timestamp": 1716550708,
    "data": [
        {
            "title": "Pet Sematary",
            "genre": "horror,fantasy,thriller",
            "release_date": "1989",
            "description": "Dr. Louis Creed's family moves into the country house of their dreams and discover a pet cemetery at the back of their property. The cursed burial ground deep in the woods brings the dead back to life -- with \"minor\" problems. At first, only the family's cat makes the return trip, but an accident forces a heartbroken father to contemplate the unthinkable.",
            "content_rating": "18"
        },
        {
            "title": "Thir13en Ghosts",
            "genre": "horror,fantasy,thriller",
            "release_date": "2001",
            "description": "Arthur and his two children, Kathy and Bobby, inherit his Uncle Cyrus's estate: a glass house that serves as a prison to 12 ghosts. When the family, accompanied by Bobby's Nanny and an attorney, enter the house they find themselves trapped inside an evil machine \"designed by the devil and powered by the dead\" to open the Eye of Hell. Aided by Dennis, a ghost hunter, and his rival Kalina, a ghost rights activist out to set the ghosts free, the group must do what they can to get out of the house alive.",
            "content_rating": "18"
        },
        {
            "title": "Monty Python and the Holy Grail",
            "genre": "fantasy,comedy",
            "release_date": "1975",
            "description": "King Arthur, accompanied by his squire, recruits his Knights of the Round Table, including Sir Bedevere the Wise, Sir Lancelot the Brave, Sir Robin the Not-Quite-So-Brave-As-Sir-Lancelot and Sir Galahad the Pure. On the way, Arthur battles the Black Knight who, despite having had all his limbs chopped off, insists he can still fight. They reach Camelot, but Arthur decides not  to enter, as \"it is a silly place\".",
            "content_rating": "PG"
        },
        {
            "title": "Christine",
            "genre": "horror,thriller",
            "release_date": "1983",
            "description": "Geeky student Arnie Cunningham falls for Christine, a rusty 1958 Plymouth Fury, and becomes obsessed with restoring the classic automobile to her former glory. As the car changes, so does Arnie, whose newfound confidence turns to arrogance behind the wheel of his exotic beauty. Arnie's girlfriend Leigh and best friend Dennis reach out to him, only to be met by a Fury like no other.",
            "content_rating": "18"
        },
        {
            "title": "Last Action Hero",
            "genre": "fantasy,comedy",
            "release_date": "1993",
            "description": "Danny is obsessed with a fictional movie character action hero Jack Slater. When a magical ticket transports him into Jack's latest adventure, Danny finds himself in a world where movie magic and reality collide. Now it's up to Danny to save the life of his hero and new friend.",
            "content_rating": "PG 13"
        },
        {
            "title": "Goosebumps",
            "genre": "horror,fantasy",
            "release_date": "1995",
            "description": "Anything can turn spooky in this horror anthology series based on the best-selling books by master of kid horror, R.L. Stine. In every episode, see what happens when regular kids find themselves in scary situations, and how they work to confront and overcome their fears.",
            "content_rating": "PG 9"
        },
        {
            "title": "Anaconda",
            "genre": "horror,thriller",
            "release_date": "1997",
            "description": "A \"National Geographic\" film crew is taken hostage by an insane hunter, who takes them along on his quest to capture the world's largest - and deadliest - snake.",
            "content_rating": "PG 13"
        },
        {
            "title": "The Devil's Advocate",
            "genre": "horror,thriller",
            "release_date": "1997",
            "description": "Aspiring Florida defense lawyer Kevin Lomax accepts a job at a New York law firm. With the stakes getting higher every case, Kevin quickly learns that his boss has something far more evil planned.",
            "content_rating": "PG"
        },
        {
            "title": "I Know What You Did Last Summer",
            "genre": "horror,thriller",
            "release_date": "1997",
            "description": "After four high school friends are involved in a hit-and-run road accident, they dispose of the body and vow to keep the incident a secret. A year later, they each start receiving anonymous letters bearing the warning \"I Know What You Did Last Summer.\"",
            "content_rating": "18"
        },
        {
            "title": "Spawn",
            "genre": "horror,fantasy",
            "release_date": "1997",
            "description": "After being murdered by corrupt colleagues in a covert government agency, Al Simmons makes a pact with the devil to be resurrected to see his beloved wife Wanda. In exchange for his return to Earth, Simmons agrees to lead Hell's Army in the destruction of mankind.",
            "content_rating": "PG 13"
        },
        {
            "title": "Chamatkar",
            "genre": "fantasy,comedy",
            "release_date": "1992",
            "description": "When Sunder loses everything, he seeks refuge in a graveyard, where he befriends a ghost.",
            "content_rating": "PG"
        },
        {
            "title": "I Still Know What You Did Last Summer",
            "genre": "horror,thriller",
            "release_date": "1998",
            "description": "Ever since killing the Fisherman one year ago, Julie James is still haunted by images of him after her. When her best friend Karla wins free tickets to the Bahamas, Julie finds this a perfect opportunity to finally relax. But someone is waiting for her. Someone who she thought was dead. Someone who is out again for revenge.",
            "content_rating": "18"
        },
        {
            "title": "West Beirut",
            "genre": "comedy,war",
            "release_date": "1998",
            "description": "In April, 1975, civil war breaks out; Beirut is partitioned along a Moslem-Christian line. Tarek is in high school, making Super 8 movies with his friend, Omar. At first the war is a lark: school has closed, the violence is fascinating, getting from West to East is a game. His mother wants to leave; his father refuses. Tarek spends time with May, a Christian, orphaned and living in his building. By accident, Tarek goes to an infamous brothel in the war-torn Olive Quarter, meeting its legendary madam, Oum Walid. He then takes Omar and May there using her underwear as a white flag for safe passage. Family tensions rise. As he comes of age, the war moves inexorably from adventure to tragedy.",
            "content_rating": "PG 13"
        },
        {
            "title": "Blade II",
            "genre": "fantasy,thriller",
            "release_date": "2002",
            "description": "A rare mutation has occurred within the vampire community - The Reaper. A vampire so consumed with an insatiable bloodlust that they prey on vampires as well as humans, transforming victims who are unlucky enough to survive into Reapers themselves. Blade is asked by the Vampire Nation for his help in preventing a nightmare plague that would wipe out both humans and vampires.",
            "content_rating": "18"
        },
        {
            "title": "Stuart Little 2",
            "genre": "fantasy,comedy",
            "release_date": "2002",
            "description": "Stuart, an adorable white mouse, still lives happily with his adoptive family, the Littles, on the east side of Manhattan's Central Park. More crazy mouse adventures are in store as Stuart, his human brother, George, and their mischievous cat, Snowbell, set out to rescue a friend.",
            "content_rating": "PG"
        },
        {
            "title": "The Cat in the Hat",
            "genre": "fantasy,comedy",
            "release_date": "2003",
            "description": "Conrad and Sally Walden are home alone with their pet fish. It is raining outside, and there is nothing to do. Until The Cat in the Hat walks in the front door. He introduces them to their imagination, and at first it's all fun and games, until things get out of hand, and The Cat must go, go, go, before their parents get back.",
            "content_rating": "PG"
        },
        {
            "title": "Tears of the Sun",
            "genre": "thriller,war",
            "release_date": "2003",
            "description": "Navy SEAL Lieutenant A.K. Waters and his elite squadron of tactical specialists are forced to choose between their duty and their humanity, between following orders by ignoring the conflict that surrounds them, or finding the courage to follow their conscience and protect a group of innocent refugees. When the democratic government of Nigeria collapses and the country is taken over by a ruthless military dictator, Waters, a fiercely loyal and hardened veteran is dispatched on a routine mission to retrieve a Doctors Without Borders physician.",
            "content_rating": "18"
        },
        {
            "title": "Scare Tactics",
            "genre": "horror,comedy",
            "release_date": "2003",
            "description": "Scare Tactics is a hidden camera/comedy television show, produced by Kevin Healey and Scott Hallock. Its first two seasons aired from April 2003 to December 2004. After a hiatus, the show returned for a third season, beginning July 9, 2008. The first season of the show was hosted by Shannen Doherty. Stephen Baldwin took her place in the middle of the second season. Since the beginning of the third season, the show has been hosted by Tracy Morgan. The fourth season began on October 6, 2009.\n\nIn Europe the first season of the program aired on MTV Central from 2003 to 2004. The show is also broadcast in Australia on FOX8, in Canada on MTV, in India on AXN, in Russia on MTV Russia, in Turkey on Dream TV, in Poland on TV Puls, in Finland on Jim, in South Korea on Q TV, in Sweden initially on TV6 and currently on TV11.",
            "content_rating": "PG 13"
        },
        {
            "title": "Kucch To Hai",
            "genre": "horror,thriller",
            "release_date": "2003",
            "description": "Indian film-makers have now come up with their very own \"I Know What You Did Last Summer', a story centering around a College Professor, who kills his wife, and hides her body in the College campus. When some students, who have been caught cheating in their exams, decide to change their marks, they break into the Professor's room, and this is where they find his wife's lifeless body. Afraid, they may get blamed for breaking and entering as well as this murder, they decide to run away, leave the city and try to forget this ever happened. Years the college friends meets at a mutual friends' wedding - and this is where they will find out that the killer of the woman is still at large, knows about them, and this time they are going to be his next victims",
            "content_rating": "PG"
        },
        {
            "title": "Blade: Trinity",
            "genre": "fantasy,thriller",
            "release_date": "2004",
            "description": "For years, Blade has fought against the vampires in the cover of the night. But now, after falling into the crosshairs of the FBI, he is forced out into the daylight, where he is driven to join forces with a clan of human vampire hunters he never knew existedThe Nightstalkers. Together with Abigail and Hannibal, two deftly trained Nightstalkers, Blade follows a trail of blood to the ancient creature that is also hunting himthe original vampire, Dracula.",
            "content_rating": "18"
        },
        {
            "title": "Scary Movie 4",
            "genre": "horror,comedy",
            "release_date": "2006",
            "description": "Cindy finds out the house she lives in is haunted by a little boy and goes on a quest to find out who killed him and why. Also, Alien \"Tr-iPods\" are invading the world and she has to uncover the secret in order to stop them.",
            "content_rating": "PG 13"
        },
        {
            "title": "Without a Paddle",
            "genre": "thriller,comedy",
            "release_date": "2004",
            "description": "Three friends, whose lives have been drifting apart, reunite for the funeral of a fourth childhood friend. When looking through their childhood belongings, they discover a trunk which contained details on a quest their friend was attempting. It revealed that he was hot on the trail of the $200,000 that went missing with airplane hijacker D.B. Cooper in 1971. They decide to continue his journey, but do not understand the dangers they will soon encounter.",
            "content_rating": "PG 13"
        },
        {
            "title": "Happy Feet",
            "genre": "fantasy,comedy",
            "release_date": "2006",
            "description": "Into the world of the Emperor Penguins, who find their soul mates through song, a penguin is born who cannot sing. But he can tap dance something fierce!",
            "content_rating": "PG"
        },
        {
            "title": "Charlie and the Chocolate Factory",
            "genre": "fantasy,comedy",
            "release_date": "2005",
            "description": "A young boy wins a tour through the most magnificent chocolate factory in the world, led by the world's most unusual candy maker.",
            "content_rating": "PG"
        },
        {
            "title": "Monster House",
            "genre": "fantasy,comedy",
            "release_date": "2006",
            "description": "Monsters under the bed are scary enough, but what happens when an entire house is out to get you? Three teens aim to find out when they go up against a decrepit neighboring home and unlock its frightening secrets.",
            "content_rating": "PG"
        },
        {
            "title": "Inuyasha the Movie 3: Swords of an Honorable Ruler",
            "genre": "fantasy,thriller",
            "release_date": "2003",
            "description": "Inuyasha and his brother, Sesshomaru, each inherited a sword from their father after his death. However, their father had a third sword, named Sounga, that he sealed away. Seven hundreds years after his death, Sounga awakens and threatens mankind's very existence. How will the children of the Great Dog Demon stop this unimaginable power?",
            "content_rating": "PG 13"
        },
        {
            "title": "The Cave",
            "genre": "horror,thriller",
            "release_date": "2005",
            "description": "After a group of biologists discovers a huge network of unexplored caves in Romania and, believing it to be an undisturbed eco-system that has produced a new species, they hire the best American team of underwater cave explorers in the world. While exploring deeper into the underwater caves, a rockslide blocks their exit, and they soon discover a larger carnivorous creature has added them to its food chain.",
            "content_rating": "PG 13"
        },
        {
            "title": "Arahan",
            "genre": "fantasy,thriller",
            "release_date": "2004",
            "description": "Sang-hwan became a cop in order to help the downtrodden, but he doesn't get much respect. All that changes when he meets the Seven Masters.",
            "content_rating": "PG"
        },
        {
            "title": "Krishna Cottage",
            "genre": "horror,thriller",
            "release_date": "2004",
            "description": "A group of collegians are forced to take shelter in a mysterious Krishna Cottage for the night. Little do they know that the cottage is haunted by a spirit.",
            "content_rating": "PG"
        },
        {
            "title": "Final Destination 3",
            "genre": "horror,thriller",
            "release_date": "2006",
            "description": "A student's premonition of a deadly rollercoaster ride saves her life and a lucky few, but not from death itself  which seeks out those who escaped their fate.",
            "content_rating": "18"
        },
        {
            "title": "Kaal",
            "genre": "horror,thriller",
            "release_date": "2005",
            "description": "After a series of deaths in Orbit Park, India, are attributed to a man-eating tiger, wildlife expert Krish and his photographer decide to investigate the incidents for a magazine article.",
            "content_rating": "PG"
        },
        {
            "title": "The Spiderwick Chronicles",
            "genre": "fantasy,thriller",
            "release_date": "2008",
            "description": "Upon moving into the run-down Spiderwick Estate with their mother, twin brothers Jared and Simon Grace, along with their sister Mallory, find themselves pulled into an alternate world full of faeries and other creatures.",
            "content_rating": "PG"
        },
        {
            "title": "Code Lyoko",
            "genre": "fantasy,thriller",
            "release_date": "2003",
            "description": "Code Lyoko centers on four children who travel to the virtual world of Lyoko to battle against a sentient artificial intelligence named XANA, with a virtual human called Aelita.",
            "content_rating": "PG"
        },
        {
            "title": "The Texas Chainsaw Massacre: The Beginning",
            "genre": "horror,thriller",
            "release_date": "2006",
            "description": "Chrissie and her friends set out on a road trip for a final fling before one is shipped off to Vietnam. Along the way, bikers harass the foursome and cause an accident that throws Chrissie from the vehicle. The lawman who arrives on the scene kills one of the bikers and brings Chrissie's friends to the Hewitt homestead, where young Leatherface is learning the tools of terror.",
            "content_rating": "18"
        },
        {
            "title": "Perazhagan",
            "genre": "thriller,comedy",
            "release_date": "2004",
            "description": "A hunchbacked phone booth operator loves a blind street dancer and wants to help her regain her sight. His lookalike is a constable in love with the commissioner's daughter.",
            "content_rating": "PG"
        },
        {
            "title": "Terminator Salvation",
            "genre": "fantasy,thriller",
            "release_date": "2009",
            "description": "All grown up in post-apocalyptic 2018, John Connor must lead the resistance of humans against the increasingly dominating militaristic robots. But when Marcus Wright appears, his existence confuses the mission as Connor tries to determine whether Wright has come from the future or the past -- and whether he's friend or foe.",
            "content_rating": "PG 13"
        },
        {
            "title": "Rambo",
            "genre": "thriller,war",
            "release_date": "2008",
            "description": "When governments fail to act on behalf of captive missionaries, ex-Green Beret John James Rambo sets aside his peaceful existence along the Salween River in a war-torn region of Thailand to take action.  Although he's still haunted by violent memories of his time as a U.S. soldier during the Vietnam War, Rambo can hardly turn his back on the aid workers who so desperately need his help.",
            "content_rating": "18"
        },
        {
            "title": "The Smurfs",
            "genre": "fantasy,comedy",
            "release_date": "2011",
            "description": "When the evil wizard Gargamel chases the tiny blue Smurfs out of their village, they tumble from their magical world and into ours -- in fact, smack dab in the middle of Central Park. Just three apples high and stuck in the Big Apple, the Smurfs must find a way to get back to their village before Gargamel tracks them down.",
            "content_rating": "PG"
        },
        {
            "title": "Inuyasha the Movie 4: Fire on the Mystic Island",
            "genre": "fantasy,comedy",
            "release_date": "2004",
            "description": "The mysterious island of Houraijima has reappeared after 50 years, and with its reappearance has brought the attack of four gods, the Shitoushin, who have their eyes set on the powers that protect and sustain the island. Now it's up to Inuyasha and his friends, along with Sesshoumaru, to find a way to defeat the powerful Shitoushin.",
            "content_rating": "PG 13"
        },
        {
            "title": "Taxi No. 9 2 11",
            "genre": "thriller,comedy",
            "release_date": "2006",
            "description": "A cabbie and businessman both in need of big money partake in a two-hour adventure together.",
            "content_rating": "PG"
        },
        {
            "title": "Premonition",
            "genre": "fantasy,thriller",
            "release_date": "2007",
            "description": "A depressed housewife who learns her husband was killed in a car accident the day previously, awakens the next morning to find him alive and well at home, and then awakens the day after to a world in which he is still dead.",
            "content_rating": "PG 13"
        },
        {
            "title": "Friday the 13th",
            "genre": "horror,thriller",
            "release_date": "2009",
            "description": "A group of young adults visit a boarded up campsite named Crystal Lake where they soon encounter the mysterious Jason Voorhees and his deadly intentions.",
            "content_rating": "18"
        },
        {
            "title": "Naruto: Legend of the Stone of Gelel",
            "genre": "fantasy,comedy",
            "release_date": "2005",
            "description": "Naruto, Shikamaru, and Sakura are executing their mission of delivering a lost pet to a certain village. However, right in the midst of things, troops led by the mysterious knight, Temujin, attack them. In the violent battle, the three become separated. Temujin challenges Naruto to a fight and at the end of the fierce battle, both fall together from a high cliff...",
            "content_rating": "PG 13"
        },
        {
            "title": "Scary Movie 5",
            "genre": "horror,comedy",
            "release_date": "2013",
            "description": "Home with their newly-formed family, happy parents Dan and Jody are haunted by sinister, paranormal activities. Determined to expel the insidious force, they install security cameras and discover their family is being stalked by an evil dead demon.",
            "content_rating": "PG 13"
        },
        {
            "title": "Anthony Kaun Hai?",
            "genre": "thriller,comedy",
            "release_date": "2006",
            "description": "Small-time crook, Champa Chaudhary alias 'Champ' forges passports, photographs, and deeds in Thailand. He is arrested by the Police, tried and sentenced to six months in jail, and this is where he meets a supposedly dumb and deaf inmate, Raghuvir Sharma, serving a life sentence of stealing diamonds. Champ finds out that Raghuvir is not deaf nor dumb, and offers him a share if he springs him out of prison, to which Champ agrees. As soon as Champ's term is over, he gets discharged and prepares forged release documents for Raghuvir and in this manner gets him legally out of jail. The two then hideout in a house deep in the country, where Raghuvir is re-united with his daughter, Jia.",
            "content_rating": "PG"
        },
        {
            "title": "Jack and Jill",
            "genre": "horror,comedy",
            "release_date": "2011",
            "description": "Jack Sadelstein, a successful advertising executive in Los Angeles with a beautiful wife and kids, dreads one event each year: the Thanksgiving visit of his twin sister Jill. Jill's neediness and passive-aggressiveness is maddening to Jack, turning his normally tranquil life upside down.",
            "content_rating": "PG"
        },
        {
            "title": "Shrek Forever After",
            "genre": "fantasy,comedy",
            "release_date": "2010",
            "description": "A bored and domesticated Shrek pacts with deal-maker Rumpelstiltskin to get back to feeling like a real ogre again, but when he's duped and sent to a twisted version of Far Far Awaywhere Rumpelstiltskin is king, ogres are hunted, and he and Fiona have never methe sets out to restore his world and reclaim his true love.",
            "content_rating": "PG"
        },
        {
            "title": "Sucker Punch",
            "genre": "fantasy,thriller",
            "release_date": "2011",
            "description": "A young girl is institutionalized by her abusive stepfather. Retreating to an alternative reality as a coping strategy, she envisions a plan which will help her escape from the mental facility.",
            "content_rating": "PG 13"
        },
        {
            "title": "Horrid Henry",
            "genre": "fantasy,comedy",
            "release_date": "2006",
            "description": "Horrid Henry is a British animated television series based on the book series by Francesca Simon produced by One Explosion Studios and Nelvana Limited, broadcast from late 2006 on Children's ITV in the UK and it will air on Cartoon Network Pakistan and Cartoon Network India on 2013 from 6am until 6:30am. The animation style differs from the Tony Ross illustrations in the books. Series Producer of the series is Lucinda Whiteley, Animation Director is Dave Unwin. The series has been sold to more than a dozen countries including France, Germany, South Africa, South Korea, and the Philippines.\n\nSo far, the two series have 104 episodes. The second series of 52 episodes started airing on 16 February 2009 and episodes from this series are currently being shown alongside episodes from the first series. There is a music album Horrid Henry's Most Horrid Album. The incidental music is composed by Lester Barnes and additional songs are composed by Lockdown Media.",
            "content_rating": "PG"
        },
        {
            "title": "Army of the Dead",
            "genre": "horror,thriller",
            "release_date": "2021",
            "description": "Following a zombie outbreak in Las Vegas, a group of mercenaries take the ultimate gamble: venturing into the quarantine zone to pull off the greatest heist ever attempted.",
            "content_rating": "18"
        },
        {
            "title": "Om Shanti Om",
            "genre": "fantasy,comedy",
            "release_date": "2007",
            "description": "Om, a junior film artist, is smitten by Shantipriya, a renowned actress, but is killed while trying to save her from a fire accident. Thirty years later, he is reborn and sets out to avenge her death.",
            "content_rating": "PG"
        },
        {
            "title": "From Within",
            "genre": "horror,thriller",
            "release_date": "2008",
            "description": "When the citizens of a small evangelical town systematically begin committing suicide, a young girl struggling to reconcile her Christian upbringing with her desire to experience the outside world finds her faith put to the ultimate test.",
            "content_rating": "18"
        }
    ]
}
```
