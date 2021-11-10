@extends('layouts.layout')
@section('content')
@verbatim
        <!-- Hiro Section -->
        <section class="hiro">
            <div class="container pb-4">
                <div class="header-filter-container" :style="{'--bg': background}">
                    <header-part :info="headerInfos"></header-part>
                    <room-filter
                        :total-data="totalData"
                        @filterchanged="filterChanged"
                        ref="filter"
                    ></room-filter>
                </div>
            </div>
        </section>

        <section style="scroll-behavior: smooth;">
            <div class="container">
                <template v-for="(chunkedRooms, key) in _.chunk(tmpRooms, 10)">
                    <swiper
                        :options="swiperOptions"
                        class="swiper-centered-slides p-4"
                        dir="rtl"
                    >
                        <swiper-slide
                            v-for="room in chunkedRooms"
                            :key="room.id"
                            class="rounded swiper-shadow "
                        >
                            <complicated-room-card :room="room" no-readmore="learn"></complicated-room-card>
                        </swiper-slide>

                        <div class="swiper-button-prev nav-btns" slot="button-next"></div>
                        <div class="swiper-button-next nav-btns" slot="button-prev"></div>
                    </swiper>

                </template>
                <div class="pagination-container">
                    <div
                        class="pagination-btns"
                        v-for="(pagination, key) in paginations"
                        :key="key"
                        @click="goToRoomPage(pagination.url)"
                        :class="[pagination.active ? 'active-pagination' : '']"
                    >
                        {{ pagination.label }}
                    </div>
                </div>

            </div>
        </section>

@endverbatim
@endsection

@section('scripts')
    <script>
        const collectionTitle = '{{request()->get('collection')}}'
        const cityTitle = '{{request()->get('city')}}'
    </script>
    <script src="{{asset('js/roomSearch.js')}}"></script>
@endsection
