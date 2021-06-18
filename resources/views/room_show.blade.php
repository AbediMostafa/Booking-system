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
            @verbatim
<section class="show-room-content">
    <div class="container">
        <div class="show-room-container">
            <div class="rs-other-infos">
                <scores :rates="room.rates"></scores>
                <div class="rs-contact-infos">
                </div>
            </div>

            <div class="rs-description">

            </div>
        </div>


    </div>
</section>
            @endverbatim


@endsection

@section('scripts')
<script>
    const roomId = {{$id}}
</script>
<script src="{{asset('js/roomShow.js')}}"></script>
@endsection