<!-- condition.blade.php -->

@if(auth()->check() && auth()->user()->is_admin == 1)
    @include('layouts.condition') <!-- Admin layout -->
@else
    @include('layouts.user_layout') <!-- User layout -->
@endif
