<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="University of Ghana past examination questions">
        <meta name="author" content="University of Ghana">
        <meta name="keyword" content="University of Ghana, Past Questions, Examination, Departments, Students, Courses">

        <!-- Links -->
        <link href="{{ URL::To('img/ug_logo.jpg') }}" type="image/jpg" rel="shortcut icon">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        
        <script src="js/bootstrap.js"></script>
        

        <title>UG - Past Questions</title>


        <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script> -->
        <script src="js/jquery.js"></script>
        <script src="js/angular.min.js"></script>
        
            <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!--scripts -->
        <!-- {{ Html::script('js/jquery-3.2.1.min.js') }} -->

        <script>
            window.Laravel = {
                csrfToken: '{{csrf_token()}}'
            }
        </script>

        <!-- Styles -->
        <style>
        <!-- Bootstrap CSS -->  
        
        {!!Html::style('css/bootstrap.css')!!}
        {!!Html::style('css/bootstrap.min.css')!!} 
        {!!Html::style('css/app.css')!!}

        @yield('style')
    
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 28vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                margin-bottom: 0%;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }


            .content {
                margin-top: 8%;
                text-align: center;
            }

            @supports (-ms-ime-align: auto) {
                .content {
                margin-top: 40%;
                text-align: center;
                }

                .full-height {
                height: 30vh;
                }
            }

            .title {
                font-size: 54px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 20px;
            }

            .footer {
                  position: fixed;
                  right: 0;
                  bottom: 0;
                  left: 0;
                  padding: 1rem;
                  background-color: #efefef;
                  padding-right: 20%;
                  padding-left: 20%;
                }
        </style>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
 -->
            
            <div class="content">
                
                <div class="title m-b-xm">
                   <img src="{{ URL::to('img/ug_pasquo.png') }}" class="img-responsive"  width="80%">
                </div>
                <br><br>
                <div class="col-md-12 input-group" style="margin-top: 0%;">
                    
                        <input type="text" id="searchinput" name="searchinput" class="form-control" height="50px" width="100%" placeholder="Type course code or title here">
                        
                       
                </div>
                <hr>
                <br><br>
                


                        
               
                <!-- <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                
                </div> -->
            </div>

            
        </div>

        <center class="results">
            <!-- @component('components.who')
            @endcomponent -->

          
  


        </center>


        <footer class="footer">
            <ul class="list-inline">
                <li style="margin-right: 20%;"><a href="#"><b> Copyright © 2017 - University of Ghana Balme Library </b></a></li>
                <li><a href="{{ route('login') }}"><b> Department Login</b></a></li>
            </ul>
        </footer>
        
        {!!Html::script('js/bootstrap.js')!!}
        @yield('script')
        
    <!-- <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script> -->
    <script type="text/javascript">

            /*$(document).ready(function() {
            });*/
              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
            

            $('#searchinput').on('keyup', function(){
               $value = $(this).val();
               
                $.ajax({
                    type : 'GET',
                    url  : '{{ route('questions.search') }}',
                    data : {'searchinput':$value},
                    success:function(data){
                        /*console.log(data);*/
                        if($value != ""){
                              $('.results').html(data);
                          }
                        else
                        {
                            $('.results').html('');
                        }
                    }
                }); 
                });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                //console.log($(this).attr('href').split('page='));
                var page = $(this).attr('href').split('page=')[1];
                getPasquo(page, $('#searchinput').val());
            })
            function getPasquo(page, searchinput)
            {

                var url = "{{ route('questions.search') }}";

                $.ajax({
                    type : 'GET',
                    url  : url + '?page=' + page,
                    data : {'searchinput': searchinput },
                }).done(function(data) {
                    $('.results').html(data);
                })
            }



        </script>
    </body>
    
</html>
