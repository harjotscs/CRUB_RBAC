<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            error_log('error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "An error occurred"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function getDetails(Request $request)
    {
        try {
            $user = $request->user;
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            error_log('error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "An error occurred"
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
                'password' => 'sometimes|required|min:6',
                'description' => 'sometimes|required',
            ]);

            $user = User::findOrFail($id);
            if (!$user) {
                error_log('user not found');
                return response()->json([
                    'success' => false,
                    'message' => '
                    User not found'
                ]);
            }
            $user->update($request->all());
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            error_log('error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            error_log('error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "An error occurred, probably the user doesn't exist"
            ]);
        }
    }
}
