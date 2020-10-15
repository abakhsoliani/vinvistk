@extends('layouts.app')

@section('content')
<div class="container">




    <div class="row justify-content-center">
        <div class="col-md-9" >
            <div class="card">
                <div class="card-header">{{$user->name}} - ვინ ვის ტკ</div>

                <div class="card-body">
                    
                @foreach($sorted_opponents as $opponent)
                    <div class="opponent" style="margin-bottom : 15px;">
                        <h3>
                            {{$opponent['user']->name}}    
                        </h3>
                        <p>მოგება:{{$opponent['wins']}} - ფრე:{{$opponent['draw']}} - წაგება:{{$opponent['lost']}}</p>
                        <p>  გატანილი გოლი:{{$opponent['goals_for']}} - გაშვებული გოლი:{{$opponent['goals_against']}}</p>
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

                                    <span class="hint">score change : {{$change}}</span>
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
                <div class="card-header">{{$league->name}} - {{$user->name}} სტატისტიკა</div>

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
                    $prclose = $league_entry->lose*100/$league_entry->played;
                    $prcdraw = $league_entry->draw*100/$league_entry->played;
                } 
                
                
                ?>



                <div class="card-body">
                    <div class="stat">თამაში - {{$league_entry->played}}</div>
                    <div class="stat">მოგება - {{$league_entry->win}}</div>
                    <div class="stat">ფრე - {{$league_entry->draw}}</div>
                    <div class="stat">წაგება - {{$league_entry->loose}}</div>
                    <div class="stat">მოგება % - {{$prcwin}}%</div>
                    <div class="stat">ფრე % - {{$prclose}}%</div>
                    <div class="stat">წაგება % - {{$prcdraw}}%</div>
                    <div class="stat">გატანილი გოლი - {{$league_entry->goals_for}}</div>
                    <div class="stat">გაშვებული გოლი - {{$league_entry->goals_against}}</div>
                    <div class="stat">საშ.გატანილი გოლი - {{$goalsforavg}}</div>
                    <div class="stat">საშ.გაშვებული გოლი - {{$goalsagainstavg}}</div>
                    <div class="stat">მინიმალური ქულა - {{$league_entry->min_score}}</div>
                    <div class="stat">მაქსიმალური ქულა - {{$league_entry->max_score}}</div>




                </div>
            </div>
        </div>
    </div>
</div>

@endsection
