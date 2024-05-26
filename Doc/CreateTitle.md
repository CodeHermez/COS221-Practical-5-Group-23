## Function: CreateTitle (POST)

```uri
http://localhost/COS221-Practical-5-Group-23/api/CreateTitle.php
```

### Description

This function handles a POST request to create a new movie or tvshow accepting a few parameters. 

### Parameters (if a parameter has an asterisk{*} next to it, it means this key is required)

- *`title` (string): The title of the content you want to retrieve
- *`type` (string): the type of content that can be watched (strictly "movie" or "tvshow")
- *`seasons`(string): If the type is "tvshow" then the number of seasons is required, this duration is the number of minutes the movie runs
- *`duration`(integer): If the type is "movie" then a duration is required, this duration is the number of minutes the movie runs
- *`description` (string): To insert the title description
- *`release_date` (integer): The year in which the title was released
- *`content_rating` (string): The age restriction of the title (strictly 'PG', 'PG 9', 'PG 13', '16' or '18')
- *`rating` (integer): The critic rating given, should be a value of 1 to five inclusive [1,5]
- *`genre` (Array<string>): the genres associated with the title
- *`image` (string): The poster image of the title as a URL
- *`crew` (JSON Object): The crew members that are associated with the creation of that title.
  - `actors` (array): A list of all the actors who were involved in the production both first & last names.
  - `writers` (array): A list of all the writers who were involved in the production both first & last names.
  - `directors` (array): A list of all the directors who were involved in the production both first & last names.

```json5
{
  "title": "string", // The title of the content you want to retrieve
  "type": "string", // The type of content that can be watched (strictly "movie" or "tvshow")
  "seasons": "string", // If the type is "tvshow," then the number of seasons is required; this duration is the number of minutes the show runs
  "duration": "integer", // If the type is "movie," then a duration is required; this duration is the number of minutes the movie runs
  "description": "string", // To insert the title description
  "release_date": "Number", // The year at which the movie was created
  "content_rating": "string", // The rating of the show (strictly 'PG', 'PG 9', 'PG 13', '16' or '18')
  "rating": "integer", // The critic rating is given; this should be a value of 1 to 5 inclusive [1, 5]
  "genre":Array<"string"> // The genre associated with the title
  "image": "string" //The poster image of the title  
"crew": {
    "actors": Array<"string">, // A list of all the actors who were involved in the production (both first & last name)
    "writers": Array<"string">, // A list of all the writers who were involved in the production (both first & last name)
    "directors": Array<"string"> // A list of all the directors who were involved in the production (both first & last name)
  }
}
```

### Returns

- `timestamp` (integer): The time at which the request was made.
- `data` (string): If successful, contains the requested user data. If an error occurs, it contains the request error description.
- `status` (string): Status of the request, either "success" or "error".

### Example Request (personal)

```json
{
    "title": "Edge of Tomorrow",
    "description": "An alien race has hit the Earth in an unrelenting assault, unbeatable by any military unit in the world. Major William Cage (Cruise) is an officer who has never seen a day of combat when he is unceremoniously dropped into what amounts to a suicide mission. Killed within minutes, Cage now finds himself inexplicably thrown into a time loop-forcing him to live out the same brutal combat over and over, fighting and dying again...and again. But with each battle, Cage becomes able to engage the adversaries with increasing skill, alongside Special Forces warrior Rita Vrataski (Blunt).",
    "release_date": 2013,
    "content_rating": "PG 9",
    "rating": 5,
    "crew":{
        "actors":["Tom Cruise", "Emily Blunt", "Bill Paxton", "Charlotte Riley"],
        "writers":["Christopher McQuarrie","Jez Butterworth"],
        "directors":["Doug Liman"]
    },
    "image":"https://m.media-amazon.com/images/I/71lE1tynhIL._AC_UF894,1000_QL80_.jpg",
    "type":"movie",
    "duration":113,
    "genre":["action","scifi","war","drama"]
}
```
please note how "scifi" should be inserted and not sci-fi

### Example Response (personal)

```json
{
    "status": "success",
    "timestamp": 1716541676,
    "data": "Title created successfully"
}
```
