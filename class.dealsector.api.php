<?php
  	class DealsectorAPI{
  		
  		public static function getLocations(){
        	$url = DEALSECTOR_API_URL.'getLocations';
       		$data = self::api_data( $url, 'GET' );
  			return $data['response_data'];
		}

        public static function getSimilarInventory($inventory=[]){
        	$url = DEALSECTOR_API_URL.'getSimilarInventory';
			$data = self::api_data( $url, 'POST', $inventory );
  			return $data['response_data'];
		}
		public static function getNearStore($locationdata=[]){
        	$url = DEALSECTOR_API_URL.'getNearStore';
			$data = self::api_data( $url, 'POST', $locationdata );
  			return $data['response_data'];
		}
		
		public static function getinventorys($filters=[]){
        	$url = DEALSECTOR_API_URL.'getinventorys';
			$data = self::api_data( $url, 'POST', $filters );
  			return $data['response_data'];
		}

		public static function getFilters(){
        	$url = DEALSECTOR_API_URL.'getFilters';
			$data = self::api_data( $url, 'GET' );
  			return $data['response_data'];
		}

		public static function getCategories(){
        	$url = DEALSECTOR_API_URL.'getCategories';
			$data = self::api_data( $url, 'GET' );
  			return $data['response_data'];
		}

		public static function getfeaturedinventories( $condition, $featured ){
	    	$url = DEALSECTOR_API_URL.'getfeaturedinventories';
			$data = self::api_data( $url, 'POST', array( "condition" => $condition, "featured" => $featured ) );
			return $data['response_data'];
		}
		
		public static function getinventoryimages( $inventory_id ){
        	$url = DEALSECTOR_API_URL.'getinventoryimages';
			$data = self::api_data( $url, 'POST', array('inventory' => $inventory_id) );
  			return $data['response_data'];
		}

		public static function getinventory( $inventory_id ){
        	$url = DEALSECTOR_API_URL.'getinventory';
			$data = self::api_data( $url, 'POST', array('inventory' => $inventory_id) );
  			return $data['response_data'];
		}

	  	public static function checkAPI($apikey){
			
            $url = DEALSECTOR_API_URL.'checkapi';
    		$args = array(
				'headers' => array( 
	            	'Authorization' => $apikey
	            ),
	            'method' => 'GET'
			);
	        $remote_api_request = wp_remote_get( $url, $args );
	        $response_code = wp_remote_retrieve_response_code( $remote_api_request );
	        $body = wp_remote_retrieve_body( $remote_api_request );
	        $json_data = json_decode( $body );
	        $response_arr = array(
	        	   'response_code' => $response_code,
	        	   'response_data' => $json_data
				);
	        return $response_arr['response_data'];
	  	}

	  	private static function api_data($url,$method,$body=''){
			$args = array(
				'headers' => array( 
	            	'Authorization' => CLIENT_KEY
	            ),
	            'method' => $method,
	            'body' => $body
			);
	        $remote_api_request = wp_remote_get( $url, $args );
	        $response_code = wp_remote_retrieve_response_code( $remote_api_request );
	        $body = wp_remote_retrieve_body( $remote_api_request );
	        $json_data = json_decode( $body );
	        $response_arr = array(
	        	   'response_code' => $response_code,
	        	   'response_data' => $json_data
	            );
	        return $response_arr;
		}
  	}
?>