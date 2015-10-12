# Security project

The simple system which protects your web application from SPAM without Captcha.
Check exmaple.php for usage sample. More info and docs comming soon..

# How it work

Every one time when you reload page with you HTML form, Security Class genering hash hidden fields, and after you submit this fields send to server. On server script requere PHP Security Class and check secure fields. If fields correct, you can do other validation form. If you use AJAX request you need send back some hash field, see example.
