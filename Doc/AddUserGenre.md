## Function: AddUserGenre (POST)

```uri
http://localhost/COS221-Practical-5-Group-23/api/AddUserGenre.php
```

### Description

This function handles a POST request to add a favourite genre to the users profile.

### Parameters (if a parameter has an asterisk{*} next to it, it means this key is required)

- *`username` (string): The persons username which will likely be stored in sessionStorage.
- *`genre` (string): The genre a user prefers this will be selected at the start when a user creates an account.

```json5
{
  "username": "string", // The persons username
  "genre": "string", // The genre a user prefers ie "action", "comedy", "war" etc.
}
```

### Returns

- `status` (string): Status of the request, either "success" or "error".
- `timestamp` (integer): The time in at which the request was made.
- `data` (string): If successful shows a description of the success, if failed will return a description of the error.

### Example Request (personal)

```json

{
    "username": "alex_wong",
    "genre": "war"
}
```

### Example Response (personal)

```json
{
    "status": "success",
    "timestamp": 1716541676,
    "data": "Title created successfully"
}
```
