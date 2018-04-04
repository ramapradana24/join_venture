<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Joinventure - Log in</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Signika:400" rel="stylesheet">
    <style>
        body{
            margin-top: 50px;
            background-image: url({{asset('img/bg-01-01.jpg')}});
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Signika', sans-serif;
        }
        
        .navFont {
            font-size: 24px;
        }
        
        .buttonRounded {
            border-radius: 25px;
        }

        .cardRadius {
            border-radius: 100px;
        }
      
        .imgThumb {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            max-width: 100%;
            height: auto;
        }
        input{
            border-radius: 25px !important;
            margin-bottom: 8px;
        }

        .small-input{
            height: 30px !important;
        }

        .navbar-header {
          float: left;
          padding: 5px;
          text-align: center;
          width: 100%;

        }
        .navbar-brand {float:none;}

        .title{
          padding: 24px;
          text-align: center;
          text-transform: uppercase;
          font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="fixed-top navbar navbar-expand-lg navbar-light bg-light justify-content-between" style="background-color: #fff !important; box-shadow: 0 0.5px 2px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
      <div class="navbar-header">
        <a class="navbar-brand ml-3 mr-5 navFont" href="/"><b style="color: #5c8e2f">JOINVENTURE</b></a>
      </div>
    </nav>


    <div class="container" style="margin-top:150px;"> 
      <div class="card" style="max-width:500px; margin: 0 auto; border-radius: 25px;">

        <div class="col-sm-12 title navFont">
          <h4>login</h4>
        </div>
          
        <div class="col-sm-12" style="margin-bottom: 24px;">

          
            @if(session('status'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 25px !important;">
              {{session('status')}}

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
          <form action="{{ route('login') }}" method="post">
            @csrf
            <input type="text" class="form-control {{ session()->has('email') ? ' is-invalid' : '' }}" name="email_log" placeholder="Email Address" required autofocus>

            @if (session()->has('email'))
                <span class="invalid-feedback" style="text-align: center; margin-bottom: 8px;">
                  <strong>the account you have entered is not match to our records</strong>
                </span>
            @endif

            <input type="password" class="form-control {{ $errors->has('password_log') ? ' is-invalid' : '' }}" name="password_log" placeholder="Password" required autofocus>

            <button type="submit" class="btn btn-success btn-block" style="border-radius:25px; margin-top:20px;">login</button>

            <div class="row col-sm-12" style="margin-top:10px;">
              <div class="col-md-6">
                <a href="/password/reset">Forget Password?</a>  
              </div>
              <div class="col-md-6">
                <a href="/" >Sign up for JoinVenture</a>
              </div>
            </div>
            
          </form>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>