@extends('layouts.main')
@section('content')
    <!-- ======= Hero Section ======= -->
    @include('main.hero')
    <!-- End Hero Section -->

    <main id="main">
        @include('main.about')

        @include('main.service')

        @include('main.faq')

        @include('main.contact')

        {{-- @include('main.contact') --}}
    </main>

@endsection
