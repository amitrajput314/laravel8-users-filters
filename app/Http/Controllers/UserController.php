<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Role, Industry, UserView};

class UserController extends Controller
{	
	/**
     * Get the users list.
     */
    public function index(Request $request){
		
		$sortBy = 'user_views.views';
		
		if(!empty($request->sortby)){
			if($request->sortby == '2'){
				$sortBy = 'users.registered_on';
			}else if($request->sortby == '3'){
				$sortBy = 'users.profile_score';
			}
		}
		$authUserId = \Auth::check() ? \Auth::user()->id : null;
		
		$users = User::select('users.*', 'user_views.views')
				->leftJoin('user_views', function($join) {
				  $join->on('users.id', '=', 'user_views.user_id');
				})->whereHas('roles', function($q) use($request){
					if(!empty($request->roles))
					$q->whereIn('role_id', $request->roles);
				})->whereHas('industries', function($q) use($request){
					if(!empty($request->industries))
					$q->whereIn('industry_id', $request->industries);
				})
				->where('users.id','!=', $authUserId)
				->orderBy($sortBy, 'ASC')
				->paginate(1);
		
		$roles = Role::all();
		$industries = Industry::all();
		$selectedRoles = !empty($request->roles) ? $request->roles : [];
		$selectedIndustries = !empty($request->industries) ? $request->industries : [];
		
		return view('users.list', [
			'users' => $users,
			'roles' => $roles,
			'industries' => $industries,
			'selectedRoles' => $selectedRoles,
			'selectedIndustries' => $selectedIndustries,
		]);
	}
	
	/**
     * User mark as viewed.
     */
	public function markView(Request $request, $user_id){
		$userView = UserView::where('user_id', $user_id)->first();
		
		if($userView){
			$userView->views += 1;
		}else{
			$userView =  new UserView();
			$userView->user_id = $user_id;
			$userView->views = 1;
		}
		$userView->save();
		return redirect()->back()->with('success', 'User mark as viewed successfully.');   
	}
}
