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
            </h3>
            <p class="is-text">
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
            </h3>
            <p class="is-text">
            {{postData.roomInfo.name}}
            </p>

            <textarea v-model="postData.comment" cols="30" rows="10" class="is-texarea"></textarea>

            <div class="is-status-container">
                <div :class="['is-status-icon-text', postData.selectedStatus == 'disagree' ? 'is-active-score-digit':'']" @click="statusClicked('disagree')">
                    <img :src="iconPath('red-uncheck.svg')" class="small-icon">
                    <span>
                    </span>
                </div>
                <div :class="['is-status-icon-text', postData.selectedStatus == 'agree' ? 'is-active-score-digit':'']" @click="statusClicked('agree')">
                    <img :src="iconPath('blue-check.svg')" class="small-icon">
                    <span>
                </div>
                <div :class="['is-status-icon-text', postData.selectedStatus == 'no_idea' ? 'is-active-score-digit':'']" @click="statusClicked('no_idea')">
                    <img :src="iconPath('blue-check.svg')" class="small-icon">
                    <span>
                    </span>
                </div>
            </div>
            @endverbatim


            <div class="short-description mt-8 mb-0 ">
                <img src="/images/icons/blue-grey-check.svg" class="ml-2 header-room-icons">
                <div class="mr-4">
                    {!! $commenting_rules!!}
                  </div>
            </div>
            @verbatim


            <a class="is-submit-comment" @click="submitComment">
                {{sendComment}}
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
        name:'@isset($roomName){{$roomName}}@endisset',
        id:'@isset($roomId){{$roomId}}@endisset',
    }
    const type = '{{$type}}';
    const comment = @isset($comment)@json($comment, JSON_PRETTY_PRINT)@endisset;
    const commentingRules = '{{$commenting_rules}}'
</script>
<script src="{{asset('js/insertComment.js')}}"></script>
@endsection
