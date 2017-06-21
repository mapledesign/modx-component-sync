<?php
require_once 'ComponentBase.php';

class ComponentDump extends ComponentBase
{
	public function run()
	{
	
	    $fileslist = glob($this->dir .'*.php'); 	
		if(is_array($fileslist)) {
			$this->orig_items = array_map('basename', $fileslist);
		}
		$res = $this->modx->db->query("SELECT * FROM $this->table");
		
		while( $row = $this->modx->db->getRow( $res ) ) {
			$filename = $row[$this->component[$this->type]['col_name']] .'.php';
			file_put_contents($this->dir . $filename, $this->normalizeEol($row[$this->component[$this->type]['col_content']]));
			$fs_items[] = $filename;
		}
		
		$this->fs_items = $fs_items;
		
		// Handle items which may now be in the DB/filesystem but are no longer present in the filesystem/db
		// (i.e. remove deleted resources)
		
		
		// Clear cache if sync'ing back to DB - as chunks etc are cached there
	}
	
	public function getStats()
	{
		$o = '';
		$o = "###################################################################\n";
		$o .= "# Processing {$this->type}\n";
		$o .= "###################################################################\n\n";
		$o .= "Dumped the following to the file system:\n";
		foreach ($this->fs_items as $i) {
			$o .= "\t$i\n";
		}
		$o .= "\n";
		if (is_array($this->orig_items)){
			$items_in_filesystem_not_db = array_diff($this->orig_items, $this->fs_items);
		}
		if (count($items_in_filesystem_not_db) > 0) {
			$o .= $this->statsBlock("The following are in the filesystem but NOT the database", $items_in_filesystem_not_db);
		}
		
		return $o;
	}
}