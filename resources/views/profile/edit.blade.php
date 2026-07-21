@extends('layouts.booking')

@section('title', 'Profile')

@section('hero')
    <small class="text-uppercase" style="letter-spacing:.15em; color:var(--color-accent);">StayPinas</small>
    <h1 class="mb-1">Account Settings</h1>
    <p class="mb-0">Manage your profile information and account security.</p>
@endsection

@section('content')
    <div class="mx-auto" style="max-width: 640px;">
        <div class="card p-4 p-md-5 mb-4">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card p-4 p-md-5 mb-4" id="password">
            @include('profile.partials.update-password-form')
        </div>

        <div class="card p-4 p-md-5">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
