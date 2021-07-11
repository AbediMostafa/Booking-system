@extends('layouts.layout')
@section('content')
<section class="hiro">
    <div class="container pb-4">
        <div class="header-filter-container">
            <header-part :info="headerInfos"></header-part>
        </div>
    </div>
</section>

@verbatim
<section class="insert-comment">
    <div class="container">
    <div class="is-comment-score-container">
        <div class="is-scoring-container is-box-shadow">
            <h3 class="is-header">
                امتیازدهی
            </h3>
            <p class="is-text">
            به عناوین زیر از 1 تا 5 چه امتیازی می دهید؟
            </p>

            <div class="is-score-container" v-for="(scoreTitle , scoreTitleKey) in postData.scoresTitles" :key="scoreTitleKey">
                <span class="is-score-title">{{scoreTitle.title}}</span>
                <div class="is-score-digits">
                    <span 
                        v-for="digit in digits" 
                        :key="digit"
                        @click="selectScore(scoreTitleKey, digit)" 
                        :class="[scoreTitle.selectedKey == digit ? 'is-active-score-digit':'']">
                        {{digit}}
                    </span>
                </div>
            </div>
        </div>

        <div class="is-commenting-container is-box-shadow">
            <h3 class="is-header">
            ارسال نظر
            </h3>
            <p class="is-text">
            لطفا نظر خود را درمورد اتاق
            {{postData.roomInfo.name}}
            بیان کنید
            </p>

            <textarea v-model="postData.comment" cols="30" rows="10" class="is-texarea"></textarea>

            <div class="is-status-container">
                <div :class="['is-status-icon-text', postData.selectedStatus == 'disagree' ? 'is-active-score-digit':'']" @click="statusClicked('disagree')">
                    <img :src="iconPath('red-uncheck.svg')" class="small-icon">
                    <span>
                        توصیه نمی کنم
                    </span>
                </div>
                <div :class="['is-status-icon-text', postData.selectedStatus == 'agree' ? 'is-active-score-digit':'']" @click="statusClicked('agree')">
                    <img :src="iconPath('blue-check.svg')" class="small-icon">
                    <span>
                        توصیه می کنم
                    </span>
                </div>
                <div :class="['is-status-icon-text', postData.selectedStatus == 'no_idea' ? 'is-active-score-digit':'']" @click="statusClicked('no_idea')">
                    <img :src="iconPath('blue-check.svg')" class="small-icon">
                    <span>
                        نظری ندارم
                    </span>
                </div>
            </div>


            <a class="is-submit-comment" @click="submitComment">
                ارسال نظر
            </a>
        </div>
    </div>
        
    </div>
</section>
@endverbatim
@endsection

@section('scripts')
<script>
    const roomInfo = {
        name:'{{$roomName}}',
        id:'{{$roomId}}',
    }
</script>
<script src="{{asset('js/insertComment.js')}}"></script>
@endsection