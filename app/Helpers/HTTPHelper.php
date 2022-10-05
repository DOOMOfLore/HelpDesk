<?php

namespace App\Helpers;

class HTTPHelper {
	
	protected static $statusCodes = [
		'done' => 200,
		'created' => 201,
		'removed' => 204,
		'not_valid' => 400,
		'not_found' => 404,
		'conflict' => 409,
		'unauthorized' => 401,
		'forbidden' => 403,
		'error' => 500
	];

	public static function respond($status = true, $data = [], $message = 'success', $statusCode = 200){
		return response()->json([
			'status' => $status,
			'message' => $message,
			'data' => $data
		], $statusCode);
	}

	public static function success($data = [], $message = 'Success')
	{
		return self::respond(
			true, 
			$data,
			$message,
			200
		);
	}

	public static function created($data  = [], $message = 'created')
	{
		return self::respond(
			true, 
			$data,
			$message,
			201
		);
	}

	public static function forbidden($message  = 'Unauthorized', $data = [])
	{
		return self::respond(
			false, 
			$data,
			$message,
			403
		);
	}

	public static function notFound($message = 'Data is not found', $data = [])
	{
		return self::respond(
			false, 
			$data,
			$message,
			404
		);
	}

	public static function failed($message = '', $statusCode = 401, $data = [])
	{
		return self::respond(
			false, 
			$data,
			$message,
			$statusCode
		);
	}
}