@ECHO OFF
set /p fileName=Enter Page Name(without .php):%=%



REM INDEX FILES
set "ext=.php"
set "indexFile="%fileName%%ext%""
copy "index.php" %indexFile%

REM VIEW FILES
set "path1=view/"
set "viewFile="%path1%%fileName%%ext%""
copy "view\index.php" %viewFile%
echo %viewFile%

REM  CONTROLLER FILES
set "path2=controller/"
set "controllerFile="%path2%%fileName%%ext%""
copy "controller\index.php" %controllerFile%
echo %controllerFile%
ping 127.0.0.1


