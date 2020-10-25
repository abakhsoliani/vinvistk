@extends('layouts.app')

@section('content')
<div class="container">




<form class="modal modal2 fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" method="post" action="/add_match" enctype="multipart/form-data">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="card-header"><span>@lang("league.New game")</span></div>
        <div class="card-body">
            <p>@lang("league.New game instruction")</p>
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="first_player">@lang("league.Select first player")</label>
                        <select class="form-control" id="first_player" name="first_player">
                            @foreach($league_entries as $league_entry)
                                <option value="{{$league_entry->id}}">{{$league_entry->user->name}}</option>
                            @endforeach
                        
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="first_player_score">@lang("league.First players") {{$sport->goal_name_ge}}</label>
                        <input type="number" class="form-control" id="first_player_score" name="first_player_score" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="second_player">@lang("league.Select second player")</label>
                        <select class="form-control" id="second_player" name="second_player">
                            @foreach($league_entries as $league_entry)
                            <option value="{{$league_entry->id}}">{{$league_entry->user->name}}</option>
                            @endforeach
                        
                        </select>
                    </div>
                    <input type="hidden" value="{{$league->id}}" name="league_id">
                    <div class="form-group">
                        <label for="second_player_score"> @lang("league.Second players") {{$sport->goal_name_ge}}</label>
                        <input type="number" class="form-control" id="second_player_score" name="second_player_score" >
                    </div>
                </div>
            </div>
            <input class="btn btn-primary float-right" type="submit"  value='@lang("league.Finish")'>
        </div>
    </div>
  </div>
</form>

    <div class="row justify-content-center">
        <div class="col-md-9" >
            <div class="card">
                <div class="card-header"><span>{{$league->name}} - @lang("league.Table")</span> <span style="float:right;">@lang("league.Invite friend") {{$league->unique_id}}</span></div>

                <div class="card-body">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">#</th>
                            <th >@lang("league.Name")</th>
                            <th >@lang("league.Played")</th>
                            <th >@lang("league.Won")</th>
                            @if($sport->has_draw)
                                <th >@lang("league.Draw")</th>
                            @endif
                            <th >@lang("league.Lost")</th>
                            <th >{{$sport->goal_name_ge}} +</th>
                            <th >{{$sport->goal_name_ge}} -</th>
                            <th >@lang("league.Avg").{{$sport->goal_name_ge}} +</th>
                            <th >@lang("league.Avg"){{$sport->goal_name_ge}} -</th>
                            <th >@lang("league.Min points")</th>
                            <th >@lang("league.Max points")</th>
                            <th >@lang("league.Points")</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($league_entries as $league_entry)
                            <tr>
                                <?php 
                                
                                $goalsforavg = 0;
                                $goalsagainstavg = 0;

                                if($league_entry->played!=0){
                                    $goalsforavg = $league_entry->goals_for/$league_entry->played;
                                    $goalsagainstavg = $league_entry->goals_against/$league_entry->played;

                                } 
                                ?>

                            <th scope="row">{{$loop->index+1}}</th>
                            <td><a href="{{$league->id}}/user/{{$league_entry->user->id}}">{{$league_entry->user->name}}</a></td>
                            <td>{{$league_entry->played}}</td>
                            <td>{{$league_entry->win}}</td>
                            @if($sport->has_draw)
                                <td>{{$league_entry->draw}}</td>
                            @endif
                            <td>{{$league_entry->loose}}</td>
                            <td>{{$league_entry->goals_for}}</td>
                            <td>{{$league_entry->goals_against}}</td>
                            <td>{{round($goalsforavg,2)}}</td>
                            <td>{{round($goalsagainstavg,2)}}</td>
                            <td>{{round($league_entry->min_score,2)}}</td>
                            <td>{{round($league_entry->max_score,2)}}</td>
                            <td>{{round($league_entry->score,2)}}</td>
                            </tr>

                            @endforeach
                           
                        </tbody>
                    </table>

                
                </div>
            </div>
        </div>
        <div class="col-md-3" style="font-size: .8em;">
            <div class="card">
                <div class="card-header"><span>@lang("league.Last games")</span><button class="btn-primary" data-toggle="modal" data-target=".modal2">თამაშის დამატება</button></div>

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

                        <form class="match" method="post" action="/delete_match" enctype="multipart/form-data">
                            @csrf
                            <div class="player-names ">
                                <span class="{{$firstTipClass}}">{{$match->first_user->name}}</span>
                                <span class="{{$secondTipClass}}">{{$match->second_user->name}}</span>
                            </div> 
                            <div class="player-goals">
                                <span class="{{$firstTipClass}}">{{$match->first_user_goals}}</span>
                                <span class="{{$secondTipClass}}">{{$match->second_user_goals}}</span>
                            </div> 
                            <div class="player-scores">
                                
                              
                                <span class="{{$firstTipClass}}">{{round($match->first_user_score,2)}}
                                    <span class="tip">{{$firstPlus}}{{round($match->first_user_score-$match->first_user_old_score,2)}}</span>
                                </span>
                                <span class="{{$secondTipClass}}">{{round($match->second_user_score,2)}}
                                    <span class="tip">{{$secondPlus}}{{round($match->second_user_score-$match->second_user_old_score,2)}}</span>
                                </span>
                            </div> 
                            <input type="hidden" name="match_id" value='{{$match->id}}'>
                            <input type="hidden" name="league_id" value='{{$league->id}}'>
                            <input type="submit" value='@lang("league.Delete game")' class="btn btn-danger" style="    font-size: 0.8em;position: absolute;right: 0;bottom: 0;">
                        </form>

                @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
