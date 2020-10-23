<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Sport;
use App\Models\League;
use App\Models\League_entry;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Models\Match;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $league_entries = $request->user()->league_entries;
        //dd(Invitation::where('user_to_id', $request->user()->id)->get());
        $sports = Sport::all();
        $matches = Match::where(['first_user_id' => $request->user()->id])->orWhere(['second_user_id' => $request->user()->id])->orderBy('id', 'desc')->get();
        $errors = [];
        if($request->input('new_user')=='false'){
            $errors = ['ლიგის ვერიფიკაციის კოდი არასწორია'];
        }
        // $invitations = Invitation::where(['user_to_id' => $request->user()->id, 'status' => 0])->get();
        return view('home', ['matches' => $matches,'league_entries' => $league_entries, 'sports' => $sports, 'errors' => $errors]);
    }


    public function league(Request $request){

        $league = League::find($request->id);
        $league_entries = $league->league_entries;
        $matches = $league->matches;
        $sport = $league->sport;

        return view('league',['league' => $league,'league_entries' => $league_entries, 'matches' => $matches, 'sport' => $sport]);
    }


    public function user_stats(Request $request){

        $league = League::find($request->league_id);
        // $matches = Match::where(['league_id' => $request->league_id, 'first_user_id' => $request->user_id])->orWhere(['league_id' => $request->league_id, 'second_user_id' => $request->user_id])->orderBy('id', 'desc')->get();
        //$matches = Match::where('league_id',$request->league_id)->where('first_user_id', $request->user_id)->orWhere('second_user_id', $request->user_id)->orderBy('id', 'desc')->get();
        $matches = Match::select(DB::raw(' * '))->whereRaw('league_id = '.$request->league_id.' and (first_user_id = '.$request->user_id.' or second_user_id = '.$request->user_id.') ')->get();






        $matches_sorted = [];
        foreach ($matches as $match){
            if($request->user_id==$match->first_user->id){
                if(!isset($matches_sorted[$match->second_user_id])){
                    $matches_sorted[$match->second_user_id] = ['matches' => [], 'user' => $match->second_user, 'goals_for' => 0, 'goals_against' => 0, 'wins' => 0, 'lost' => 0,'draw' => 0];
                }
                array_push($matches_sorted[$match->second_user_id]['matches'], $match);

                $matches_sorted[$match->second_user_id]['goals_for'] += $match->first_user_goals; 
                $matches_sorted[$match->second_user_id]['goals_against'] += $match->second_user_goals; 


                if($match->first_user_goals>$match->second_user_goals){
                    $matches_sorted[$match->second_user_id]['wins'] += 1;
                } elseif ($match->first_user_goals<$match->second_user_goals){
                    $matches_sorted[$match->second_user_id]['lost'] += 1;
                } else {
                    $matches_sorted[$match->second_user_id]['draw'] += 1;
                }

            } else {
                if(!isset($matches_sorted[$match->first_user_id])){
                    $matches_sorted[$match->first_user_id] = ['matches' => [], 'user' => $match->first_user, 'goals_for' => 0, 'goals_against' => 0, 'wins' => 0, 'lost' => 0,'draw' => 0];
                }
                array_push($matches_sorted[$match->first_user_id]['matches'], $match);

                $matches_sorted[$match->first_user_id]['goals_for'] += $match->second_user_goals; 
                $matches_sorted[$match->first_user_id]['goals_against'] += $match->first_user_goals; 


                if($match->second_user_goals>$match->first_user_goals){
                    $matches_sorted[$match->first_user_id]['wins'] += 1;
                } elseif ($match->second_user_goals<$match->first_user_goals){
                    $matches_sorted[$match->first_user_id]['lost'] += 1;
                } else {
                    $matches_sorted[$match->first_user_id]['draw'] += 1;
                }
            }
        }
        $league_entry = League_entry::where(['league_id' => $request->league_id, 'user_id' => $request->user_id])->first();
        
        $matches = $league->matches;
        $user = User::find($request->user_id);
        $sport = $league->sport;


        return view('stats',['league' => $league,'league_entry' => $league_entry, 'sorted_opponents' => $matches_sorted, 'user' => $user, 'sport'=>$sport]);
    }


    public function enter_league(Request $request){
        $league = League::where(['unique_id' => $request->league_code])->first();

        if(is_null($league)){
           // $invitations = Invitation::where(['user_to_id' => $request->user()->id, 'status' => 0])->get();
            return redirect('home?new_user=false');

        } else {
            $sport = $league->sport;
            $entry = League_entry::where(['user_id'=>$request->user()->id, 'league_id' => $league->id])->first();
            if(is_null($entry)){
                $league_entry = League_entry::create([
                    'user_id' => $request->user()->id,
                    'league_id' => $league->id,
                    'played' => 0,
                    'win' => 0,
                    'loose' => 0,
                    'draw' => 0,
                    'goals_for' => 0,
                    'goals_against' => 0,
                    'max_score' => $sport->starting_point,
                    'min_score' => $sport->starting_point,
                    'score' => $sport->starting_point,
                ]);

                $league_entry->save();
                

            }
            
            return redirect('league/'.$league->id.'?new_user=true');

        }
    }


    public function create_league(Request $request){
        $random = rand();
        $sport = Sport::find($request->sport);
        $league = League::create([
            'name' =>  $request->league_name,
            'sport_id' => $request->sport,
            'unique_id' => $random,
            'status' => 0
        ]);
        $league->save();
        $league_entry = League_entry::create([
            'user_id' => $request->user()->id,
            'league_id' => $league->id,
            'played' => 0,
            'win' => 0,
            'loose' => 0,
            'draw' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'max_score' => $sport->starting_point,
            'min_score' => $sport->starting_point,
            'score' => $sport->starting_point,
        ]);

        $league_entry->save();


        return redirect('league/'.$league->id.'?new=true');


        
    }


    public function calculateScores($sport,$first_player_entry, $first_player_goals, $second_player_entry, $second_player_goals){
        $change = 0;
        $winner = 0;
        if($first_player_goals>$second_player_goals){//if first one won
            $winner =1;
            $difference = $first_player_entry->score - $second_player_entry->score;
            if($difference>=$sport->max_point_difference){
                $change = 0.01;
            } elseif($difference<=$sport->max_point_difference*(-1)){
                $change = $sport->max_change;
            } else {
                $change = $sport->min_change + ($difference*(-1)/$sport->max_point_difference)*($sport->max_change-$sport->min_change);
            }
            
            if($first_player_goals-$second_player_goals>$sport->premial_score){
                $change = $change*$sport->premial_scale;
            }

        } elseif($first_player_goals<$second_player_goals){//if second won
            $winner = 2;

            $difference = $first_player_entry->score - $second_player_entry->score;

            if($difference>=$sport->max_point_difference){
                $change = (-1)*$sport->max_change;
            } elseif($difference<=(-1)*$sport->max_point_difference){
                $change = -0.01;
            } else {

                $change = ($sport->min_change + $difference/$sport->max_point_difference*($sport->max_change-$sport->min_change))*(-1);

            }
            
            if($second_player_goals-$first_player_goals>$sport->premial_score){
                $change = $change*$sport->premial_scale;
            }



        } else {//if draw
            $difference = $first_player_entry->score - $second_player_entry->score;
            if($difference>$sport->max_point_difference) $difference=$sport->max_point_difference;
            if($difference<(-1)*$sport->max_point_difference) $difference=-(-1)*$sport->max_point_difference;
            $change = ($sport->draw_scale*($difference/$sport->max_point_difference)*(-1)*($sport->max_change-$sport->min_change));
        }

        
        return ['change' => $change, 'winner' => $winner];
    }


    public function add_match_entry($first_player_entry_id, $first_player_score, $second_player_entry_id, $second_player_score, $league_id){
        $sport = League::find($league_id)->sport;
        if($first_player_score==$second_player_score && $sport->has_draw==0){
            return redirect('league/'.$league_id);
        }
        $first_player_entry = League_entry::find($first_player_entry_id);
        $first_player_goals = $first_player_score;
        $second_player_entry = League_entry::find($second_player_entry_id);
        $second_player_goals = $second_player_score;

        $calculatedScores = $this->calculateScores($sport,$first_player_entry, $first_player_goals, $second_player_entry, $second_player_goals);

       

        $first_player_entry->played+=1;
        $second_player_entry->played+=1;
        $first_player_entry->goals_for+=$first_player_goals;
        $second_player_entry->goals_for+=$second_player_goals;
        $first_player_entry->goals_against+=$second_player_goals;
        $second_player_entry->goals_against+=$first_player_goals;
        if($calculatedScores['winner'] == 1){
            $first_player_entry->win+=1;
            $second_player_entry->loose+=1;
        } elseif($calculatedScores['winner'] == 2){
            $first_player_entry->loose+=1;
            $second_player_entry->win+=1;
        } else {
            $first_player_entry->draw+=1;
            $second_player_entry->draw+=1;
        }

        $match = Match::create([
            'league_id' => $league_id,
            'first_user_id' =>$first_player_entry->user->id,
            'second_user_id'=> $second_player_entry->user->id,
            'first_user_goals' =>$first_player_goals,
            'second_user_goals' =>$second_player_goals,
            'second_user_score' =>$second_player_entry->score-$calculatedScores['change'],
            'first_user_score'=>$first_player_entry->score+$calculatedScores['change'],
            'first_user_old_score' => $first_player_entry->score,
            'second_user_old_score' =>$second_player_entry->score,
        ]);


        $match->save();


        
        $first_player_entry->score+=$calculatedScores['change'];
        $second_player_entry->score+=((-1)*$calculatedScores['change']);

        if($first_player_entry->score > $first_player_entry->max_score){
            $first_player_entry->max_score = $first_player_entry->score;
        } elseif($first_player_entry->score < $first_player_entry->min_score){
            $first_player_entry->min_score = $first_player_entry->score;
        }

        if($second_player_entry->score > $second_player_entry->max_score){
            $second_player_entry->max_score = $second_player_entry->score;
        } elseif($second_player_entry->score < $second_player_entry->min_score){
            $second_player_entry->min_score = $second_player_entry->score;
        }

        $first_player_entry->save();
        $second_player_entry->save();
    }

    public function add_match(Request $request){
        $this->add_match_entry($request->first_player, $request->first_player_score, $request->second_player, $request->second_player_score, $request->league_id);
        
        return redirect('league/'.$request->league_id);


    }


    public function delete_match(Request $request){

        $league = League::find($request->league_id);
        if($league->status != 0) return redirect('league/'.$request->league_id);
        $league->status = 1;
        $league->save();

        $matches = Match::where("league_id", $request->league_id)->orderBy('id', 'desc')->limit(10)->get();
        $matchesToReverse = [];
        foreach($matches as $match){

            $first_player_entry = League_entry::where(['user_id' => $match->first_user->id, 'league_id' => $request->league_id])->first();
            $second_player_entry = League_entry::where(['user_id' => $match->second_user->id, 'league_id' => $request->league_id])->first();
            


            

            if($first_player_entry->max_score == $match->first_user_score) $first_player_entry->max_score = $match->first_user_old_score;
            if($first_player_entry->min_score == $match->first_user_score) $first_player_entry->min_score = $match->first_user_old_score;
            if($second_player_entry->max_score == $match->second_user_score) $second_player_entry->max_score = $match->second_user_old_score;
            if($second_player_entry->min_score == $match->second_user_score) $second_player_entry->min_score = $match->second_user_old_score;
            
            $first_player_entry->score = $match->first_user_old_score;
            $second_player_entry->score = $match->second_user_old_score;


            $first_player_entry->played -=1;
            $second_player_entry->played -=1;
            $first_player_entry->goals_for -=$match->first_user_goals;
            $second_player_entry->goals_for -=$match->second_user_goals;
            $first_player_entry->goals_against -=$match->second_user_goals;
            $second_player_entry->goals_against -=$match->first_user_goals;
            if($match->first_user_goals > $match->second_user_goals ){
                $first_player_entry->win -=1;
                $second_player_entry->loose -=1;
            }elseif($match->first_user_goals < $match->second_user_goals ){
                $first_player_entry->loose -=1;
                $second_player_entry->win -=1;
            } else {
                $first_player_entry->draw -=1;
                $second_player_entry->draw -=1;
            }


            $first_player_entry->save();
            $second_player_entry->save();



            array_push($matchesToReverse, $match);
            $match->delete();
            if($match->id == $request->match_id)break;

        }





        for($i = sizeof($matchesToReverse)-2; $i>=0; $i--){
            $first_player_entry = League_entry::where(['user_id' => $matchesToReverse[$i]->first_user->id, 'league_id' => $request->league_id])->first();
            $second_player_entry = League_entry::where(['user_id' => $matchesToReverse[$i]->second_user->id, 'league_id' => $request->league_id])->first();

            $this->add_match_entry($first_player_entry->id, $matchesToReverse[$i]->first_user_goals, $second_player_entry->id, $matchesToReverse[$i]->second_user_goals, $request->league_id);

        }

        $league->status = 0;
        $league->save();

        return redirect('league/'.$request->league_id);




        dd($matchesToReverse);

    }
    
}
