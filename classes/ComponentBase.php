<?php
class ComponentBase
{
	protected $modx, $table, $dir = null;
	
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
	
	public function __construct(&$modx, $type = 'snippets', $foldername = '_db')
	{
		$this->modx = $modx;
		$this->type = $type;
		
		$this->table = $this->modx->getFullTableName($this->component[$type]['tablename']);
		
		$this->dir = MODX_BASE_PATH ."assets/$type/$foldername/";
		
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
}