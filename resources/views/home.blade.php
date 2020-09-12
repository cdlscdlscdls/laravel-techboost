@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
                <div class="card-body">
                  <a href="/news">News</a>
                </div>
                <div class="card-body">
                  <a href="/profile">Profile</a>
                </div>
                <div class="card-body">
                  <a href="/admin/news">Admin News</a>
                </div>
                <div class="card-body">
                  <a href="/admin/profile">Admin Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
