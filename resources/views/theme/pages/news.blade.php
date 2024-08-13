@extends('theme.main')



@section('pagecss')

    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/jssocials/jssocials.css') }}" />

    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/jssocials/jssocials-theme-flat.min.css') }}" />



    <style>

        {{ str_replace(array("'", "&#039;"), "", $news->styles ) }}

    </style>

@endsection



@section('content')



<div class="container topmargin-lg bottommargin-lg">{{-- topmargin-lg bottommargin-lg --}}

    <div class="row">

        <span onclick="closeNav()" class="dark-curtain"></span>

        <div class="col-lg-12 col-md-5 col-sm-12">

            <span onclick="openNav()" class="button button-small button-circle border-bottom ms-0 text-initial nols fw-normal noleftmargin d-lg-none mb-4"><span class="icon-chevron-left me-2 color-2"></span> Filter</span>

        </div>

        <div class="col-lg-3 pe-lg-4 mt-5">

            <div class="tablet-view">

                <a href="javascript:void(0)" class="closebtn d-block d-lg-none" onclick="closeNav()">&times;</a>



                <div class="card border-0 bg-transparent">

                    <div class="border-0 mb-5">

                        <h3 class="mb-3">Search</h3>

                        <div class="search">

                            <form class="mb-0" method="get" id="frm_search">

                                <div class="searchbar">

                                    <input type="text" name="searchtxt" class="form-control form-input form-search" placeholder="Search news" aria-label="Search news" aria-describedby="button-addon1" />

                                    <button class="form-submit-search" type="submit" name="submit">

                                        <i class="icon-line-search"></i>

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>



                    <div class="border-0 mb-5">

                        <h3 class="mb-3">News</h3>

                        <div class="side-menu">

                            {!! $dates !!}

                        </div>

                    </div>



                    <div class="border-0 mb-5">

                        <h3 class="mb-3">Categories</h3>

                        <div class="side-menu">

                            <ul class="mb-0 pb-0">

                                {!!$categories!!}

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-9 mt-5">

            <div class="article-card">

                <div class="article-title">

                    <h2>{{$news->name}}</h2>

                </div>

                {{-- <div class="article-meta">

                    <div class="entry-meta mb-3">

                        <ul class="small">

                            <li><i class="icon-calendar3"></i> {{ date('F d, Y',strtotime($news->date)) }}</li>

                            <li><i class="icon-user"></i> {{$news->user->fullname}}</li>

                            <li><i class="icon-folder-open"></i> <a href="#">{{ $news->category->name }}</a></li>

                        </ul>

                    </div>

                    <hr class="mb-4" />

                </div> --}}

                <div class="article-image">

                    @if($news->thumbnail_url)

                        <img class="mb-5 w-100" src="{{ $news->thumbnail_url }}" src="{{ $news->thumbnail_url }}" alt="{{$news->name}}">

                    @elseif($news->image_url)

                        <img class="mb-5 w-100" src="{{ $news->image_url }}" src="{{ $news->image_url }}" alt="{{$news->name}}">

                    @else

                        <img class="mb-5 w-100" src="{{ asset('storage/news_image/news_thumbnail/No_Image_Available.jpg')}}" alt="{{ $news->name }}">

                    @endif

                </div>



                {!! $news->contents !!}



                <br><br>

                <div class="news-share">

                    <h5>Share:</h5>

                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('news.front.show',$news->slug) }}" class="social-icon si-rounded si-facebook">

                        <i class="icon-facebook"></i>

                        <i class="icon-facebook"></i>

                    </a>

                    <a target="_blank" href="https://twitter.com/intent/tweet?url={{ route('news.front.show',$news->slug) }}&text=text to share" class="social-icon si-rounded si-twitter">

                        <i class="icon-twitter"></i>

                        <i class="icon-twitter"></i>

                    </a>

                    <a target="_blank" href="https://www.linkedin.com/uas/login?session_redirect=https://www.linkedin.com/shareArticle?mini=true&url={{ route('news.front.show',$news->slug) }}" class="social-icon si-rounded si-linkedin">

                        <i class="icon-linkedin"></i>

                        <i class="icon-linkedin"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection



@section('pagejs')

    <script>

        $('#frm_search').on('submit', function(e) {

            e.preventDefault();

            window.location.href = "{{route('news.front.index')}}?type=searchbox&criteria="+$('#searchtxt').val();

        });

    </script>

@endsection

