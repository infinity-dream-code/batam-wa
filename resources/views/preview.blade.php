@extends('layouts.main')
@section('content')
    {{--    <div class="page-header d-print-none text-white">--}}
    {{--        <div class="container-xl">--}}
    {{--            <div class="row g-2 align-items-center">--}}
    {{--                <div class="col">--}}
    {{--                    <!-- Page pre-title -->--}}
    {{--                    <div class="page-pretitle">--}}
    {{--                        Overview--}}
    {{--                    </div>--}}
    {{--                    <h2 class="page-title">--}}
    {{--                        Navbar overlap layout--}}
    {{--                    </h2>--}}
    {{--                </div>--}}
    {{--                <!-- Page title actions -->--}}
    {{--                <div class="col-auto ms-auto d-print-none">--}}
    {{--                    <div class="btn-list">--}}
    {{--                  <span class="d-none d-sm-inline">--}}
    {{--                    <a href="#" class="btn btn-dark">--}}
    {{--                      New view--}}
    {{--                    </a>--}}
    {{--                  </span>--}}
    {{--                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">--}}
    {{--                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->--}}
    {{--                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>--}}
    {{--                            Create new report--}}
    {{--                        </a>--}}
    {{--                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">--}}
    {{--                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->--}}
    {{--                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>--}}
    {{--                        </a>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="d-flex justify-content-center">
                    <div class="col-8 py-3" data-aos="zoom-in">
                        <div id="carousel-captions" class="carousel slide shadow" data-bs-ride="carousel">
                            <div class="carousel-inner rounded-3">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" alt=""
                                         src="{{asset('assets/static/photos/coffee-on-a-table-with-other-items.jpg')}}">
                                    <div class="carousel-caption-background  d-md-block"></div>
                                    <div class="carousel-caption  d-md-block">
                                        <h3>Slide label</h3>
                                        <p>Nulla vitae elit libero, a pharetra augue mollis intkmkmkjikmnkmerdum.</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" alt=""
                                         src="{{asset('assets/static/photos/young-entrepreneur-working-from-a-modern-cafe-2.jpg')}}">
                                    <div class="carousel-caption-background  d-md-block"></div>
                                    <div class="carousel-caption  d-md-block">
                                        <h3>Slide label</h3>
                                        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" alt=""
                                         src="{{asset('assets/static/photos/soft-photo-of-woman-on-the-bed-with-the-book-and-cup-of-coffee-in-hands.jpg')}}">
                                    <div class="carousel-caption-background d-md-block"></div>
                                    <div class="carousel-caption d-md-block">
                                        <h3>Slide label</h3>
                                        <p>Nulla vitae elit libero, a pharetra augue mollis intemmlmkmkmkrdum.</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" alt=""
                                         src="{{asset('assets/static/photos/fairy-lights-at-the-beach-in-bulgaria.jpg')}}">
                                    <div class="carousel-caption-background  d-md-block"></div>
                                    <div class="carousel-caption  d-md-block">
                                        <h3>Slide label</h3>
                                        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" alt=""
                                         src="{{asset('assets/static/photos/woman-working-on-a-laptop-while-enjoying-a-breakfast-coffee-and-chocolate-in-bed-2.jpg')}}">
                                    <div class="carousel-caption-background  d-md-block"></div>
                                    <div class="carousel-caption  d-md-block">
                                        <h3>Slide label</h3>
                                        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carousel-captions" role="button"
                               data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-captions" role="button"
                               data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="col-12 py-3">
                <div class="card card-borderless shadow">
                    <div class="card-header d-flex justify-content-center">
                        <div class="card-title">Layanan Kami</div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-lg-4 row-cols-2">
                            @for($i = 0; $i <10; $i++)
                                <div class="col my-2">
                                    <div class="card rounded-5 card-borderless shadow hover-shadow-lg"
                                         data-aos="fade-down">
                                        <div class="card-header d-flex justify-content-center">
                                            Pertambangan
                                        </div>
                                        <div class="card-body d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-alphabet-latin icon-lg"
                                                 width="24"
                                                 height="24" viewBox="0 0 24 24" stroke-width="10"
                                                 stroke="currentColor"
                                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M6 10h2a2 2 0 0 1 2 2v5h-3a2 2 0 1 1 0 -4h3"></path>
                                                <path d="M14 7v10"></path>
                                                <path
                                                    d="M14 10m0 2a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    berita  --}}
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h1 class="">
                        Berita
                    </h1>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary rounded-5 d-sm-inline-block" data-bs-toggle="modal"
                           data-bs-target="#modal-report">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 5l0 14"/>
                                <path d="M5 12l14 0"/>
                            </svg>
                            Semua Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="row row-cols-lg-2 row-cols-1">
                    @for($i = 0; $i <5; $i++)
                        <div class="col my-2">
                            <div class="card card-borderless shadow hover-shadow-lg rounded-5" data-aos="zoom-in">
                                <div class="row row-0">
                                    <div class="col-5">
                                        <!-- Photo -->
                                        <img
                                            src="{{asset('assets/static/photos/beautiful-blonde-woman-relaxing-with-a-can-of-coke-on-a-tree-stump-by-the-beach.jpg')}}"
                                            class="w-100 h-100 object-cover card-img-start rounded-start-5" alt="pict">
                                    </div>
                                    <div class="col">
                                        <div class="card-body">
                                            <h3 class="card-title">Berita? {{$i}}</h3>
                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing
                                                elit.
                                                Aperiam deleniti fugit
                                                incidunt, iste, itaque minima
                                                neque pariatur perferendis sed suscipit velit vitae voluptatem.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    {{--    Galeri  --}}
    <div class="row col-12">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h1 class="">
                            Galeri
                        </h1>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="#" class="btn btn-primary rounded-5 d-sm-inline-block" data-bs-toggle="modal"
                               data-bs-target="#modal-report">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14"/>
                                    <path d="M5 12l14 0"/>
                                </svg>
                                Semua Galeri
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <div class="row g-2 g-md-3">
                    <div class="col-lg-6">
                        <div class="row g-2 g-md-3">
                            <div class="col-6">
                                <div class="row g-2 g-md-3">
                                    <div class="col-6">
                                        <a data-fslightbox="gallery"
                                           href="./static/photos/elegant-home-office-with-golden-accessories.jpg">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                                 style="background-image: url(./static/photos/elegant-home-office-with-golden-accessories.jpg)"></div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a data-fslightbox="gallery"
                                           href="./static/photos/stylish-workplace-with-computer-at-home.jpg">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                                 style="background-image: url(./static/photos/stylish-workplace-with-computer-at-home.jpg)"></div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a data-fslightbox="gallery"
                                           href="./static/photos/group-of-people-sightseeing-in-the-city.jpg">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                                 style="background-image: url(./static/photos/group-of-people-sightseeing-in-the-city.jpg)"></div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a data-fslightbox="gallery"
                                           href="./static/photos/color-palette-guide-sample-colors-catalog-.jpg">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                                 style="background-image: url(./static/photos/color-palette-guide-sample-colors-catalog-.jpg)"></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <a data-fslightbox="gallery"
                                   href="./static/photos/beautiful-blonde-woman-relaxing-with-a-can-of-coke-on-a-tree-stump-by-the-beach.jpg">
                                    <!-- Photo -->
                                    <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                         style="background-image: url(./static/photos/beautiful-blonde-woman-relaxing-with-a-can-of-coke-on-a-tree-stump-by-the-beach.jpg)"></div>
                                </a>
                            </div>
                            <div class="col-12">
                                <a data-fslightbox="gallery"
                                   href="./static/photos/contemporary-black-and-white-home-decor.jpg">
                                    <!-- Photo -->
                                    <div class="img-responsive img-responsive-4x1 rounded-3 border"
                                         style="background-image: url(./static/photos/contemporary-black-and-white-home-decor.jpg)"></div>
                                </a>
                            </div>
                            <div class="col-12">
                                <a data-fslightbox="gallery"
                                   href="./static/photos/pink-desk-in-the-home-office.jpg">
                                    <!-- Photo -->
                                    <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                         style="background-image: url(./static/photos/pink-desk-in-the-home-office.jpg)"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-2 g-md-3">
                            @for($i = 1; $i <=10; $i++)
                                @php
                                    $col = 6;
                                        if ($i == 1){
                                            $col = 12;
                                        }elseif ($i == 2 || $i == 3){
                                            $col = 6;
                                        }else{
                                            $col =3;
                                        }
                                @endphp
                                @if($i == 3)
                                    <div class="col-6">
                                        <div class="row g-2 g-md-3">
                                            <div class="col-6">
                                                <a data-fslightbox="gallery"
                                                   href="{{asset('assets/static/photos/home-office-desk-with-macbook-iphone-calendar-watch-and-organizer.jpg')}}">
                                                    <!-- Photo -->
                                                    <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                                         style="background-image: url({{asset('assets/static/photos/home-office-desk-with-macbook-iphone-calendar-watch-and-organizer.jpg')}})"></div>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a data-fslightbox="gallery"
                                                   href="./static/photos/young-woman-working-in-a-cafe.jpg">
                                                    <!-- Photo -->
                                                    <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                                         style="background-image: url(./static/photos/young-woman-working-in-a-cafe.jpg)"></div>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a data-fslightbox="gallery"
                                                   href="./static/photos/everything-you-need-to-work-from-your-bed.jpg">
                                                    <!-- Photo -->
                                                    <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                                         style="background-image: url(./static/photos/everything-you-need-to-work-from-your-bed.jpg)"></div>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a data-fslightbox="gallery"
                                                   href="./static/photos/young-entrepreneur-working-from-a-modern-cafe.jpg">
                                                    <!-- Photo -->
                                                    <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                                         style="background-image: url(./static/photos/young-entrepreneur-working-from-a-modern-cafe.jpg)"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-{{$col}}" data-aos="zoom-in">
                                        <a data-fslightbox="gallery"
                                           href="{{asset('assets/static/photos/beautiful-blonde-woman-relaxing-with-a-can-of-coke-on-a-tree-stump-by-the-beach.jpg')}}">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                 style="background-image: url({{asset('assets/static/photos/beautiful-blonde-woman-relaxing-with-a-can-of-coke-on-a-tree-stump-by-the-beach.jpg')}})"></div>
                                        </a>
                                    </div>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

