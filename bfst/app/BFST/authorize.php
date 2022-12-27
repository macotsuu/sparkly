<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

        <style>
            @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

            body{
                margin: 0;
                font-size: .9rem;
                font-weight: 400;
                line-height: 1.6;
                color: #212529;
                text-align: left;
                background-color: #f5f8fa;
            }

            .form-group {
                padding: 8px 0;
            }
        </style>

        <title>Logowanie | Blazing Fast Sales Tool</title>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">Logowanie</div>
                        <div class="card-body">
                            <form id="login">
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Nazwa użytkownika</label>
                                    <div class="col-md-6">
                                        <input type="email" id="email" class="form-control" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Hasło</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <span id="error"></span>
                                    <input type="submit" value="Zaloguj się" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#login").submit(ev => {
               $.ajax("<?= BFST_APP_URL ?>/ajax?func=\\BFST\\User\\Authorization::authorize", {
                   method: 'POST',
                   data: {
                       email: $("#email").val(),
                       password: $("#password").val()
                   },
                   success: data => {
                       const response = JSON.parse(data);

                       if (response.status === 1) {
                           window.location = "<?= BFST_APP_URL ?>";
                       }

                       $('#error').html(response.message);
                   }
               })
                ev.preventDefault();
            });
        </script>
    </body>
</html>