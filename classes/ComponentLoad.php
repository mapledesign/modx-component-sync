<?php
require_once 'ComponentBase.php';
/*
Really I want run() to take the component (snippets, chunks etc) as an argument so
this class is only initialised once (which as I'm going to have options like 'dry-run' to pass in
makes a lot more sense). 

However how does the getStats() method work then? Maybe best to keep it this way...
 */
class ComponentLoad extends ComponentBase
{
	public function run()
	{
		$files = glob($this->dir .'*.php');
		
		foreach ($files as $file) {
			$filename = basename($file, '.php');
			$content = file_get_contents($file);
			
			// Can't use REPLACE as the name column isn't indexed
			#$res = $modx->db->query("REPLACE INTO $table SET {$component[$type]['col_content']} = '". mysql_real_escape_string($content, $modx->db->conn) ."' WHERE {$component[$type]['col_name']} = '". $filename ."'");
			$id = $this->modx->db->getValue("SELECT id FROM $this->table WHERE {$this->component[$this->type]['col_name']} = '". $filename ."'");
			if ($id) {
				$res = $this->modx->db->query("UPDATE $this->table SET {$this->component[$this->type]['col_content']} = '". $this->modx->db->escape($content, $this->modx->db->conn) ."' WHERE {$this->component[$this->type]['col_name']} = '". $filename ."'");
				$updated_items[] = $filename;
			} else {
				$res = $this->modx->db->query("INSERT INTO $this->table SET {$this->component[$this->type]['col_content']} = '". $this->modx->db->escape($content, $this->modx->db->conn) ."', {$this->component[$this->type]['col_name']} = '". $filename ."'");
				$new_items[] = $filename;
			}
			
			
			$fs_items[] = $filename;
		}
		
		// Handle items which may now be in the DB/filesystem but are no longer present in the filesystem/db
		// (i.e. remove deleted resources)

		
		$this->fs_items = $fs_items;
		$this->new_items = $new_items;
		$this->updated_items = $updated_items;
		
		
		// Clear cache if sync'ing back to DB - as chunks etc are cached there
		include_once $this->modx->config['base_path'] ."manager/processors/cache_sync.class.processor.php";
		$sync = new synccache();
		$sync->setCachepath($this->modx->config['base_path'] ."assets/cache/");
		$sync->setReport(false);
		$sync->emptyCache(); // first empty the cache
	}
	
	public function getStats()
	{
		$o = '';
		$o = "###################################################################\n";
		$o .= "# Processing {$this->type}\n";
		$o .= "###################################################################\n\n";
		$o .= "Loaded the following from the file system:\n";
		foreach ($this->fs_items as $i) {
			$o .= "\t$i\n";
		}
		$o .= "\n";
		
		// So our stats method can say which were new components loaded into 
		// the DB, we need to list the DB contents *BEFORE* we load stuff into it
		$res = $this->modx->db->query("SELECT {$this->component[$this->type]['col_name']} AS name FROM $this->table");
		$db_items = $this->modx->db->getColumn('name', $res);
		
		$items_in_db_not_filesystem = array_diff($db_items, $this->fs_items);
		
		if (count($items_in_db_not_filesystem) > 0) {
			$o .= $this->statsBlock("The following are in the database but NOT the file system", $items_in_db_not_filesystem);
		}
		
		return $o;
	}
}