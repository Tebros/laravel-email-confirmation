@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Account Confirmed</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-{{session('status_type')}}">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal" method="GET" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Continue Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
