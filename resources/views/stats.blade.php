@extends('layouts.app')

@section('content')
<div class="container">




    <div class="row justify-content-center">
        <div class="col-md-9" >
            <div class="card">
                <div class="card-header">{{$user->name}} - @lang("league.Head2head")</div>

                <div class="card-body">
                    
                @foreach($sorted_opponents as $opponent)
                    <div class="opponent" style="margin-bottom : 15px;">
                        <h3>
                            {{$opponent['user']->name}}    
                        </h3>
                        <p>@lang("league.Won"):{{$opponent['wins']}} 
                        @if($sport->has_draw)
                            - @lang("league.Draw"):
                            {{$opponent['draw']}}
                        @endif
                         - @lang("league.Lost"):{{$opponent['lost']}}</p>
                        <p>  +{{$sport->goal_name_ge}} :{{$opponent['goals_for']}} <br> -{{$sport->goal_name_ge}} :{{$opponent['goals_against']}}</p>
                        <div class="games">
                            @foreach($opponent['matches'] as $match)
                            <?php 
                            

                            $class = "draw";
                            if($match->first_user_goals > $match->second_user_goals){
                                if($match->first_user_id == $user->id) {
                                    $class="win";
                                }  else {
                                    $class="lose";
                                }
                            } elseif($match->first_user_goals < $match->second_user_goals){
                                if($match->first_user_id == $user->id) {
                                    $class="lose";
                                }  else {
                                    $class="win";
                                }
                            } 
                            

                            if($match->first_user_id == $user->id) {
                                $change = $match->first_user_score - $match->first_user_old_score;
                            } else {
                                $change = $match->second_user_score - $match->second_user_old_score;
                            }
                            
                            
                            
                            
                            ?>

                                <div class="game {{$class}}">
                                {{$match->first_user_goals}} - {{$match->second_user_goals}}

                                    <span class="hint">@lang("league.Score change") : {{$change}}</span>
                                </div>

                            @endforeach
                        </div>
                    </div>
                    

                @endforeach
    
                
                </div>
            </div>
        </div>
        <div class="col-md-3" style="font-size: .8em;">
            <div class="card">
                <div class="card-header">{{$league->name}} - {{$user->name}} @lang("league.Statistics")</div>

                <?php 
                

                $prcwin = 0;
                $prclose = 0;
                $prcdraw = 0;
                $goalsforavg = 0;
                $goalsagainstavg = 0;

                if($league_entry->played!=0){
                    $goalsforavg = $league_entry->goals_for/$league_entry->played;
                    $goalsagainstavg = $league_entry->goals_against/$league_entry->played;
                    $prcwin = $league_entry->win*100/$league_entry->played;
                    $prclose = $league_entry->loose*100/$league_entry->played;
                    $prcdraw = $league_entry->draw*100/$league_entry->played;
                } 
                
                
                ?>



                <div class="card-body">
                    <div class="stat">@lang("league.Played") - {{$league_entry->played}}</div>
                    <div class="stat">@lang("league.Won") - {{$league_entry->win}}</div>
                    @if($sport->has_draw)

                    <div class="stat">@lang("league.Draw") - {{$league_entry->draw}}</div>
                    @endif

                    <div class="stat">@lang("league.Lost") - {{$league_entry->loose}}</div>
                    <div class="stat">@lang("league.Won") % - {{$prcwin}}%</div>
                    @if($sport->has_draw)
                        <div class="stat">@lang("league.Draw") % - {{$prcdraw}}%</div>
                    @endif
                    <div class="stat">@lang("league.Lost") % - {{$prclose}}%</div>
                    <div class="stat">+{{$sport->goal_name_ge}} - {{$league_entry->goals_for}}</div>
                    <div class="stat">-{{$sport->goal_name_ge}} - {{$league_entry->goals_against}}</div>
                    <div class="stat">+@lang("league.Avg"){{$sport->goal_name_ge}} - {{$goalsforavg}}</div>
                    <div class="stat">-@lang("league.Avg"){{$sport->goal_name_ge}} - {{$goalsagainstavg}}</div>
                    <div class="stat">@lang("league.Min points") - {{$league_entry->min_score}}</div>
                    <div class="stat">@lang("league.Max points") - {{$league_entry->max_score}}</div>




                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12" >
            <div class="card">
                <div class="card-header"><span>{{$league->name}} - @lang("league.Stats")</span> </div>

                <div class="card-body">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
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
                            <th>@lang("league.Place")</th>
                            <th>@lang("league.Opponent")</th>
                            <th>@lang("league.Result")</th>
                            <th>@lang("league.Score")</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($old_league_entries as $old_league_entry)
                            <tr>
                                <?php 
                                
                                $goalsforavg = 0;
                                $goalsagainstavg = 0;

                                if($old_league_entry->played!=0){
                                    $goalsforavg = $old_league_entry->goals_for/$old_league_entry->played;
                                    $goalsagainstavg = $old_league_entry->goals_against/$old_league_entry->played;

                                } 

                                $first_user_goals = $old_league_entry->match->first_user_goals;

                                $second_user_goals = $old_league_entry->match->second_user_goals;
                                $opponent = $old_league_entry->match->second_user->name;

                                if($old_league_entry->match->first_user->id != $league_entry->user_id){
                                    $second_user_goals = $old_league_entry->match->first_user_goals;
                                    $first_user_goals = $old_league_entry->match->second_user_goals;
                                    $opponent = $old_league_entry->match->first_user->name;
                                }
                                $class = "draw";
                                if($old_league_entry->match->first_user_goals > $old_league_entry->match->second_user_goals){
                                    if($match->first_user_id == $user->id) {
                                        $class="win";
                                    }  else {
                                        $class="lose";
                                    }
                                } elseif($old_league_entry->match->first_user_goals < $old_league_entry->match->second_user_goals){
                                    if($match->first_user_id == $user->id) {
                                        $class="lose";
                                    }  else {
                                        $class="win";
                                    }
                                } 
                                ?>

                            <td>{{$old_league_entry->played}}</td>
                            <td>{{$old_league_entry->win}}</td>
                            @if($sport->has_draw)
                                <td>{{$old_league_entry->draw}}</td>
                            @endif
                            <td>{{$old_league_entry->loose}}</td>
                            <td>{{$old_league_entry->goals_for}}</td>
                            <td>{{$old_league_entry->goals_against}}</td>
                            <td>{{round($goalsforavg,2)}}</td>
                            <td>{{round($goalsagainstavg,2)}}</td>
                            <td>{{round($old_league_entry->min_score,2)}}</td>
                            <td>{{round($old_league_entry->max_score,2)}}</td>
                            <td>{{round($old_league_entry->score,2)}}</td>
                            <td>{{$old_league_entry->place}}</td>
                            <td>{{$opponent}}</td>
                            <td>{{$class}}</td>
                            <td>{{$first_user_goals}} - {{$second_user_goals}}</td>


                            </tr>

                            @endforeach
                           
                        </tbody>
                    </table>

                
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
