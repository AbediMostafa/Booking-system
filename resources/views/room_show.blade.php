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


@endsection

@section('scripts')
<script>
    const roomId = {{$id}}
</script>
<script src="{{asset('js/roomShow.js')}}"></script>
@endsection