<?php

class Det {

	public $name;
	public $products;
	public $contents;
	public $links;

	static $PRODUCTS_FILE = 'products.json';

	public function __construct($jsonFile = null) {
		$file = !empty($jsonFile) ? $jsonFile : self::$PRODUCTS_FILE;

		$this->decode($file);
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setProducts($products) {
		$this->products = $products;
	}

	public function getProducts() {
		return $this->products;
	}

	public function containProducts(){
		return !empty($this->products);
	}

	public function setContents($contents) {
		$this->contents = $contents;
	}

	public function containContents(){
		return !empty($this->contents);
	}

	public function getContents() {
		return $this->contents;
	}

	public function setLinks($links) {
		$this->links = $links;
	}

	public function getLinks() {
		return $this->links;
	}

	public function containLinks(){
		return !empty($this->links);
	}

	private function decode($file){
		$fileContent = file_get_contents(dirname(__FILE__).'/'.$file);
		$data = json_decode($fileContent);

		$this->parserDet($data);
	}

	private function parserDet($data) {
		$this->setName($data->name);
		$this->parseProducts($data->products);
		$this->parseContents($data->contents);
		$this->parseLinks($data->links);
	}

	private function parseProducts($products){
		$data = array();
		foreach($products as $product){
			$data[] = new DetProduct($product);
		}

		$this->setProducts($data);
	}

	private function parseContents($contents = null){
		$data = array();
		if(!empty($contents)){
			foreach($contents as $content){
				$data[] = new DetContentLink($content);
			}
		}
		$this->setContents($data);
	}

	private function parseLinks($contents = null){
		$data = array();
		if(!empty($contents)){
			foreach($contents as $content){
				$data[] = new DetLink($content);
			}
		}
		$this->setLinks($data);
	}
}

class DetProduct {

	public $name;
	public $instances;

	public function __construct($product){
		$this->name = $product->name;
		$this->parseInstances($product->instances);
	}

	public function getName() {
		return $this->name;
	}

	private function setInstances($instances) {
		$this->instances = $instances;
	}

	private function parseInstances($instances){
		$data = array();
		foreach($instances as $instance){
			$data[] = new DetInstances($instance);
		}
		$this->setInstances($data);
	}
}

class DetInstances {

	public $name;
	public $version;
	public $links = array();
	public $pages = array();

	public function __construct($instance){
		$this->name = $instance->name;
		$this->version = $instance->version;
		$this->parseLinks($instance->links);
		$this->parsePages($instance->pages);
	}

	private function parseLinks($links = null){
		$this->links = new DetInstanceLink($links);
	}

	private function parsePages($pages = null){
		$data = array();
		if(!empty($pages)){
			foreach($pages as $page){
				$data[] = '<a href="'.$page->url.'">'.$page->name.'</a>';
			}
		}
		$this->pages = $data;
	}
}

class DetInstanceLink {

	public $app;
	public $fw;
	public $svn;
	public $bds;
	public $content;

	public function __construct($links = null){
		if(empty($links)){
			return;
		}

		$this->app = $this->createUrl($links->app, 'app');
		$this->fw = $this->createUrl($links->fw, 'fw');
		$this->svn = $this->createUrl($links->svn, 'svn');
		$this->bds = $this->createUrl($links->bds, 'bds', false);;
		$this->content = $this->createUrl($links->content, 'content');
	}

	private function createUrl($link = null, $label = 'link', $simple = true){
		switch(true){
			case empty($link):
				return '-';
			break;
			case !$simple:
				return '<a href="'.$link->url.'">'.$link->name.'</a>';
				break;
			default:
				return '<a href="'.$link.'">'.$label.'</a>';
		}
	}
}

class DetContentLink {

	public $name;
	public $data;
	public $svn;

	public function __construct($content){
		$this->name = $content->name;
		$this->data = $this->createUrl($content->data, 'data');
		$this->svn = $this->createUrl($content->svn, 'svn');
	}

	public function getName() {
		return $this->name;
	}

	private function createUrl($link = null, $label = 'link', $simple = true){
		switch(true){
			case empty($link):
				return '-';
				break;
			case !$simple:
				return '<a href="'.$link->url.'">'.$link->name.'</a>';
				break;
			default:
				return '<a href="'.$link.'">'.$label.'</a>';
		}
	}
}

class DetLink {

	public $url;

	public function __construct($link){
		$this->url = $this->createUrl($link->url, $link->name);
	}

	private function createUrl($link = null, $label = 'link', $simple = true){
		switch(true){
			case empty($link):
				return '-';
				break;
			case !$simple:
				return '<a href="'.$link->url.'">'.$link->name.'</a>';
				break;
			default:
				return '<a href="'.$link.'">'.$label.'</a>';
		}
	}
}