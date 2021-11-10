@extends('layouts.layout')
@section('content')
    @verbatim
        <!-- Hiro Section -->
        <section class="hiro">
            <div class="container pb-4">
                <div class="header-filter-container">
                    <header-part :info="headerInfos"></header-part>
                </div>
            </div>
        </section>

        <section style="scroll-behavior: smooth;">
            <div class="container">
                <div class="text-center">
                    <div class="s-offer-nav-container">
                      <span
                          v-for="(specialType, key) in specialTypes"
                          :class="[key == selectedSpecialKey ? 'special-active' : '']"
                          :key="key"
                          :ref="key"
                          @click="specialClicked(key)"
                      >
                        {{ specialType.title }}
                      </span>
                    </div>
                </div>
                <hr class="s-o-n-hr" :style="hrStyle"/>

                <template v-for="(chunkedRooms, key) in _.chunk(rooms,10)">
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

                            <room-card
                                :key="room.id"
                                :room="room"
                                :type="selectedSpecialKey"
                            ></room-card>


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
                        @click="getRooms(pagination.url)"
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
        const roomType = '{{$roomType}}'
    </script>
    <script src="{{asset('js/specialRooms.js')}}"></script>
@endsection
