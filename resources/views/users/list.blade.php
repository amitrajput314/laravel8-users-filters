<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
  </head>
  <body>
	<div class="container">
	   <div class="row">
		  <div class="col-md-12">
			 <h4>Users</h4>
			 @if (\Session::has('success'))
			 <div class="alert alert-success" role="alert">
			  {!! \Session::get('success') !!}
		     </div>
			 @endif
			 <div class="table-responsive">
				<form>
				<label>Roles</label>
				<select name="roles[]" class="form-select" multiple aria-label="multiple select example">
					@foreach($roles as $role)
					@if(in_array($role->id, $selectedRoles))
					<option selected="selected" value="{{$role->id}}">{{$role->name}}</option>
					@else
					<option value="{{$role->id}}">{{$role->name}}</option>
					@endif
					@endforeach
				</select>
				
				<label>Industries</label>
				<select name="industries[]" class="form-select" multiple aria-label="multiple select example">
					@foreach($industries as $industry)
					@if(in_array($industry->id, $selectedIndustries))
					<option selected="selected" value="{{$industry->id}}">{{$industry->name}}</option>
					@else
					<option value="{{$industry->id}}">{{$industry->name}}</option>
					@endif
					@endforeach
				</select>
				
				<label>Sort by</label>
				<select name="sortby" class="form-select" aria-label="Default select example">
				  <option @if(request()->get('sortby') == '1') selected="selected" @endif value="1">View all</option>
				  <option @if(request()->get('sortby') == '2') selected="selected" @endif value="2">New registered members</option>
				  <option @if(request()->get('sortby') == '3') selected="selected" @endif value="3">Profile score</option>
				</select>
				<input type="submit" value="search">
				<a href="{{route('users.list')}}">clear</a>
				</form>
				<table id="mytable" class="table table-bordred table-striped">
				   <thead>
					  <!--<th><input type="checkbox" id="checkall" /></th>-->
					  <th>User ID</th>
					  <th>Email</th>
					  <th>Mobile</th>
					  <th>Profile Score</th>
					  <th>Roles</th>
					  <th>Industries</th>
					  <th>Registered on</th>
					  <th>Views</th>
					  <th></th>
					  <!--<th>Delete</th>-->
				   </thead>
				   <tbody>
					@foreach($users as $user)
					  <tr>
						 <!--<td><input type="checkbox" class="checkthis" /></td>-->
						 <td>{{ $user->id }}</td>
						 <td>{{ $user->email }}</td>
						 <td>{{ $user->mobile }}</td>
						 <td>{{ $user->profile_score }}</td>
						 <td>{{ $user->roles ? implode(', ', $user->roles()->pluck('name')->toArray()) : '' }}</td>
						 <td>{{ $user->industries ? implode(', ', $user->industries()->pluck('name')->toArray()) : '' }}</td>
						 <td>{{ $user->registered_on }}</td>
						 <td>{{ $user->views ? $user->views : 0 }}</td>
						 <td>
							<a href="{{route('user.mark', $user->id)}}"><button class="btn btn-primary btn-xs" data-title="Mark as viewed" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-eye-open"></span></button></a>
						 </td>
						 <!--<td>
							<p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p>
						 </td>-->
					  </tr>
					@endforeach
					  
				   </tbody>
				</table>
				<div class="clearfix"></div>
				{{ $users->appends(request()->except('page'))->links() }}
			 </div>
		  </div>
	   </div>
	</div>
	
  </body>
</html>