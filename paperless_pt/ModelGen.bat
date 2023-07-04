@ECHO OFF
set /p fileName=Enter Model Name:%=%




REM VIEW FILES
set "ext=.php"
set "path1=Model/"
set "ModelFile="%path1%%fileName%%ext%""
copy "Model\Sample.php" %ModelFile%
echo %ModelFile%
ping 127.0.0.1
REM set /p a=Press enter to exit...