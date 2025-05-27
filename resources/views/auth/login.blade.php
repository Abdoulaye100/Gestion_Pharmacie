<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>
<body style="display: flex; justify-content: center; align-items: center; min-height: 100vh">
    <div class="card" style="width: 100%; max-width: 70%">
        <div class="card-body d-flex">
            <div style="width:50%; background-color: rgba(0, 128, 0, 0.349);height: 600px; display: flex; justify-content: center;align-items: center">
                <img src="{{ asset('images/pharmacie.png') }}" alt="logo" width="50%">
            </div>
            <div style="width:50%;height: 600px">
                <form action="" style="height: 100%; padding: 20px; display: flex; align-items: center; flex-direction: column">
                    <img src="{{ asset('images/profil-de-lutilisateur.png') }}" alt="logo" width="100px" style="margin-bottom: 80px">
                    <div style="width: 100%; display: flex; justify-content: center; margin-bottom: 30px">
                        <label for="mail" style="width:30%; text-align: center">Email</label>
                        <input type="email" name="mail" id="mail"  class="inp-p" style="width: 60%">
                    </div>
                    <div style="width: 100%; display: flex; justify-content: center; margin-bottom: 100px">
                        <label for="password" style="width:30%; text-align: center">Mot de passe</label>
                        <input type="password" name="password" id="password" class="inp-p" style="width: 60%" >
                    </div>
                    <button type="button" class="btn btn-primary">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>