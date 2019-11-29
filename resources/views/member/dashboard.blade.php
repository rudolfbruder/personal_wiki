@extends('layouts.app')
@section('title')
My Dashboard
@endsection
@section('content')
@include('partials.welcome',['header' => 'Welcome to your dashboard', 'underHeading' => 'All your enrolled guides
and courses.'])
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <h4 class="content-heading">Enrolled guides</h4>
            <hr>
            <div class="row">
                @foreach ($assets as $asset)
                <div class="col-lg-4 mb-3">
                    <a href="@if ($asset->type == 'guide')
                        {{ route('guide.show', $asset->slug) }}
                    @else
                        {{ route('course.show', [$asset->slug, auth()->user()->lastViewedEpisode($asset->id)->slug]) }}
                    @endif" class=" card asset scale">
                        <img src="{{ asset('storage/' . $asset->image) }}" class="card-img-top" alt="...">
                        <div class="card-body card-body-sm">
                            <h5 class="card-title-lg">{{$asset->title}}</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-3">
                {!! $assets->links() !!}
            </div>
        </div>
        <div class="col-lg-3">
            <form action="" method="GET" class="mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search" id="search">

            </form>
            <div class="list-group">
                <a href="{{ route('member.dashboard-tabular') }}" class="list-group-item list-group-item-action">Tabular
                    view</a>
                <a href="#" class="list-group-item list-group-item-action disabled">Messages</a>
                <a href="#" class="list-group-item list-group-item-action">Settings</a>
            </div>
        </div>
    </div>
</div>
@endsection