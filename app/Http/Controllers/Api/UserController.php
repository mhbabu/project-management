<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserInfoResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getTeamLeaders(Request $request)
    {
        $perPage     = $request->get('per_page', 10); // Default to 10 items per page
        $teamLeaders = User::where('type', 'team-leader')->paginate($perPage);
        return UserInfoResource::collection($teamLeaders);
    }

    public function getDevelopers(Request $request)
    {
        $perPage    = $request->get('per_page', 10); // Default to 10 items per page
        $developers = User::where('type', 'developer')->paginate($perPage);
        return UserInfoResource::collection($developers);
    }
}
