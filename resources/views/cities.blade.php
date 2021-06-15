@extends('layouts.layout')
@section('content')
<!-- Hiro Section -->
<section class="hiro">
    <div class="container pb-4">
        <div class="header-filter-container">
            <header-part :info="headerInfos"></header-part>
        </div>
    </div>
</section>

<section class="special-rooms">
    <div class="container">
        <cities></cities>
    </div>
</section>


@endsection

@section('scripts')
<script src="{{asset('js/cities.js')}}"></script>
@endsection