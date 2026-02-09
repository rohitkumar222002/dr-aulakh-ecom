<div>
@section('meta_title'){{ $page->meta_title??$page->page_name  }} @stop
@section('meta_keywords') {{ $page->meta_title??$page->meta_keyword }} @stop
@section('meta_description') {{ $page->meta_title??$page->meta_description }} @stop
    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="{{ route('site.index') }}">Home</a></li>
                    <li><a href="{{ url()->current() }}">{{ $page->page_name }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    @livewire('site.partial.search')

    <div class="coupons">
        <div class="container">
            <div class="shop-about">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="shop-description d-flex justify-content-center mb-5">
                                <h3>{{ $page->page_name ?? '' }}</h3>
                            </div>
                        </div>


                        @if (isset($page->banner))
                            <div class="col-md-12">
                                <div class="shop-full">
                                    <img src="{{ uploaded_asset($page->banner) }}" class="img-fluid">
                                </div>
                            </div>
                        @endif


                        <div class="col-md-12">
                            <div class="shop-description {{ isset($page->banner) ? 'mt-5' : '' }}">
                                @if (isset($page->page_desc))
                                    {!! $page->page_desc !!}
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
