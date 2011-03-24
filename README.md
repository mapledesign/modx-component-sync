# Component sync for MODX Evolution

This module for MODX Evolution (tested with 1.0.5) allows components stored in the database (chunks, snippets, templates, plugins) to be copied to the file system and vice versa. This enables them to be easily edited using your favourite text editor, and also stored under version control.

WARNING: Currently MODX has no way to determine when a component in the database was modified. This script is very naive, and will overwrite all items in the database/on the file system, instead of checking modification dates. That is planned for a future release.


## To use

You can either run the module from the command line as follows:

  $ cd assets/modules/component-sync/
  $ php cmd.php dump
or
  $ php cmd.php load
  
or you can install the web-based module. 

To do this, go to Modules -> Manage modules.
Click on the 'New Module' button
Give the module a name (e.g. 'Component Sync') and paste the following code in as the module code:

  include $modx->config['base_path'].'assets/modules/component-sync/module.php';
  
That really is all there is to it!