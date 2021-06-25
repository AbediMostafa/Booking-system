@extends('layouts.layout')
@section('content')
<!-- Hiro Section -->
<section class="hiro">
    <div class="container pb-4">
        <div class="header-filter-container" :style="{'--bg': background}">
            <header-part :info="headerInfos"></header-part>
            @verbatim
            <room-filter :total-data="totalData" @search="roomSearch" @filterchanged="filterChanged"></room-filter>
            @endverbatim
        </div>
    </div>
</section>

<section class="special-rooms">
    <div class="container" ref="cardContainer">
        <div class="global-card-container">
            <complicated-room-card v-for="room in tmpRooms" :key="room.id" :room="room"></complicated-room-card>
        </div>
    </div>
</section>


@endsection

@section('scripts')
<script>
     const collectionTitle = '{{request()->get('collection')}}'  
     const cityTitle = '{{request()->get('city')}}'  
</script>
<script src="{{asset('js/roomSearch.js')}}"></script>
@endsection