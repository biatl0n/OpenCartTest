<?php
class ControllerCommonTest extends Controller {

    public $siteURL;
    public $level;
    public $path;
    public $has_price=1;
    public $is_not_empty=1;
    public $urlCategory="https://www.sima-land.ru/api/v3/category/";
    public $urlGoods="https://www.sima-land.ru/api/v3/item/";

	public function index() {
		$this->load->language('common/test');
		$this->document->setTitle("Test");
		$data['heading_title'] = "Test";
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/test', 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => "Test",
			'href' => $this->url->link('common/test', 'token=' . $this->session->data['token'], true)
		);
		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		// Run currency update
		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');

			$this->model_localisation_currency->refresh();
		}
		
		$this->load->model('catalog/product');
		//_________________________________________________________

		$productData['product_description'][1]['name']='Product Name';
		$productData['product_description'][1]['meta_title']='Product meta_title';
		$productData['model']='Model';
		
        //$this->model_catalog_product->addProduct($productData);
        
        $parentCatsArray=$this->getParentCats();
        $parentCatsCount=count($parentCatsArray);
        $data['parentCatsArray']=$parentCatsArray;
        $data['parentCatscount']=count($parentCatsArray);
		//__________________________________________________________

		$this->response->setOutput($this->load->view('common/test', $data));
	}

    public function getCategories($level, $path) {
        $requestString = "$this->urlCategory?level=$level&path=$path&is_not_empty=$this->is_not_empty";
        $curl = curl_init($requestString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $json=json_decode($json);
        $json=$json->items;
        return $json;
    }

    public function getParentCats(){
        $requestString = "$this->urlCategory?level=1&is_not_empty=1";
        $curl = curl_init($requestString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $json=json_decode($json);
        $json=$json->items;
        return $json;
    }
    
    public function getItemCatInfo($catID){
        $requestString = "$this->urlCategory$catID/";
        $curl = curl_init($requestString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $json=json_decode($json);
        return $json;
    }

    public function getGoodsPageCount ($category_id){
        $requestString = "$this->urlGoods?category_id=$category_id&has_balance=1&has_photo=0&is_disabled=0&has_price=1";
        $curl = curl_init($requestString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $jsonGood=json_decode($json);
        $jsonGood2=$jsonGood->items;    
        $PageCount=$jsonGood->_meta->pageCount;
        return $PageCount;
    }

    public function getGoods ($category_id){
        $PageCount=$this->getGoodsPageCount($category_id);
        $jsonGood3=array();
        for ($i=1; $i<=$PageCount;$i++){
            $requestString = "$this->urlGoods?category_id=$category_id&has_balance=1&has_photo=1&is_disabled=0&has_price=1&expand=photos,photo_sizes&page=$i";
            $curl = curl_init($requestString);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            curl_close($curl);
            $jsonGood=json_decode($json);
            $jsonGood2=$jsonGood->items;
            $jsonGood3=array_merge($jsonGood3, $jsonGood2);
        }
        return $jsonGood3;
    }

}
