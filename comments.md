1
--
We put this file, `Module.php`, in the root of the **module** directory (`module/Album`).   
  We put it here because this is where the `ModuleManager` in Zend Framework 2 will look for it.  
  `ModuleManager` expects to find a class called `Album\Module` within it.   
  It will load and configure a module.  
  That is, the classes within a given module will have the namespace of the module’s name, which is the directory name of the module.  
2
--
 `getAutoloaderConfig()` (as well as `getConfig()`) will automatically be called by Zend's `ModuleManager`.  

3 
--
`getConfig()` (as well as `getAutoloaderConfig()`) will automatically be called by Zend's `ModuleManager`.  
This method simply **loads** the `config/module.config.php` file.

4
--
returns an array.   
The array is compatible with ZF2’s `AutoloaderFactory`. 
  We configure it so that we do the following:  
   1) add a **class map file** (`autoload_classmap.php`) to the `ClassMapAutoloader` and also   
  2) add this module’s namespace to the `StandardAutoloader`. 
  The **standard autoloader** requires a **namespace** and the path where to find the files for that namespace. It is **PSR-0** compliant and so **classes** map directly to **files** as per the PSR-0 rules.  

5
--
 we provide an empty array for the **classmap autoloader** because we are in development, and we don’t need to load files via the classmap 
 
6
--
 As this is an empty array, whenever the **autoloader** looks for a class within the `Album` namespace, it will fall back to the to `StandardAutoloader` for us.

7
--
The `ServiceManager` passes the **config** information  to the relevant components.   
We need **two** initial sections: **`controllers`** and **`view_manager`**.   

- The `controllers` section provides a list of all the controllers provided by the module. We will need **one** controller, `AlbumController`, which we’ll reference as `Album\Controller\Album`. The controller **key** must be unique across all modules, so we prefix it with our module name.

- Within the `view_manager` section, we add our `view` directory to the **`TemplatePathStack`** configuration.   
This will allow it to find the **view scripts** for the `Album` module that are stored in our `view/ directory`.

8
--
We add the module name to the list of modules, to inform the `ModuleManager` that this new `Album` module exists.


9
--
`segment` is the route's **type**

10
--
`album` is the route's **name**.  
The route ``/album[/:action][/:id]`` will match any URL that starts with `/album`.  
`[/:action][/:id]` are the placeholders in the URL pattern. They will be mapped to named parameters in the matched route.  
The **square brackets** indicate that a segment is **optional**.  

- `[/:action]` segment will be mapped to the optional **action** name.  
- `[/:id]` segment will be mapped to the optional **id**.  

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
It allows us to ensure that the characters within a segment are **as expected**, so we have limited actions to starting with a letter and then subsequent characters only being alphanumeric, underscore or hyphen. We also limit the `id` to a **number**.

12
--
to inform the `Album` module about the `Album` controller 

13
--
Our `Album` entity object is a simple PHP class.

14
--
The `exchangeArray()` method:  
-  it is used in order to work with Zend\Db’s `TableGateway` class.   
This method simply copies the data from the passed in array to our entity’s properties. We will add an input filter for use with our form later.

15
--
protected property `$tableGateway`

16
--
we set the protected property `$tableGateway` to the `TableGateway` instance passed in the constructor. We will use this to perform operations on the database table for our albums.

17
--
helper methods that our application will use to **interface** with the `TableGateway`.

18
--
retrieves all albums rows from the database as a `ResultSet`

19
--
retrieves a single row as an `Album` object

20
--
either creates a new row in the database or updates a row that already exists

21
--
removes the row completely

22
--
`getServiceConfig()`:  
- it is automatically called by the `ModuleManager` and applied to the `ServiceManager`   
- it provides a **factory** (**closure** or **callback**).  
- if the `ServiceManager`	 needs an `AlbumTable` object the factory instantiates/creates it.  
- the `ServiceManager` defines how to create a `AlbumTable` object because we need to always use the same instance of our `AlbumTable`.  
-  If the `AlbumController` needs an `AlbumTable` object, it can be retrieved.

23
--
`getServiceConfig()`:   
- returns an array of factories  

`ModuleManager` does the following:  
- first it merges all the factories together  
- and then passes them to the `ServiceManager`.  

24
--
The factory for `Album\Model\AlbumTable`:  
- Use the `ServiceManager` (`$sm`) to create an `AlbumTableGateway` object

25
--
Pass the `AlbumTableGateway` object to the `AlbumTable` object.  

26
--
Also tell the `ServiceManager` (`$sm`) that an `AlbumTableGateway` object is created:  
- by getting a `Zend\Db\Adapter\Adapter` (also from the `ServiceManager`)   

27
--
- and using it to create a `TableGateway` object.    
  
