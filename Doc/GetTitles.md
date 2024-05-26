## Function: GetTitles (POST)

```uri
http://localhost/COS221-Practical-5-Group-23/api/GetTitle.php
```

### Description

This function handles a POST request to retrieve details about movies or TV shows and can also be used to filter titles based on a few criteria such as ***duration if it is a movie***   accepting a few parameters. if you give a duration search/constraint you can immediately assume it's a movie or if you give a season search/constraint you can immediately assume it's a TV show. 

Note: that duration is in minutes so it's an integer and release_date is the year of release so it's also an integer.

### Parameters (if a parameter has an asterisk{*} next to it, it means this key is required)

- *`return` (string || Array<string>): The string `"*"` is used to return all results or an array containing the items to return. The array should only contain any of the following:  
  
  `['list.media_ID', 'title, 'release_Date', 'description', 'content_rating', 'rating', 'poster_Url', 'Genre', 'CAST', 'DIRECTOR', 'WRITER', 'duration', 'seasons']`
  
  Note: "list.media_ID" refers to the media id of the title, and all these strings should be as is, as they are case sensitive but the order of how they are stored in the array is not important.

- *`limit` (int):  A number between 1 and 100 indicating how many results should be returned. 
  
  Note: PHP does not support the async function (I could've looked up how to do it but nako⏳) so making a request with a limit of 100  will be at the cost of your own time, I suggest keeping the limit $[1,30]$.

- `sort`(string): The results can be sorted by any of the following attributes: `['media_ID', 'title, 'release_Date', 'description', 'content_rating', 'rating', 'poster_Url', 'Genre', 'CAST', 'DIRECTOR', 'WRITER', 'duration', 'seasons']`
  
  - `order` (string): The results can be ordered by "ASC" or "DESC" for ascending or descending respectively.
    
    Note: the reason the order is indented into sort is that if you have a sort you ***MUST***  an order otherwise a bad request(400) will be returned. And you cannot have an order by itself.

- `search`(JSON): An object where the keys are columns of the data and the values are the search terms. Columns can be any of the following: `['type', 'title, 'release_Date', 'id', 'genre', 'rating', 'poster_Url', 'Genre', 'CAST', 'DIRECTOR', 'WRITER', 'duration', 'seasons']`
  
  - `type` (string): This is the type of content that should be searched for, it strictly has to be "tvshow" or "movie";
  
  - `title` (int): The title of the movie that you'd like to search for;
  
  - `id` (int): the id/media_id of the content you'd like to search for;
  
  - `genre` (string): The title that you would like filtered by the genre that's associated
  
  - `rating` (int): Titles with a specific rating $[1,5]$;
  
  - `content_rating` (string): Title with a specific content rating out of the following: `['PG', 'PG 9', 'PG 13', '16' or '18']`
  
  - `release_date` (int): The year in which a title is released.
  
  - `cast` (string): Retrieves the title based on the name of the cast member, you can enter either a first name or a last name to search for the title associated with the desired cast member.
  
  - `director` (string): Retrieves the title based on the name of the director, you can enter either a first name or a last name to search for the title associated with the desired director.
  
  - `writer` (string): Retrieves titles based on the name of the writer, you can enter either a first name or a last name to search for the title associated with the desired writer.
  
  - `minduration` (int): Retrieves titles based on if their duration is greater than or equal to minduration  $[minduration,\infty]$
  
  - `maxduration` (int): Retrieves titles based on if their duration is less than or equal to maxduration $[0,maxduration]$
  
  - `minseasons` (int): Retrieves titles based on if the number of seasons is greater than or equal to minseasons $[minseasons,\infty]$
  
  - `maxseasons` (int): Retrieves titles based on if the number of seasons is less than or equal to maxseasons $[0,maxseasons]$
    
    Note: You cannot search for "type":"movie" and also have a `maxseasons` or `minseasons` and also for "type":"tvshow"" you can't have a `minduration` or a `maxduration` as this will through a bad request(400) cause that's what distinguishes a movie from a tv show. but you can have a duration or a season search if you do have the opposing type or do not have a type search at all and this will still be valid.
  
  - `minrating` (int): Retrieves titles based on if their ratings are greater than or equal to minrating $[minrating,5]$
  
  - `maxrating` (int): Retrieves titles based on if their ratings are less than or equal to maxrating $[0,maxrating]$
  
  - `minreleasedate` (int): Retrieves titles based on if their release date is later than or equal to minreleasedate $[minreleasedate,\infty]$
  
  - `maxreleasedate` Retrieves titles based on if their release date is earlier than or equal to maxreleasedate $[0,maxreleasedate]$
    
    Note: when it comes to filtering using `min-` and `max-` and they relate such as `minduration` and `maxduration` in the same request it will limit the domain from being $\infty$ for min and being $0$ max and will instead be a domain of $[minduration,maxduration]$.

```json5
{
  "return": "string or Array<string>", // The string "*" or an array of specific fields to return
  "limit": "integer", // A number between 1 and 100 indicating the number of results to return
  "sort": "string", // An string to sort by that field
  "order": "string", // "ASC" or "DESC" indicating the sort order
  "search": {
    "type": "string", // Must be "tvshow" or "movie"
    "title": "integer", // The title of the movie to search for
    "id": "integer", // The ID/media_id of the content
    "genre": "string", // The genre to filter by
    "rating": "integer", // Titles with a specific rating [1, 5]
    "content_rating": "string", // Specific content rating ['PG', 'PG 9', 'PG 13', '16', '18']
    "release_date": "integer", // The year the title was released
    "cast": "string", // Name of the cast member (first or last name)
    "director": "string", // Name of the director (first or last name)
    "writer": "string", // Name of the writer (first or last name)
    "minduration": "integer", // Titles with duration >= minduration
    "maxduration": "integer", // Titles with duration <= maxduration
    "minseasons": "integer", // Titles with seasons >= minseasons
    "maxseasons": "integer", // Titles with seasons <= maxseasons
    "minrating": "integer", // Titles with rating >= minrating
    "maxrating": "integer", // Titles with rating <= maxrating
    "minreleasedate": "integer", // Titles with release date >= minreleasedate
    "maxreleasedate": "integer" // Titles with release date <= maxreleasedate
  }
}
```

### Returns

- `timestamp` (integer): The time at which the request was made.

- `status` (string): Status of the request, either "success" or "error".

- `data` (Array<JSON OBJECT>): If successful, contains the requested user recommendation data in array form of JSON object elements.
  
  - `id` (int): The media_ID of the title
  
  - `title` (string): The title of the title you are retrieving
  
  - `image` (string): The image poster of the title
  
  - `description` (string): The description of the title
  
  - `seasons` (int): The number of seasons the TV show has.
  
  - `duration` (int): The duration of the movie.
  
  - `content_rating` (string): The age restriction of the title
  
  - `release_date` (integer): The year in which the title was released
  
  - `genre` (Array): The genres associated with the title
  
  - `cast` (Array): The names of the acting cast associated with the title
  
  - `director` (Array): The names of directors associated with the title
  
  - `writer` (Array): The names of the writers associated with the title

### Example Request

```json
{
    "return": "*",
    "limit": 10,
    "sort":"media_ID",
    "order":"DESC",
    "search":{ 
        "type":"movie",
        "minduration": 150,
        "maxduration": 200,
        "minrealsedate": 1999
     }
}
```

### Example Response

```json
{
    "status": "success",
    "timestamp": 1716711625,
    "data": [
        {
            "id": 1024943,
            "title": "Om Shanti Om",
            "image": "https://image.tmdb.org/t/p/original/oArsQTD4bPPMtRjqr03SO9W6phF.jpg",
            "description": "Om, a junior film artist, is smitten by Shantipriya, a renowned actress, but is killed while trying to save her from a fire accident. Thirty years later, he is reborn and sets out to avenge her death.",
            "duration": 162,
            "content_rating": "PG",
            "release_date": "2007",
            "genre": [
                "comedy",
                "drama",
                "fantasy"
            ],
            "cast": [
                "Arjun Rampal",
                "Asawari Joshi",
                "Bikramjeet Kanwarpal",
                "Bindu Desai",
                "Dhananjay",
                "Dominic",
                "Doris",
                "Jawed Sheikh",
                "Jeetendra",
                "Lin Laishram",
                "Linthiongambi Laishram",
                "Manikandan",
                "Masood Akhtar",
                "Mohan",
                "Nagesh Kumar",
                "Nassar Abdulla",
                "Navrotem Bain",
                "Nikhil Chinappa",
                "Nitesh Pandey",
                "Raman",
                "Salim",
                "Samapika",
                "Sev Anand",
                "Sharad",
                "Shreyas Talpade",
                "Simon",
                "Suhas Khandke",
                "Suresh Chatwal",
                "Vikram Sahu",
                "Vishwajeet",
                "Vivek Kushlani",
                "Yaseen",
                "Yuvika Chaudhary",
                "Zoa Morani"
            ],
            "director": [
                "Farah Khan"
            ]
        },
        {
            "id": 1017456,
            "title": "Race",
            "image": "https://image.tmdb.org/t/p/original/krMI3hRmlgKcuNc3XBWtl8APasR.jpg",
            "description": "Ranvir and Rajiv are half brothers who own a huge stud farm in South Africa. Ranvir is a very shrewd and aggressive man while Rajiv is laid back, and a chronic alcoholic. Sophia, Ranvir's personal secretary adores and loves him. Ranvir is unaware of her feelings. Shaina, an Indian ramp model in Durban loves Ranvir but through a twist of fate gets married to his younger brother Rajiv. When she discovers that Rajiv is a chronic alcoholic, her world is shattered. Ranvir too is disturbed as he has sacrificed his love for his younger brother because Rajiv had promised to leave alcohol for good if he marries Shaina. In a weak moment Ranvir and Shaina come very close to each other. When Rajiv starts suspecting, all hell breaks loose. A murder is committed, a contract killing is issued. A sharp tongued detective R.D., getting wise on the proceedings, starts an intriguing investigation with his brainless bimbo assistant Mini",
            "duration": 161,
            "content_rating": "PG 13",
            "release_date": "2008",
            "genre": [
                "action",
                "drama",
                "thriller"
            ],
            "cast": [
                "Bipasha Basu",
                "Chandra Prakash",
                "Sameera Reddy",
                "Sandra Badenhorst",
                "Smita Malhotra"
            ],
            "director": [
                "Abbas Alibhai Burmawalla"
            ],
            "writer": [
                "Shiraz Ahmed"
            ]
        },
        {
            "id": 986264,
            "title": "Like Stars on Earth",
            "image": "https://image.tmdb.org/t/p/original/fwXhw9bERqKrJfJK6WGakPIh3FS.jpg",
            "description": "Ishaan Awasthi is an eight-year-old whose world is filled with wonders that no one else seems to appreciate. Colours, fish, dogs, and kites don't seem important to the adults, who are much more interested in things like homework, marks, and neatness. Ishaan cannot seem to get anything right in class; he is then sent to boarding school, where his life changes forever.",
            "duration": 165,
            "content_rating": "PG",
            "release_date": "2007",
            "genre": [
                "drama",
                "family"
            ],
            "cast": [
                "Aamir Khan",
                "Alorika Chatterjee",
                "Amole Gupte",
                "Ananya Dutt",
                "Aniket Engineer",
                "Arnav Valcha",
                "Ayaan",
                "Brihan Lamba",
                "Darsheel Safary",
                "Girija Oak",
                "Girish Kumar Menon",
                "Gurdeepak Kaur",
                "Gurkirtan",
                "Haji Springer",
                "Imran",
                "Jadav",
                "Krishn Gopinath",
                "Lalitha Lajmi",
                "Madhav Datt",
                "Megha Bengali",
                "Meghna Malik",
                "Munireh Guhilot",
                "Prashant",
                "Pratima Kulkarni",
                "Rajgopal Iyer",
                "Ramit Gupta",
                "Ricky",
                "Sachet Engineer",
                "Sanjay Dadhich",
                "Shankar Sachdev",
                "Sonali Sachdev",
                "Tisca Chopra",
                "Veer Mohan",
                "Vipin Sharma",
                "Vitthal",
                "Vivekanandan"
            ]
        },
        {
            "id": 964516,
            "title": "Fashion",
            "image": "https://image.tmdb.org/t/p/original/6PQyJUJ3Ny1AZegtL5OkUATCIcr.jpg",
            "description": "A small-town girl finally realizes her dream of becoming a famous supermodel but soon finds out that there's a price for her glamorous new life.",
            "duration": 167,
            "content_rating": "PG 13",
            "release_date": "2008",
            "genre": [
                "drama",
                "romance"
            ],
            "cast": [
                "Adhiraj Chakraborty",
                "Alesia Raut",
                "Anchal Kumar",
                "Anil Thakur",
                "Arinndam Biswas",
                "Balwant Jadhav",
                "Brindles Helgadottir",
                "Caroline Martins Alcamim",
                "Cintia Mallia De Rosa",
                "Clarisse Cardeiro Neves",
                "Daman Baggan",
                "Diandra Soares",
                "Esha Balwe",
                "Fabiana dos Santos Madeiros",
                "Fabiana Tesla",
                "Fardeen",
                "Flavia Reinert Corrente",
                "G.K. Desai",
                "Gayatri Khanna",
                "Girish Hemnani",
                "Gita Soto",
                "Helen Pereira",
                "Hemangi Parle",
                "Jai Nagra",
                "Jaqueline Borges",
                "Jatin Sippy",
                "Jesse Randhawa",
                "Joey Mathew",
                "Kamaljeet Singh",
                "Kanira Shah",
                "Kanishtha Dhankar",
                "Kavita Kharayal",
                "Linda Ivette",
                "Manish Mehta",
                "Mansi Dekale",
                "Mariah Gomes",
                "Mariana Dias",
                "Molly Singh",
                "Monique Strydom",
                "Mridula Chandrashekar",
                "Mugdha Godse",
                "Nayanika Chatterjee",
                "Nazneen",
                "Neha Jabbar",
                "Ojas Rajani",
                "Panchali Gupta",
                "Parth",
                "Pooja Chopra",
                "Pramod Bhangare",
                "Raj Nair",
                "Rinku Patel",
                "Riya Bajaj",
                "Rosey Nicholson",
                "Sachin Kumbhar",
                "Sandra Hasanbasicova",
                "Seema",
                "Shagun Sarabhai",
                "Sheena Bajaj",
                "Shobhit",
                "Stephanie Karen Serdarusic",
                "Sucheta Sharma",
                "Sujata Thakkar",
                "Svetalana Casper",
                "Sweety",
                "Tarul Swami",
                "Tina Narenha",
                "Topaz Shah",
                "Trishul Marathe",
                "Zoha Tapia"
            ],
            "director": [
                "Madhur Bhandarkar"
            ],
            "writer": [
                "Ajay Monga"
            ]
        },
        {
            "id": 886539,
            "title": "Luck by Chance",
            "image": "https://image.tmdb.org/t/p/original/cIcKapfNtS1TmVoEASuE9OK9gPB.jpg",
            "description": "Not wanting the same fate as befell her sisters, Sona Mishra re-locates to Mumbai to try to make a living making movies, but she soon finds that the path she has chosen is not an easy one.",
            "duration": 155,
            "content_rating": "PG",
            "release_date": "2009",
            "genre": [
                "drama",
                "romance"
            ],
            "cast": [
                "Amit Paul",
                "Isha Sharvani",
                "Kamlesh Shinde",
                "Megha Narkar",
                "Meghna Kapoor",
                "Mohsin Akhtar",
                "Mohsin Ali Khan",
                "Nimita Sheth",
                "Pritika Chawla",
                "Priyanka Kumar",
                "Rajshree Gupta",
                "Ratnesh Kumar Punwani",
                "Rishi Kapoor",
                "Sahil Mohan",
                "Sanjay Kapoor",
                "Saurabh Nayyar",
                "Sonal Chaudhuri",
                "Subhash Thomas",
                "Umesh Pradhan"
            ],
            "director": [
                "Zoya Akhtar"
            ]
        },
        {
            "id": 499375,
            "title": "Guru",
            "image": "https://image.tmdb.org/t/p/original/xX2BJ5sn3ElTZqhnOEod8ZXsCQg.jpg",
            "description": "Gurukant Desai hails from Idhar, a small village in Gujarat, but dreams of setting up his own business in Mumbai. After he returns from Turkey, he marries Sujatha for getting the dowry and arrives in Mumbai to start his business. This film chronicles the obstacles he meets, his subsequent rise and the huge backlash he receives when it is revealed that he used unethical means to rise in the business circuit.",
            "duration": 166,
            "content_rating": "PG 13",
            "release_date": "2007",
            "genre": [
                "documentation",
                "drama",
                "romance"
            ],
            "cast": [
                "Alina Wadiwala",
                "Anaushka Dantra",
                "Antara Hazarika",
                "Ashoi",
                "Ashoi Dantra",
                "Boney",
                "Devika Mathur",
                "Firdausi Jussawalla",
                "Jaidev",
                "Rahul",
                "Rukmani",
                "Sana Wadiwala",
                "T.T. Srinath"
            ],
            "director": [
                "Mani Ratnam"
            ]
        },
        {
            "id": 488798,
            "title": "Welcome",
            "image": "https://image.tmdb.org/t/p/original/fudxnXlTTBIDCkpR7XhlIgkNaUY.jpg",
            "description": "Dubai-based criminal don Uday takes it upon himself to try and get his sister Sanjana married - in vain, as no one wants to be associated with a crime family. Uday's associate Sagar Pandey finds a young man, Rajiv, who lives with his maternal uncle and aunt - Dr. and Mrs. Ghunghroo. Through extortion he compels Ghunghroo to accept this matrimonial alliance. But Rajiv has already fallen in love with young woman in South Africa. When the time comes to get Rajiv formally engaged to this woman, he finds out that Sanjana and she are the very same. With no escape from this predicament, the wedding is planned, with hilarious consequences.",
            "duration": 160,
            "content_rating": "PG",
            "release_date": "2007",
            "genre": [
                "comedy",
                "crime",
                "romance"
            ],
            "cast": [
                "Rajeev Saxena",
                "Sherveer Vakil",
                "Supriya Karnik"
            ],
            "director": [
                "Anees Bazmee"
            ]
        },
        {
            "id": 479751,
            "title": "Sivaji: The Boss",
            "image": "https://image.tmdb.org/t/p/original/t5oPb8q91gdClkyJG2hxyebEglv.jpg",
            "description": "Corrupt police and politicians target a computer engineer for trying to better the lives of less privileged citizens.",
            "duration": 189,
            "content_rating": "PG 13",
            "release_date": "2007",
            "genre": [
                "crime",
                "drama",
                "thriller"
            ],
            "cast": [
                "Ala Aljundi",
                "Amarasigamani",
                "Anantha Gopi",
                "Babi",
                "Baksar Ravi",
                "Balaji",
                "Bangalore Mani",
                "Bashkar",
                "Bobby",
                "Calcutta Krishnamoorthy",
                "Ceri Jerome",
                "Deepak",
                "Deva",
                "Ela Varsu",
                "Horlicks Murali",
                "Jayaraman",
                "Jemini Balaji",
                "Kadi Kanthasamy",
                "Kajini Rajesh",
                "Karathya Raja",
                "Kottai Perumal",
                "Krishnamachari",
                "Lakshmanan",
                "Laxmanakumar",
                "Laxmanan",
                "Livingstone",
                "Maghendran",
                "Mahadevan",
                "Mahendran",
                "Malika",
                "Master Laksmankumar",
                "Mathivanan",
                "Munnar Rajesh",
                "Munnar Ramesh",
                "Muthukalai",
                "P.N. Kunju",
                "Pattimandram Raja",
                "Pattimandram Salomon Pappayah",
                "R.C. Sunder",
                "Rags",
                "Rajasekaran",
                "Rajinikanth",
                "Ramanan",
                "Ramji",
                "Rangadurai",
                "Samydurai",
                "Sankar Subramaniyam",
                "Seladurai",
                "Suman",
                "Swaminathan",
                "T.V. Manivannan",
                "Uma Padmanabhan",
                "Uma Pathmanabhan",
                "Vadivukkarasi",
                "Vaisak Prasath",
                "Vasu Vikram",
                "Verra Ragavan",
                "Vivek",
                "Yoga"
            ],
            "director": [
                "S. Shankar"
            ],
            "writer": [
                "Swanand Kirkire"
            ]
        },
        {
            "id": 449999,
            "title": "Kabhi Alvida Naa Kehna",
            "image": "https://image.tmdb.org/t/p/original/dkYQgRPuik4FGIUdGGVYGQJWrHa.jpg",
            "description": "Dev and Maya are both married to different people. Settled into a life of domestic ritual, and convinced that they are happy in their respective relationships, they still yearn for something deeper and more meaningful, which is precisely what they find in each other.",
            "duration": 193,
            "content_rating": "PG",
            "release_date": "2006",
            "genre": [
                "drama",
                "romance"
            ],
            "cast": [
                "Allen Iaccarino",
                "Alyssa Ritch",
                "Andrew Hillmedo Jr.",
                "Bob Connelly",
                "Brian Ferrari",
                "Carmel Nav�",
                "Charlotte Lake",
                "Christopher Wilford",
                "Diane Baisley",
                "Giuseppe Raucci",
                "Himad Beg",
                "Hiram Chan",
                "Jarett Armstrong",
                "Jay Prakash Mistry",
                "Jeff Halpin",
                "Kali Stivison",
                "Kathryn Gerhardt",
                "Kristen Bough",
                "Larissa Kohler",
                "Lisa Anzelmo",
                "Logan Anderson",
                "Matthew Joseff",
                "Michael C. Davis",
                "Michael Leister",
                "Oliver Martin",
                "Patrick Armstrong",
                "Rithear Len",
                "Ryan Kim",
                "Saira Mohan",
                "Speir Rahn",
                "Tomm Bauer",
                "Tracey Brennan",
                "Whit Blanchard"
            ],
            "director": [
                "Karan Johar"
            ]
        },
        {
            "id": 419058,
            "title": "Phir Hera Pheri",
            "image": "https://image.tmdb.org/t/p/original/c1Mvyd983ZyrU5Vf2aKEe6WncSq.jpg",
            "description": "Babu Rao, Raju and Shyam, are living happily after having risen from rags to riches. Still, money brings the joy of riches and with it the greed to make more money - and so, with a don as an unknowing investor, Raju initiates a new game.",
            "duration": 155,
            "content_rating": "PG",
            "release_date": "2006",
            "genre": [
                "comedy",
                "crime"
            ],
            "cast": [
                "Abid",
                "Aman Ullah",
                "Angelina Idnani",
                "Jagdeep Singh",
                "Johny Karan",
                "Labeeb Arslaan",
                "Manish Mehta",
                "Pavar Sunil Choudhary",
                "Rakesh Bhavsar",
                "Raymond D'Souza",
                "Sayyed Abid",
                "Snehal Pandey",
                "Suniel Shetty",
                "Taufeeq",
                "Vishal Bhavsar"
            ],
            "director": [
                "Neeraj Vora"
            ]
        }
    ]
}
```

### OR

### Example Request

```json
{
    "return": ["list.media_ID", "title", "release_Date","seasons"],
    "limit": 10,
    "sort":"title",
    "order":"ASC",
    "search":{ 
        "type":"tvshow",
        "minseasons": 3
     }
}
```

### Example Response

```json
{
    "status": "success",
    "timestamp": 1716711792,
    "data": [
        {
            "id": 869654,
            "title": "Bonus Family",
            "seasons": 4,
            "release_date": "2017"
        },
        {
            "id": 903747,
            "title": "Breaking Bad",
            "seasons": 5,
            "release_date": "2008"
        },
        {
            "id": 417325,
            "title": "Food Wars! Shokugeki no Soma",
            "seasons": 5,
            "release_date": "2015"
        },
        {
            "id": 972534,
            "title": "iCarly",
            "seasons": 6,
            "release_date": "2007"
        },
        {
            "id": 1064899,
            "title": "Queen of the South",
            "seasons": 5,
            "release_date": "2016"
        },
        {
            "id": 983983,
            "title": "Shaun the Sheep",
            "seasons": 6,
            "release_date": "2007"
        },
        {
            "id": 341957,
            "title": "The Paper",
            "seasons": 3,
            "release_date": "2016"
        }
    ]
}
```
