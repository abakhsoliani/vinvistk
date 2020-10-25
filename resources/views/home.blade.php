@extends('layouts.app')

@section('content')
<div class="container">


@if(sizeof($errors)>0)
<div class="popup" id="popup">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="card-header"><span>@lang("home.Error")</span></div>
        <div class="card-body">
            <p>{{$errors[0]}}</p>
        </div>
        <a href="{{ url('/home') }}"class="btn btn-primary">@lang("home.Close error")</a>
    </div>
  </div>
</div>
@endif


<form class="modal modal-1 fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" method="post" action="/create_league" enctype="multipart/form-data">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="card-header"><span>{{ __('ახალი ლიგის შექმნა') }}</span></div>
        <div class="card-body">
            <p>თუ გსურს ახალი ლიგის შექმნა აირჩიე სასურველი სპორტი და მოუფიქრე ლიგას დასახელება</p>
                <div class="form-group">
                    <label for="sport">აირჩიე სპორტი</label>
                    <select class="form-control" id="sport" name="sport">
                        @foreach($sports as $sport)
                            <option value="{{$sport->id}}">{{$sport->name}}</option>
                        @endforeach
                    
                    </select>
                </div>
                <div class="form-group">
                    <label for="league-name">ჩაწერე ლიგის დასახელება</label>
                    <input type="text" class="form-control" id="league-name" name="league_name" placeholder="ლიგის დასახელება">
                </div>
                
                @csrf
            <input class="btn btn-primary float-right" type="submit"  value="დასრულება">
        </div>
    </div>
  </div>
</form>


<form class="modal modal-2 fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" method="post" action="/enter_league" enctype="multipart/form-data">
  <div class="modal-dialog modal-lg">
      @csrf
    <div class="modal-content">
        <div class="card-header"><span>@lang("league.Enter league")</span></div>
        <div class="card-body">
            <p>@lang("league.Enter league instruction")</p>
                
                <div class="form-group">
                    <input type="text" class="form-control" id="league_code" name="league_code" placeholder='@lang("league.Enter league code")'>
                </div>
                
                
            <input class="btn btn-primary float-right" type="submit"  value='@lang("league.Enter league button")'>
        </div>
    </div>
  </div>
</form>


    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header"><span>@lang("league.My leagues")</span> <button class="btn-secondary" data-toggle="modal" data-target=".modal-1">@lang("league.Create league")</button><button class="btn-primary" data-toggle="modal" data-target=".modal-2" style="margin-right: 20px">@lang("league.Enter league")</button></div>

                <div class="card-body">
               

                    @foreach($league_entries as $league_entry)

                        <a class="league" href="league/{{$league_entry->league->id}}">
                            <img src="images/{{$league_entry->league->sport->image}}">
                            <div class="league-name">{{$league_entry->league->name}}</div>
                            <div class="league-score">{{$league_entry->score}}</div>
                        </a>
                          
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3" style="font-size: .8em;">
            <div class="card">
                <div class="card-header">@lang("league.My games")</div>

                <div class="card-body">
               

                @foreach($matches as $match)

                <?php

                if($match->first_user_score-$match->first_user_old_score>0){
                    $firstTipClass = "green";
                    $firstPlus = "+";
                } else{
                    $firstTipClass = "red";
                    $firstPlus = "";

                }

                if($match->second_user_score-$match->second_user_old_score>0){
                    $secondTipClass = "green";
                    $secondPlus = "+";

                } else{
                    $secondTipClass = "red";
                    $secondPlus = "";

                }


                ?>

                <div class="match big">
                    <div class="match-league">
                        <img src="images/{{$match->league->sport->image}}">
                        {{$match->league->name}}
                    </div>
                <div class="player-names">
                    <span class="{{$firstTipClass}}">{{$match->first_user->name}}</span>
                    <span class="{{$secondTipClass}}">{{$match->second_user->name}}</span>
                </div> 
                <div class="player-goals">
                    <span class="{{$firstTipClass}}">{{$match->first_user_goals}}</span>
                    <span class="{{$secondTipClass}}">{{$match->second_user_goals}}</span>
                </div> 
                <div class="player-scores">
                    <span class="{{$firstTipClass}}">{{$match->first_user_score}}
                        <span class="tip">{{$firstPlus}}{{$match->first_user_score-$match->first_user_old_score}}</span>
                    </span>
                    <span class="{{$secondTipClass}}">{{$match->second_user_score}}
                        <span class="tip">{{$secondPlus}}{{$match->second_user_score-$match->second_user_old_score}}</span>
                    </span>
                </div> 

                </div>

                @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
