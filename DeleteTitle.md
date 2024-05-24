## Function: DeleteTitle

## Method: (DELETE)

#### URL:

```uri
http://localhost/COS221-Practical-5-Group-23/api/DeleteTitle.php
```

### Description

This function handles a DELETE request to remove a title for an administrator.

### Parameters (if a parameter has an asterisk{*} next to it, it means this key is required)

- *`media_id` (Number): The id of the title you would like to delete

### Returns

- `status` (string): Status of the request, either "success" or "error".

- `timestamp` (integer): The time in at which the request was made.

- `data` (string): If successful, contains the requested user data. If an error was occur, contains the request error description.

### Example Request (personal)

```uri
http://localhost/COS221-Practical-5-Group-23/api/DeleteTitle.php?media_id=44429
```

### Example Response (personal)

```json
{
    "status": "success",
    "timestamp": 1716549485,
    "data": "Title deleted successfully"
}
```
