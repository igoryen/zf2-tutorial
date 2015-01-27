1
--
We put this file, `Module.php`, in the root of the module directory (`module/Album`). 
  We put it here because the `ModuleManager` in Zend Framework 2 will look for it here.
  It expects to find a class called `Album\Module` within it.   
  It will load and configure a module.  
  That is, the classes within a given module will have the namespace of the module’s name, which is the directory name of the module.  
2
--
 `getAutoloaderConfig()` (as well as `getConfig()`) will automatically be called by Zend's `ModuleManager`.  
3 
--
`getConfig()` (as well as `getAutoloaderConfig()`) will automatically be called by Zend's `ModuleManager`.  
This method simply loads the `config/module.config.php` file.

4
--
returns an array.   
The array is compatible with ZF2’s `AutoloaderFactory`. 
  We configure it so that we do the following:  
   1) add a class map file (`autoload_classmap.php`) to the `ClassMapAutoloader` and also   
  2) add this module’s namespace to the `StandardAutoloader`. 
  The standard autoloader requires a **namespace** and the path where to find the files for that namespace. It is **PSR-0** compliant and so classes map directly to files as per the PSR-0 rules.  

5
--
 we provide an empty array for the classmap autoloader because we are in development, and we don’t need to load files via the classmap 
 
6
--
 As this is an empty array, whenever the autoloader looks for a class within the `Album` namespace, it will fall back to the to `StandardAutoloader` for us.

7
--
The **config** information is passed to the relevant components by the `ServiceManager`. We need **two** initial sections: **`controllers`** and **`view_manager`**.   
The `controllers` section provides a list of all the controllers provided by the module. We will need **one** controller, `AlbumController`, which we’ll reference as `Album\Controller\Album`. The controller **key** must be unique across all modules, so we prefix it with our module name.

Within the `view_manager` section, we add our `view` directory to the **`TemplatePathStack`** configuration.   
This will allow it to find the **view scripts** for the `Album` module that are stored in our `view/ directory`.

8
--
To inform the `ModuleManager` that this new `Album` module exists, we add the module name to the list of modules.


9
--
`segment` is the route's **type**

10
--
`album` is the route's **name**.  
The route ``/album[/:action][/:id]`` will match any URL that starts with `/album`.  
`[/:action][/:id]` are the placeholders in the URL pattern. They will be mapped to named parameters in the matched route.  
The **square brackets** indicate that a segment is **optional**.  
`[/:action]` segment will be mapped to the optional action name.  
`[/:id]` segment will be mapped to the optional id.  

This route allows us to have the following URLs:

    URL           Page                              Action
	------------------------------------------------------
    /album           Home (list of albums)	        index
    /album/add	     Add new album	                add  
    /album/edit/2	 Edit album with an id of 2	    edit  
    /album/delete/4	 Delete album with an id of 4	delete  


11
--
The `constraints` section.   
It allows us to ensure that the characters within a segment are as expected, so we have limited actions to starting with a letter and then subsequent characters only being alphanumeric, underscore or hyphen. We also limit the `id` to a number.

