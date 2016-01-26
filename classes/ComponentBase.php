<?php
class ComponentBase
{
	protected $modx, $table, $dir = null, $eol;
	
	protected $component = array(
		'snippets' => array(
			'tablename' => 'site_snippets',
			'col_name' => 'name',
			'col_content' => 'snippet',
		),
		'chunks' => array(
			'tablename' => 'site_htmlsnippets',
			'col_name' => 'name',
			'col_content' => 'snippet',
		),
		'plugins' => array(
			'tablename' => 'site_plugins',
			'col_name' => 'name',
			'col_content' => 'plugincode',
		),
		'templates' => array(
			'tablename' => 'site_templates',
			'col_name' => 'templatename',
			'col_content' => 'content',
		),
	);
	
	public function __construct(&$modx, $type = 'snippets', $foldername = '_db', $eol='')
	{
		$this->modx = $modx;
		$this->type = $type;
		
		$this->table = $this->modx->getFullTableName($this->component[$type]['tablename']);
		
		$this->dir = MODX_BASE_PATH ."assets/$type/$foldername/";
		
		$this->eol = (empty($eol) or !in_array($eol,explode(",","lf,crlf,cr")))?"":$eol;
		
		if (!file_exists($this->dir) && !is_dir($this->dir)) {
        	$ret = mkdir($this->dir, 0777, true);
			if ($ret == false && !is_dir($this->dir)) {
		  		throw new Exception("Cannot create {$this->dir}. Please create directory manually, and set permissions to 0777");
			}  
		} 
	}
	
	protected function statsBlock($label, $array)
	{
		$o = "$label:\n";
		foreach ($array as $i) {
			$o .= "\t$i\n";
		}
		$o .= "\n";
		return $o;
	}
	protected function normalizeEol($string) {
		if ($this->eol) {
			switch ($this->eol) {
				case "lf": 
					$string = preg_replace("/\r\n/s", "\n", $string);
					$string = preg_replace("/\r/s", "\n", $string);
					break;
				case "cr": 
					$string = preg_replace("/\r\n/s", "\r", $string);
					$string = preg_replace("/\r/s", "\r", $string);
					break;
				case "crlf": 
					$string = preg_replace("/(?<=[^\r]|^)\n/s", "\r\n", $string);
					break;
			}
		}
		return $string;
	}
}