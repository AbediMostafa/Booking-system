@extends('layouts.layout')
@section('content')
<!-- Hiro Section -->
<section class="hiro">
    <div class="container pb-4">
        <div class="header-filter-container" :style="{'--bg': background}">
            <header-part :info="headerInfos"></header-part>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <collections></collections>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{asset('js/collections.js')}}"></script>
@endsection
