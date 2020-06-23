@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a href="{{ route('profile') }}" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">Index</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('two.factor') }}" class="nav-link {{ request()->is('profile/twofactor') ? 'active' : '' }}">ToFactorAuth</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        @yield('main')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
