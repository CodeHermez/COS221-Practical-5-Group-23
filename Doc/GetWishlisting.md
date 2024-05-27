## Function: GetWishlisting

## Method: (GET)

#### URL:

```uri
http://localhost/COS221-Practical-5-Group-23/api/GetWishlist.php
```

### Description

This function handles a GET request to retieve a users wishlist.

### Parameters (if a parameter has an asterisk{*} next to it, it means this key is required)

- *`username` (string): The users username 

### Returns

- `status` (string): Status of the request, either "success" or "error".

- `timestamp` (integer): The time in at which the request was made.

- `data` (Array<JSON Object>): If successful, contains elements of JSON objects each containing title details. If an error was occur, contains the request error description.
  
  - `id` the titles media id
  
  - `title` (string): the name of the title
  
  - `release_Date` (string): the year of the titles release
  
  - `description` (string): the description of the title
  
  - `content_rating` (string): the age restriction of the title
  
  - `image` (string): the titles poster image

### Example Request (personal)

```uri
http://localhost/COS221-Practical-5-Group-23/api/GetWishlist.php?username=alex_wong
```

### Example Response (personal)

```json
{
    "status": "success",
    "timestamp": 1716838829,
    "data": [
        {
            "id": 19892833,
            "title": "Edge of Tomorrow",
            "release_Date": "2024",
            "description": "An alien race has hit the Earth in an unrelenting assault, unbeatable by any military unit in the world. Major William Cage (Cruise) is an officer who has never seen a day of combat when he is unceremoniously dropped into what amounts to a suicide mission. Killed within minutes, Cage now finds himself inexplicably thrown into a time loop-forcing him to live out the same brutal combat over and over, fighting and dying again...and again. But with each battle, Cage becomes able to engage the adversaries with increasing skill, alongside Special Forces warrior Rita Vrataski (Blunt).",
            "content_rating": "PG 9",
            "image": "https://m.media-amazon.com/images/I/71lE1tynhIL._AC_UF894,1000_QL80_.jpg"
        }
    ]
}
```
