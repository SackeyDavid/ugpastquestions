@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard
                <span class="pull-right">{{ $pasquos->count() }} uploads</span>
                </div>

                <div class="panel-body">
                    <style type="text/css">
                        .dropzone {
                        border : 3px dashed #0088cc;
                        padding: 50px;
                        width: 100%;
                        margin-top:20px;
                        }

                    </style>


                    <center>
                        <form action="{{ route('questions.upload') }}" method="POST" class="dropzone">
                          {{ csrf_field() }}
                            
                        </form> 
                                    
                    </center>

                    
                    
                    <!-- @component('components.who')
                    @endcomponent
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in as user! -->
                    <span>
                       
                            @if($pasquos->count())

                            @foreach ($pasquos as $pasquo)
                            <p><a href="'/uploads/'.{{ $pasquo->path }}">{{ $pasquo->path }}</a></p>
                            @endforeach

                            @else
                            <p>no uploads</p>

                            @endif
                          
                         
                    </span>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
