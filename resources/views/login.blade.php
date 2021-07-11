@extends('layouts.layout')
@section('content')
<section class="hiro">
    <div class="container pb-4">
        <div class="header-filter-container">
            <header-part :info="headerInfos"></header-part>
        </div>
    </div>
</section>

<section class="login">
    <div class="li_container">
        <form action="/login" method="POST">
            @csrf
            <div class="li_form_group">
                <span class="li_label">نام کاربری</span>
                <div class="li_input">
                    <input type="text" name='email' class="d-search-input p-4">
                </div>
            </div>

            <div class="li_form_group">
                <span class="li_label">پسوورد</span>
                <div class="li_input">
                    <input type="password" name="password" class="d-search-input p-4">
                </div>
            </div>

            <button type="submit" class="li_login_btn">ورود</button>
            @if ($errors->any())
            <div class="alert alert-danger rtl-dir">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </form>

    </div>
</section>
@endsection
@section('scripts')
<script src="{{asset('js/login.js')}}"></script>
@endsection