<!DOCTYPE html>
<html lang="en">
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <title>Document</title>
</head>

<body>
    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submit').on('click', function(event) {
                event.preventDefault(); // Prevent default form submission if inside a form

                const email = $('#exampleInputEmail1').val();
                const password = $('#exampleInputPassword1').val();

                $.ajax({
                    url: '/api/login',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        email: email,
                        password: password
                    }),
                    success: function(response) {
                        console.log('Login successful:', response);
                        localStorage.setItem('api_token', response.token);
                        window.location.href = "/table"
                    },
                    error: function(xhr, status, error) {
                        console.error('Login failed:', error);
                    }
                });
            });
        });
    </script>
</body>

</html>
