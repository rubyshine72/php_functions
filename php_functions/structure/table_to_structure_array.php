<?php

	public function getStructureProducts(){
		
		$return_array = array();
		
		$products = Product::where('enable', 1)
						->orderBy('card_level', 'asc')
						->get();
    
		foreach($products as $product){
			$temp[] = array("data" => $product, "sub_list" => []);
			$last_temp = end($temp);
			if($product->parent == 0){
				$temp_list[$product->id] = &$return_array;
			}else{
				$temp_list[$product->id] = &$temp_list[$product->parent][$product->parent]['list'];
			}
			$temp_list[$product->id][$product->id] = $last_temp;
		}
		
		return $return_array;
	}
