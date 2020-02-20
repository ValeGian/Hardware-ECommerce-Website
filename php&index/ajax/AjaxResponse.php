<?php  
	class AjaxResponse{
		public $responseCode; // 0 all ok - 1 some errors - -1 some warning
		public $message;
		public $data;
		
		function AjaxResponse($responseCode = 1, 
								$message = "Somenthing went wrong! Please try later.",
								$data = null){
			$this->responseCode = $responseCode;
			$this->message = $message;
			$this->data = null;
		}
	
	}

    class CartSingleProductMod{
        public $productId;
        public $productModel;
        public $productQuantity;
        public $productMaxQuantity;
        public $productCosto;
        public $operazione;
        public $spesa;
        public $page;
        
        function CartSingleProductMod($id = null, $model = null, $quantita = null, $maxQuantity = null, $costo = null, $operazione = null, $spesa = null, $page = null){
            $this->productId = $id;
            $this->productModel = $model;
            $this->productQuantity = $quantita;
            $this->productMaxQuantity = $maxQuantity;
            $this->productCosto = $costo;
            $this->operazione = $operazione;
            $this->spesa = $spesa;
            $this->page = $page;
        }
    }

    class SearchedProducts{
        public $products;
        public $productsCount;
        public $newProductsDisplayed;
        public $lastProduct;
        
        function SearchedProducts($products = null, $productsCount = 0, $newProductsDisplayed = 0, $lastProduct = null){
            $this->products = $products;
            $this->productsCount = $productsCount;
            $this->newProductsDisplayed = $newProductsDisplayed;
            $this->lastProduct = $lastProduct;
        }
    }
?>