@extends('layouts.layout')
@section('content')
    @verbatim

        <!-- Hiro Section -->
        <section class="hiro">
            <div class="container pb-4">
                <div class="header-filter-container" :style="{'--bg': background}">
                    <header-part :info="headerInfos"></header-part>
                </div>
            </div>
        </section>

        <section class="learning">
            <div class="container">
                <div class="learning-card-container">
                    <learning-card
                        v-for="movie in movies"
                        :key="movie.id"
                        :card="movie"
                        uri="movie"
                        class="lp-learning-card"
                    ></learning-card>
                </div>

                <div class="pagination-container">
                    <div
                        class="pagination-btns"
                        v-for="(pagination, key) in paginations"
                        @click=gotoPage(pagination.url)
                        :class="[pagination.active? 'active-pagination':'']"
                    >
                        {{pagination.label}}

                    </div>
                </div>
            </div>
        </section>

    @endverbatim


@endsection

@section('scripts')
    <script src="{{asset('js/movies.js')}}"></script>
@endsection
