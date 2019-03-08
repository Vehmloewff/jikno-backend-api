#### [Chat on Discord](https://discord.gg/hXJQgvG) • [Submit an issue](https://github.com/Vehmloewff/jikno-backend-api/issues/new) • [API documentation](https://github.com/Vehmloewff/jikno-backend-api/blob/master/guide.txt)

# Working with the code
To get started go ahead and install [MAMP](https://www.mamp.info/en/), or, in your development environment provide a server that runs PHP, and a mysql server.

Create a database:
```sql
CREATE DATABASE jikno_backend_api;
```
In your mysql database create this table:
```sql
CREATE TABLE members (
    email varchar(100),
    userPassword varchar(255),
    content longtext
);
```

Now, create a file called `index.html`.  Populate it with something like this:
```html
<script>
  fetch('api.php?action=create_user&key=qjkiqewrjkaslf', {
    method: "POST",
    mode: "cors",
    cache: "no-cache",
    credentials: "same-origin",
    headers: {
        "Content-Type": "application/json",
    },
    redirect: "follow",
    referrer: "no-referrer",
    body: JSON.stringify({
      email: "email@example.com",
      password: "1234"
    })
  })
  .then(res => res.json())
  .then(json => console.log(json))
</script>
```

When you run this page it will create a new row in `members`.

Rember: When you update param, action, or response in the api, you must update `guide.txt`.

# License
[MIT](https://angular.io/license)
