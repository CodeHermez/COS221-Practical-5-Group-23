## Function: AddWishList (POST)

```uri
http://localhost/COS221-Practical-5-Group-23/api/AddWishList.php
```

### Description

This function handles a POST request to adds to the users wishlist for movies the user would like to watch in future.

### Parameters (if a parameter has an asterisk{*} next to it, it means this key is required)

- *`username` (string): The username of the user
- `media_id` (integer): The id of the title you would like to add
- `title` (string): The title of the title you would like to add

*You have to have media_id or title, its one or the other you cannot not have one, so they are both semi required even though they dont have a asterisk next to them.*

```json5
{
  "username": "string", // The username of the user
  "media_id": "Number", // The id of the title you would like to add
}
```

```json5
{
  "username": "string", // The username of the user
  "title": "string", // The title of the title you would like to add
}
```

### Returns

- `status` (string): Status of the request, either "success" or "error".
- `timestamp` (integer): The time in at which the request was made.
- `data` (string ): If successful, contains the requested user data. If an error was occur, contains the request error description.

### Example Request (personal)

```json
{
    "username": "alex_wong",
    "media_id": 56379
}
```

###### OR

```json5
{
    "username": "alex_wong",
    "title": "White Christmas"
}
```

### Example Response (personal)

```json
{
    "status": "success",
    "timestamp": 1716544168,
    "data": "Genre added successfully"
}
```
