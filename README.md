Fuel PHP Asset Server Module
============================

This module offers some features to manage assets from outside the ``DOCROOT`` folder.    
    
The main goal of this module is to allow theme creators to package and distribute their themes in one folder.   
    
## Installation    
please refer to the [Manual](http://docs.fuelphp.com/general/modules.html "Fuel PHP Module Documentation")

## Configuration    
The module provides 4 configuration files :    
1.    _[config.php](#config)_ : main configuration file   
2.    _[routes.php](#routes)_ : routing patterns    
3.    _[security.php](#security)_ : security rules    
4.    _[types.php](#types)_ : list of mime types    
    
> ### config.php<a id="config"></a>    
> For the moment, this file just references directory paths in which the asset locator will look for files.    
> During initialization, paths from the main _theme_ configuration are added to this list.   
> You can retrieve those paths by calling ``\Config::get('assetserver.paths');``    
     
> ### routes.php<a id="routes"></a>    
> **Please note that existing routes must not be altered !**    
> Routes of this module are added to the main _routes_ configuration.    
    
> ### security.php<a id="security"></a>    
> **Take care about what type you allow !**    
> The default behaviour is to deny every type, so you need to allow those you authorize to be served.    
> To do so, you have to add an entry in the assetserver.security.types_allowed array.    
> The latter is an associative array whose keys are mime types or a global pattern, and values are booleans.    
> A type is allowed to be served only if its value or the value of the global class it depends, is set to true.    
> In every other cases it is prohibited.    
> A global pattern is composed by the type followed by a slash and a star, eq. ``text/*``    
> To illustrate this, a global class like ``image/*``, if set to true, will allow all kind of image (like png, jpeg, gif...) to be served.    
> A type is evaluated before its class. If it is defined, the global class is not evaluated for this type.    
> You can by this way, allow all types of a class except some of them.    
> **By default, all text types except PHP, all images and javascript are set to be served.**
     
> ### types.php<a id="types"></a>    
> It provides a list of file types which can be accessed by calling ``\Config::get('assetserver.mime_types');``    
> File types are indexed by their file extension.    
     
## How to use it ?    
The easyest way is to create a theme and deploy it in a sub directory of the ``APPPATH/themes`` directory and build a [HMVC Request](http://docs.fuelphp.com/general/hmvc.html "HMVC Requests Documentation") using the following format :
 ``assetserver/assetmanager/get/%THEME%/%ASSET_NAME%[/%FILE_EXTENSION%]``    
 Where :    
-    _%THEME%_ : is the name of the theme in which looking for the asset
-    _%ASSET\_NAME%_ : is the name of the asset file to look for
-    _%FILE\_EXTENSION%_ : _(OPTIONAL)_ is the asset file extension.      
    If not provided, the first file called _%ASSET\_NAME%_ found is returned.    
    
## How does it work ?    
-    Once called, the asset manager will ask the asset locator for the asset file.    
-    The asset locator will look for the theme in the paths provided.
-    Then it will look for the file requested, and will return its realpath.
-    The asset manager will try to retrieve the file type and check if the latter is allowed.
-    If all is good, it will serve the file.    

## How do I manage file types ?
-    To allow a file type, add an entry in the mime_types array with the type as key and true as value, eq. to allow PNG's : ``'image/png' => true,``    
-    To deny a file type, add an entry in the mime_types array with the type as key and false as value, eq. to deny PHP's : ``'text/x-php' => false,``    
-    To allow all file types from the same main type, add an entry in the mime_types array with the class global pattern as key and true as value,
     eq. to allow all images : ``'image/*' => true``    
    
So if I want to allow all text files except PHP files (for evident security issues...) I have to add ``'text/*' => true,`` and ``'text/x-php' => false,``
    
## What happens if...    
-    the file does not exist or is not found ? _a 404 HTTP error is sent_    
-    the file type is not allowed ? _a 403 HTTP error is sent_    
