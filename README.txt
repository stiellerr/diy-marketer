Reece Stieller
28/05/2020

1) Create a folder in "themes" and name it: diy-marketer
2) Open cmd, type "cd " and drag the diy-marketer folder into the cmd window, hit enter
3) type "code ." to fire up visual studio code
4) in vs code open a new terminal
5) tyoe: "git init" to initialise git
6) type: "git pull https://github.com/stiellerr/diy-marketer.git" to retieve the lastest version from the github repo
7) type: "npm install" to install all of the project dependencies from the package.json file 
8) copy the node_modules -> "gifsicle", "mozjpeg" & "optipng-bin" to the diy-marketer projects, node_modules folder

TO UPDATE THE GIT REPO
1) In the terminal type: "git add "name_of_the_file"", "git add -A" will add all of the modified files
2) type: "git commit -m "your commit message""
3) type: "git remote add origin https://github.com/stiellerr/diy-marketer.git" this step is only required the first time you to a push
4) type: "git push -u origin master"