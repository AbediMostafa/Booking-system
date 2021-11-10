@extends('layouts.layout')
@section('content')
    <section class="hiro">
        <div class="container pb-4">
            <div class="header-filter-container">
                <header-part :info="headerInfos"></header-part>
            </div>
        </div>
    </section>

    <section class="reserve">
        <div class="container">
            <div class="rs-box-shadow rsd-image-text-container">
                <div class="rsd-descripton-text">

                    {{-- select day--}}
                    <span class="d-form-lable">تقویم</span>
                    <vue-persian-datetime-picker
                        v-model="postData.day"
                        clearable
                        :highlight="highlight"
                        :disable="checkDate"
                    >
                    </vue-persian-datetime-picker>

                    <b-form-select
                        v-model="postData.hour"
                        :options="hourOptions"
                    >
                    </b-form-select>

                    <b-form-select
                        v-model="postData.peopleCount"
                        :options="room.peopleCount"
                    >
                    </b-form-select>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        const roomId = {{$roomId}}
    </script>
    <script src="{{asset('js/reserve.js')}}"></script>
@endsection
