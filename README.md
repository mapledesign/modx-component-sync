# SyncX - Component sync for MODX Evolution

## What does it do?
How often have you modified a chunk or snippet in MODX and then wanted to go back to the previous version? Or done a round of updates which needed reverting, and cursed that your components weren't under version control?

Curse no more. This module for MODX Evolution (tested with 1.0.5) allows components stored in the database (chunks, snippets, templates, plugins) to be copied to the file system and vice versa. This enables them to be easily edited using your favourite text editor, and also stored under version control.

### WARNING:

Currently MODX has no way to determine when a component in the database was modified (we have a patch on the way for that...). This script is very naive, and will overwrite all items in the database/file system regardless of which is newer. **You have been warned!**

## To install

Assuming you are logged into a terminal and already in your MODX site's root directory, the following commands are all you need to use:

    $ cd assets/modules
    $ git clone git://github.com/pbowyer/modx-component-sync.git component-sync

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
    
Run the module, and follow the on-screen prompts.
  
That really is all there is to it!

## Colophon

SyncX was developed by Peter Bowyer and the team at Maple Design Ltd. We build custom MODX applications and add-ons like this [easy to manage photo gallery](http://www.youtube.com/watch?v=SUbM_D2GT4s) to make your clients' lives easier. [Contact us](http://www.mapledesign.co.uk/services/s/content-management-systems/modx-development/) to find out how we can help!

This code should be considered alpha-quality. We are using it but have not extensively tested it.

Feedback, bug reports, questions and usage scenarios we've not considered are all welcome. Please use the ticket system here on Github.

The code is licensed under the MIT license, and eventually we'll add license headers to the code :)