The `TableGateway` classes use the **prototype pattern** for creation of result sets and entities.   
This means that instead of instantiating when required, the system clones a previously instantiated object. See PHP Constructor Best Practices and the Prototype Pattern for more details.

28
--
configuring the `ServiceManager` so that it knows how to get a `Zend\Db\Adapter\Adapter`.

29
--
this factory, `Zend\Db\Adapter\AdapterServiceFactory`, will tell the `ServiceManager` how to get a `Zend\Db\Adapter\Adapter`.

30
--
The database credentials: username and password

31
--
`getAlbumTable()`:  
- is called from within the controller when there's a need to interact with the model.  
- to retrieve an `AlbumTable` created by the `ServiceManager`.

32
--
In order to list the albums, we need to **retrieve** them from the `Album` model and pass them to the view.  
The **return value** is a `ViewModel` object.  
It is used to set variables in the view.  
`ViewModel`'s constructor's first parameter is an array from the action containing data we need. These data are then automatically passed to the view script.  
The `ViewModel` object also allows us to change the view script that is used, but the default is to use `{controller name}/{action name}`. 

33
--
`headTitle()` is a view helper:  
- to set the **page title** and the title for the `<head>` section.

34
--
`url(A,B)` is a view helper:  
- to create the links we need.  
The parameters:  
- `A`: the route name we wish to use (*here* `'album'`) for construction of the URL  
- `B`: an array of all the variables to fit into the placeholders to use.  
- we use our `'album'` route which is set up to accept two placeholder variables: `'action'` and `'id'`.  


35
--
to display album's title

36
--
to display album's artist(s)

37
--
A link to **edit** a row

38
--
a link to **delete** a row

39
--
A standard `foreach:` loop   
its alternate form using a colon (`:`) and `endforeach;`   
- it is easier to scan than to try and match up braces.

40
--
`escapeHtml()` is a view helper   
- to help protect ourselves from Cross Site Scripting (XSS) vulnerabilities

41
--
The `Zend\Form` component manages the form and form validation.

42
--
as we call the parent’s constructor, we set the **name** of the form.

43
--
Create 4 form elements: the **id**, **title**, **artist**, and **submit** button. For each item we set various attributes and options, including the label to be displayed.

44
--
input filter
add it to the `Album` class
We also need to set up validation for this form. In Zend Framework 2 this is done using an input filter, which can either be standalone or defined within any class that implements

45
--
One of the 2 methods defined by `InputFilterAwareInterface `

46
--
One of the 2 methods defined by `InputFilterAwareInterface `

47
--
We simply throw an exception in `setInputFilter()` because we only need to implement `getInputFilter()`.

48
--
Instantiate `InputFilter`

49
--
add the inputs that we require.  
We add one input for each property that we wish to filter or validate.

50
--
For the **id** field:  
we only need integers in this field, so we add an `Int` filter for it.

51
--
This is a text field  
Here we need to remove unwanted HTML and unnecessary white space, so we add 2 **filters**: `StripTags` and `StringTrim`


52
--
to report error when the field is left empty

53
--
`StringLength` validator   
- ensures that the user doesn’t enter more characters than we can store into the database.

54
--
Filter: `StripTags`  
	
- removes unwanted HTML
 
55
--
Filter: `StringTrim`   

- removes unnecessary white space

56
--
We instantiate `AlbumForm`

57
--
set the submit button's label to string “Add”.  
We do this here as we’ll want to re-use the form when editing an album and will use a different label.

58
--
if the form has been submitted

59
--
set the form’s input filter from an **album** instance.

60
--
set the posted data to the form

61
--
Use the `AlbumForm->isValid()` to check to see if the POSTed data is **valid** 

62
--
grab the data from the form

63
--
store to the model using `saveAlbum()`.

64
--
After we have saved the new `album` row, we use the Redirect controller plugin redirect back to the list of albums.

65
--
Finally, we return the variables that we want assigned to the view. In this case, just the form object.  
Note that Zend Framework 2 also allows you to simply return an array containing the variables to be assigned to the view and it will create a ViewModel behind the scenes for you. This saves a little typing.

66
--

`form()`:  a view helper

67
--
`openTag()`: opens the form

68
--
`closeTag()`: closes the form.

69
--
`formRow()`: for each element with a label

70
--
`formHidden()`: for the elements that are standalone

71
--
`formSubmit()`: for standalone elements

72
--
An alternative (simpler) way to render the form.  
It uses the bundled view helper `formCollection`.   
This will iterate over the form structure, calling the appropriate label, element and error view helpers for each element.  
However, you still have to wrap `formCollection($form)` with `openTag()` and `closeTag()`. This helps reduce the complexity of your view script in situations where the default HTML rendering of the form is acceptable.