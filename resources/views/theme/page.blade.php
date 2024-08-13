@extends('theme.main')

@section('pagecss')
    <style>
        {{ str_replace(array("'", "&#039;"), "", $page->styles ) }}
    </style>
@endsection

@section('content')
<div class="container topmargin-lg bottommargin-lg">
    <div class="row">
        @if($parentPage)
            <span onclick="closeNav()" class="dark-curtain"></span>
            <div class="col-lg-12 col-md-5 col-sm-12">
                <span onclick="openNav()" class="button button-small button-circle border-bottom ms-0 text-initial nols fw-normal noleftmargin d-lg-none mb-4"><span class="icon-chevron-left me-2 color-2"></span> Quicklinks</span>
            </div>
            <div class="col-lg-3 pe-lg-4">
                <div class="tablet-view">
                    <a href="javascript:void(0)" class="closebtn d-block d-lg-none" onclick="closeNav()">&times;</a>

                    <div class="card border-0">
                        <h3>Quicklinks</h3>
                        <div class="side-menu">
                            <ul class="mb-0 pb-0">
                                <!--<li @if($parentPage->id == $page->id) class="active" @endif>
                                    <a href="{{ $parentPage->get_url() }}"><div>{{ $parentPage->name }}</div></a>
                                </li>-->
                                @foreach($parentPage->sub_pages as $subPage)
                                    <li @if($subPage->id == $page->id) class="active" @endif>
                                        <a href="{{ $subPage->get_url() }}"><div>{{ $subPage->name }}</div></a>
                                        @if ($subPage->has_sub_pages())
                                            <ul>
                                                @foreach ($subPage->sub_pages as $subSubPage)
                                                <li @if ($subSubPage->id == $page->id) class="active" @endif>
                                                    <a href="{{ $subSubPage->get_url() }}"><div>{{ $subSubPage->name }}</div></a>
                                                    @if ($subSubPage->has_sub_pages())
                                                    <ul>
                                                        @foreach ($subSubPage->sub_pages as $subSubSubPage)
                                                            <li @if ($subSubSubPage->id == $page->id) class="active" @endif>
                                                                <a href="{{ $subSubSubPage->get_url() }}"><div>{{ $subSubSubPage->name }}</div></a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                {!! $page->contents !!}
            </div>
        @else
            <div class="col-lg-12">
                {!! $page->contents !!}
            </div>
        @endif
    </div>
</div>
@endsection
