Reece Stieller
28/05/2020

1) Create a folder in "themes" and name it: diy-marketer
2) Open cmd, type "cd " and drag the diy-marketer folder into the cmd window, hit enter
3) type "code ." to fire up visual studio code
4) in vs code open a new terminal
5) tyoe: "git init" to initialise git
6) type: "git pull https://github.com/stiellerr/diy-marketer.git" to retieve the lastest version from the github repo. Note: you will be asked to log in with your GitHub credentials
7) type: "npm install" to install all of the project dependencies from the package.json file 
8) if working behind a proxy - copy the node_modules -> "gifsicle", "mozjpeg" & "optipng-bin" from the install -> node_modules folder to the project, node_modules folder. These do not install properly behind a proxy
9) in vs code, navigate to extensions and install the: "recommened" extensions
10) if working behind a proxy the above will need to be done manually. In extensions, click on the elipse, then click "install from vsix" the source files are located in the install -> extensions directory
11) restart vs code, required to get extensions ie 'prettier' working properly (on save)
12) open wp-config.php in the wp root folder, scroll down until you find: "define( 'WP_DEBUG', false );" replace it for the code below, this will enable debugging.
    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_DISPLAY', false );
    define( 'WP_DEBUG_LOG', true );
13) if you are working behind a proxy ie at work, add the following settings to the bottom of the file. This will allow you to do tasks such as searching & downloading themes or plugins.
    define('WP_PROXY_HOST', '202.175.128.101');
    define('WP_PROXY_PORT', '80');
    define('WP_PROXY_USERNAME', 'zeus\stiell11');
    define('WP_PROXY_PASSWORD', 'Skippycorn42_');
    define('WP_PROXY_BYPASS_HOSTS', 'localhost');
    to allow wp "get" and "post" requests to function, add the following filter to the wp-config.php file. Note: you can also add it inside your theme or plugin. ie to your themes functions.php file
    add_filter('https_ssl_verify', '__return_false');

--TO UPDATE THE GIT REPO--
1) In the terminal type: "git add "name_of_the_file"", "git add -A" will add all of the modified files
2) type: "git commit -m "your commit message""
3) type: "git remote add origin https://github.com/stiellerr/diy-marketer.git" this step is only required the first time you to a push
4) type: "git push -u origin master"  Note: you will be asked to log in with your GitHub credentials.