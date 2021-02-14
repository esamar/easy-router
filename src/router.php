<?php

class Router {
	
	protected static $parts_uri;

	protected static $request_method;

	protected static $request_body;

	protected static $request_query;

	protected static $dir_controller;
	
	// protected static $group_router;

	public function __construct()
	{

		$uri = urldecode( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
		
		$uri = str_replace( str_replace( '/' . basename( $_SERVER['SCRIPT_NAME'] ) ,'', $_SERVER['SCRIPT_NAME'] ) , '' , $uri );
		
		( !$uri ? $uri = '/' : null );

		static::$parts_uri = explode( '/' , $uri );
		
		( !static::$parts_uri[0] ? static::$parts_uri[0] = '/' : null );
		
		static::$request_body = json_decode( file_get_contents( 'php://input' ) );
		
		( !is_array( static::$request_body ) ? [] : null );

		if ( isset( $_SERVER['QUERY_STRING'] ) )
		{

			parse_str( urldecode( $_SERVER['QUERY_STRING'] ) , $query );
	
		}
		else
		{

			$query = [];
		
		}

		static::$request_query = (object) $query;

		static::$request_method = $_SERVER['REQUEST_METHOD'];

	}

	public static function get( $uri , $controller , $callback = null )
	{

		if ( static::$request_method != 'GET' )
		{

			return false;

		}
		else
		{

			return static::kernel( $uri , $controller , $callback );

		}
			
	}

	public static function post( $uri , $controller , $callback = null )
	{

		if ( static::$request_method != 'POST' )
		{

			return false;

		}
		else
		{

			return static::kernel( $uri , $controller , $callback );

		}
			
	}

	public static function put( $uri , $controller , $callback = null )
	{

		if ( static::$request_method != 'PUT' )
		{

			return false;

		}
		else
		{

			return static::kernel( $uri , $controller , $callback );

		}
			
	}

	public static function delete( $uri , $controller , $callback = null )
	{

		if ( static::$request_method != 'DELETE' )
		{

			return false;

		}
		else
		{

			return static::kernel( $uri , $controller , $callback );

		}
			
	}

	public static function group( $group )
	{
	
		#TRABAJAR EN ESTO#########
		#static::$group = $group;
		##########################
	
	}

	private static function kernel( $uri , $controller , $callback = null )
	{

		$parts_uri = static::$parts_uri;

		$parts_router = explode('/' , $uri ) ;

		( !$parts_router[0] ? $parts_router[0] = '/' : null );
		
		if ( !preg_match('/{[a-zA-Z_]+[a-zA-Z_0-9]+}/', $parts_router[1] ) )
		{

			unset($parts_router[0]);
			
			$parts_router = array_merge($parts_router);
			
			unset($parts_uri[0]);

			$parts_uri = array_merge($parts_uri);

		}

		if ( $parts_router[0] == $parts_uri[0] )
		{
			
			$param_array = [];

			unset($parts_router[0]);

			unset($parts_uri[0]);

			foreach ($parts_router as $key => $part) 
			{
				
				$format_param = preg_match('/{[a-zA-Z_]+[a-zA-Z_0-9]+}/', $part ) ;

				if ( isset( $parts_uri[$key] ) && $format_param )
				{
					
					preg_match('/\{(.*?)\}/i', $part , $param) ;

					$param_array[ $param[1] ] = $parts_uri[$key];

				}
				else
				{

					return false;

				}

			}

			if ( gettype( $controller ) !== 'object' )
			{
			
				$constroller_part = explode('@', $controller) ;

				$file_controller = $constroller_part[0];

				$method_controller = $constroller_part[1];

				$resp = static::controller( 
										$file_controller , 
										$method_controller , 
										$param_array , 
										(object) [ 
											'params'	=>   (object)$param_array, 
											'body'		=>   static::$request_body, 
											'query' 	=>   static::$request_query 
										]);

				return $callback( (object) [ 
												'params'	=>   (object)$param_array, 
												'body'		=>   static::$request_body, 
												'query' 	=>   static::$request_query 
											] , $resp );

			}

			if ( gettype( $controller ) === 'object' )
			{


				return $controller( (object) [ 
												'params'	=>   (object)$param_array, 
												'body'		=>   static::$request_body, 
												'query' 	=>   static::$request_query 
											  ] );

			}
			else
			{

				return $callback( (object) [ 
												'params'	=>   (object)$param_array, 
												'body'		=>   static::$request_body, 
												'query' 	=>   static::$request_query 
											] );

			}

		}
		else
		{
			
			// echo "undefined route /";

			return false;

		}

	}

	public static function dirController( $set_dir_controller )
	{
		
		if ( $set_dir_controller )
		{

			static::$dir_controller = $set_dir_controller;

		}

	}

	private static function controller( $class , $method , $params , $data )
	{

		$file_class =  $class . '.php';
		
		require ( ( static::$dir_controller ? static::$dir_controller . '/' : '/services/' ) . $file_class );

		$controller_class = new $class; 

		$method = explode(':' , $method);

		return call_user_func_array( [ $controller_class , $method[0] ] , ( isset( $method[1] ) ? [ $method[1] => $data ] : $params ) ) ;

	}

}

class Returns {

	public static function JSON( $response_code , $data )
	{

		header('Content-type: application/json; charset=utf-8');

		http_response_code($response_code);

		echo json_encode( $data );

	}

	public static function TEXT( $response_code , $data )
	{

		header("Content-Type: text/plain");
		
		http_response_code($response_code);

		echo $data;

	}

	public static function VIEW( $response_code , $require , $vars = [] )
	{

		foreach ($vars as $key => $value) {
			
			$$key = $value;

		}

		http_response_code($response_code);

		require $require;

	}

}

new Returns;

new Router;