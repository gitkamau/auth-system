<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;


class ApiController extends Controller
{
    public function loggedInUser(){
        $user = auth()->user();
        return User::find($user->id);
    }

    /**
     * Returns a generic success (200) JSON response.
     *
     * @param  string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($message = 'Success.')
    {
        return response()->json([
            'status' => 200,
            'message' => $message,
        ], 200);
    }

    /**
     * Returns a resource updated success message (200) JSON response.
     *
     * @param  string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseResourceUpdated($message = 'Resource updated.')
    {
        return response()->json([
            'status' => 200,
            'message' => $message,
        ], 200);
    }

    /**
     * Returns a resource created (201) JSON response.
     *
     * @param  string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseResourceCreated($message = 'Resource created.')
    {
        return response()->json([
            'status' => 201,
            'message' => $message,
        ], 201);
    }

    /**
     * Returns a resource deleted (204) JSON response.
     *
     * @param  string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseResourceDeleted($message = 'Resource deleted.')
    {
        return response()->json([
            'status' => 204,
            'message' => $message,
        ], 204);
    }

    /**
     * Returns an unauthorized (401) JSON response.
     *
     * @param  array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseUnauthorized($errors = ['Unauthorized.'])
    {
        return response()->json([
            'status' => 401,
            'errors' => $errors,
        ], 401);
    }

    //return 403 error
    public function responseForbidden($errors = ['Forbidden.'])
    {
        return response()->json([
            'status' => 403,
            'errors' => $errors,
        ], 403);
    }

    /**
     * Returns a (400) Bad Request error JSON response.
     *
     * @param  array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseBadRequest($errors = ['Bad Request.'])
    {
        return response()->json([
            'status' => 400,
            'errors' => $errors,
        ], 400);
    }

    /**
     * Returns a (404) Not Found error JSON response.
     *
     * @param  array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseResourceNotFound($errors = ['Not Found'])
    {
        return response()->json([
            'status' => 404,
            'errors' => $errors,
        ], 404);
    }

    /**
     * Returns a unprocessable entity (422) JSON response.
     *
     * @param  array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseUnprocessable($errors)
    {
        return response()->json([
            'status' => 422,
            'errors' => $errors,
        ], 422);
    }

    /**
     * Returns a server error (500) JSON response.
     *
     * @param  array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseServerError($errors = ['Server error.'])
    {
        return response()->json([
            'status' => 500,
            'errors' => $errors
        ], 500);
    }
}
