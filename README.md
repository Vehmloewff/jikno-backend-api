#### [Chat on Discord](https://discord.gg/hXJQgvG) • [Submit an issue](https://github.com/Vehmloewff/jikno-backend-api/issues/new) • [API documentation](https://github.com/Vehmloewff/jikno-backend-api#api)

# Working with the code
To get started go ahead and install [MAMP](https://www.mamp.info/en/), or in your development environment provide a server that runs PHP and a mysql server.

Create a database:
```sql
CREATE DATABASE jikno_backend_api;
```
In your mysql database create these two tables:
```sql
CREATE TABLE members (
    email varchar(100),
    userPassword varchar(255),
    content longtext
);
CREATE TABLE apps_details (
    content LONGTEXT 
);
```

Now, create a file called `test.html`.  Populate it with something like this:
```html
<script>
  fetch('api.php?action=create_user&key=qjkiqewrjkaslf', {
    method: "POST",
    mode: "cors",
    cache: "no-cache",
    credentials: "same-origin",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    },
    redirect: "follow",
    referrer: "no-referrer",
    body: "email=test@jikno.com&password=12345678",
  })
  .then(res => res.json())
  .then(json => console.log(json))
</script>
```

When you run this page it will create a new row in `members`.

# API
- [Request](https://github.com/Vehmloewff/jikno-backend-api#Request)
- [Response](https://github.com/Vehmloewff/jikno-backend-api#Response)
- [InformationObject](https://github.com/Vehmloewff/jikno-backend-api#InformationObject)
- [Actions](https://github.com/Vehmloewff/jikno-backend-api#Actions)
    - [`create_user`](https://github.com/Vehmloewff/jikno-backend-api#create_user)
    - [`validate_user`](https://github.com/Vehmloewff/jikno-backend-api#validate_user)
    - [`get_user_info`](https://github.com/Vehmloewff/jikno-backend-api#get_user_info)
    - [`set_user_info`](https://github.com/Vehmloewff/jikno-backend-api#set_user_info)
    - [`sub_content`](https://github.com/Vehmloewff/jikno-backend-api#sub_content)
    - [`get_content`](https://github.com/Vehmloewff/jikno-backend-api#get_content)
    - [`email_user`](https://github.com/Vehmloewff/jikno-backend-api#email_user)
    - [`get_apps`](https://github.com/Vehmloewff/jikno-backend-api#get_apps)
	- [`change_values`](https://github.com/Vehmloewff/jikno-backend-api#change_values)
- [Params](https://github.com/Vehmloewff/jikno-backend-api#Params)
- [Error Codes](https://github.com/Vehmloewff/jikno-backend-api#Error-Codes)
    - [`INVALID_BRANCH`](https://github.com/Vehmloewff/jikno-backend-api#INVALID_BRANCH)
    - [`INVALID_PARAMS`](https://github.com/Vehmloewff/jikno-backend-api#INVALID_PARAMS)
    - [`FAILED`](https://github.com/Vehmloewff/jikno-backend-api#FAILED)
    - [`INVALID_USER`](https://github.com/Vehmloewff/jikno-backend-api#INVALID_USER)
    - [`OK`](https://github.com/Vehmloewff/jikno-backend-api#OK)
    - [`ACCOUNT_EXISTS`](https://github.com/Vehmloewff/jikno-backend-api#ACCOUNT_EXISTS)

## Request
A basic request to the Jikno Api would look like this:
```
https://www.api.jikno.com/?key=API_KEY&action=ACTION
```
Where `API_KEY` is your api key, and `ACTION` is the [action](https://github.com/Vehmloewff/jikno-backend-api#Actions) you are using.

If you want an API key you can email us at [jiknoteam@gmail.com](mailto:jiknoteam@gmail.com).

## Response
A basic response from this API will look like this:
```
{
  "error": true | false,
  "data": --response--,
  "code": "ERROR_CODE" | "OK"
}
```
Where --response-- is of type `boolean | Object | string`.

## InformationObject
Here is an example:
```
{
    user_info: {
        // A new users user_info branch defaults as empty
        // The following is an example
        username: "BobJacker" //Optional
        name: "Bob", //Optional
        age: "34" //Optional
    },
    //Additional branches can be added: Example:
    done_to_do_list: {
        //Information in that branch.
    }
}
```
The Jikno Manager has it's own branch, the To Do List it's own branch, and so on.
A new users `InformationObject` will look like this:
```
{
    user_info: {
    }
}
```

## Actions
The action is what you want to do with the API.

### create_user
[Params](https://github.com/Vehmloewff/jikno-backend-api#Params):
- `email`
- `password`
- `content` (Optional)

When the `content` parameter is specified, that value will be the value of the `InformationObject`

Action: Creates a new user.  This creates a new [InformationObject](https://github.com/Vehmloewff/jikno-backend-api#InformationObject).

Return type: `string`.

### validate_user
[Params](https://github.com/Vehmloewff/jikno-backend-api#Params):
- `email`
- `password`

Action: Checks to see if the email and password match.

Return type: `boolean`.

### get_user_info
[Params](https://github.com/Vehmloewff/jikno-backend-api#Params):
- `email`
- `password`

Action: Gets the information stored in the `user_info` branch in the [InformationObject](https://github.com/Vehmloewff/jikno-backend-api#InformationObject).

Return type: `object`.

### set_user_info
[Params](https://github.com/Vehmloewff/jikno-backend-api#Params):
- `email`
- `password`
- `content`

Action: Sets the information stored in the `user_info` branch in the [InformationObject](https://github.com/Vehmloewff/jikno-backend-api#InformationObject) with the value of the `content` param.

Return type: None.

### sub_content
[Params](https://github.com/Vehmloewff/jikno-backend-api#Params):
- `content`
- `branch_name`
- `email`
- `password`

Action: Sets the value of the the branch specified in the `branch_name` param.

Return type: None.

### get_content
[Params](https://github.com/Vehmloewff/jikno-backend-api#Params):
- `branch_name`
- `email`
- `password`

Action: Gets the value of the branch specified in the `branch_name` param.  If that branch does not exist, the API will return the default values for the branch you are requesting.

Return type: `content`.

### email_user
[Params](https://github.com/Vehmloewff/jikno-backend-api#Params):
- `email`
- `content`
- `subject`

Action: Emails the email address in the `email` param, the content being the value of the `content` param.  Emails will be sent from the address `jiknobot@jikno.com`.

Return type: None.

### get_apps
[Params](https://github.com/Vehmloewff/jikno-backend-api#Params):
- `email`
- `password`

Action: Returns an array of all the Jikno apps.  This action is still in progress. (see [this issue](https://github.com/Vehmloewff/jikno-backend-api/issues/5))

Return type: `array`.

### change_values
[Params](https://github.com/Vehmloewff/jikno-backend-api#Params):
- `email`
- `password`

Action: Changes the email and password of a specific user.

Return type: None.

## Params
All of the params must be sent via `POST` headers.
These are all of the params the API will accept:
- email: `string`
- password: `string`

- content: `object | array`

- branch_name: `string`
- subject: `string`


## Error Codes
On every [response]() there will come a `code` tree.  These tell the app or website reading the response what has gone wrong, or if everything is fine.

### INVALID_BRANCH
This is returned on the `set_content` action, where the branch that you are trying to set content to is not valid.

### INVALID_PARAMS
This is returned anytime the [request params](https://github.com/Vehmloewff/jikno-backend-api#Request) are not valid.

### ACCOUNT_EXISTS
This is returned on the `create_user` action, when the user that is being created already exists.

### OK
This code is returned when everything is fine.

### FAILED
This code is returned when an unknown error occurs on any action.  See the data tree of the response for more info.

### INVALID_USER
This is returned anytime (except on the `create_user` action) when the username and password do not match.

# Additional Information
For additional information you can [contact us](https://discord.gg/hXJQgvG).

### Note
I use [Sequelpro](https://github.com/sequelpro/sequelpro) to manage and view the SQL tables on my machine.

### Remeber:
When you update a param, action, or response in the API, you must update `README.md`.

# License
[MIT](https://opensource.org/licenses/MIT)
