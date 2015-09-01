kint
====

Original and more features can be found here:
http://raveren.github.com/kint/


Requirements 

  Tested on 1.1.12. Should work on earlier versions.

Setup 

Download and extract the folder under protected/extensions.

Add to your config 
~~~
'components' => [
   ...
   'kint' => [
       'class' => 'ext.Kint.Kint',
   ],
   ...
]
~~~

To access the shortcut functions add it to the preload in your config

~~~
'preload' => ['kint'],
~~~

Note: You can still use the plugin without autoloading, but shortcut functions will no be available, 
   instead use:
~~~
Kint::dump($variable);
~~~
Usage:

To dump a variable:
~~~
d($variable);
~~~

There is often a need to halt execution after dumping a particular variable:
~~~
dd($variable); // execution will stop after this statement; same as d($variable);die;
~~~
To print out variable information in simple text (no CSS style or javascript) use
~~~
s($variable); // stands for "simple"
    // or, as before
  sd($variable); // this will halt execution after displaying data
~~~  

There are also modifiers:
~~~
+d($variable); // will dump variable information without limiting the depth
    /// and
-d($variable); // will run ob_clean() beforehand, so this dump is at the top
                   // of the page. Best used with dd().
!d($variable); // will simply dump variable wrapped to html comments                   
~~~                   
The latter are possible because the class analyzes the PHP code itself where it was called from.

Last, but not least, you can output a pretty and readable backtrace:

~~~
Kint::trace();
~~~
