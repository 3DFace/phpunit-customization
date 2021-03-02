My custom comparison extension for `phpunit`.

I prefer to compare objects with `equals` method. 

`phpunit` provides `assertObjectEquals` method, but it's unsuitable to me because I want to compare arrays of objects too.  

Also I prefer strict scalar comparison.

To use it add the following to `phpunit.xml`

```
  <extensions>
     <extension class="dface\PhpunitCustomization\ComparatorExtension"/>
  </extensions>
```
