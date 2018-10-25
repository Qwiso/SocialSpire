<!DOCTYPE html>
<html>
    <head>
        <title>SocialWeb</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 80px;
                text-decoration: none;
            }

            .twitch {
                color: #6441a5;
            }

            .fa {
                -webkit-animation: breathing 9s ease-out infinite normal;
                animation: breathing 9s ease-out infinite normal;
            }

            @-webkit-keyframes breathing {
                0% {
                    -webkit-transform: scale(0.85);
                    -ms-transform: scale(0.85);
                    transform: scale(0.85);
                }

                35% {
                    -webkit-transform: scale(1);
                    -ms-transform: scale(1);
                    transform: scale(1);
                }

                95% {
                    -webkit-transform: scale(0.85);
                    -ms-transform: scale(0.85);
                    transform: scale(0.85);
                }

                100% {
                    -webkit-transform: scale(0.85);
                    -ms-transform: scale(0.85);
                    transform: scale(0.85);
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <a class="title" href="{{url('login/twitch')}}"><i class="twitch fa fa-4x fa-twitch"></i></a>
            </div>
        </div>
    </body>
</html>
