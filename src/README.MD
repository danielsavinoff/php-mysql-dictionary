# How to run it?
To run the script, type `php -d extension=mbstring index.php -D [optional] -L [optional]`. 
### Optional parameters:
- -D - path to a dictionary file from src folder
- -L - path to a library directory where you expect the result to be


To run the script on a PHP built-in server, type `php -d extension=mbstring -S [ip]:[port]`.

Tested on PHP 8.3.14. Recommended to use Docker instead.