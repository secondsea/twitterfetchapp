
The file that is needed is the keys.php file.
Please email me for the missing file.
mary.theresa.cusack.gmail.com
you put this file in the include directory.
for Konica exercise you will recieve my keys.
for anyone else unothorized I will omit them so you can insert your own

The authentication module needed I used was
The simplest PHP Wrapper for Twitter API v1.1 calls  by James Mallison
https://github.com/J7mbo/twitter-api-php

Twitter calls will not authenticate without the certification module cacert.perm
Downlowd from https://curl.haxx.se/docs/caextract.html or http://www.cacert.org/index.php?id=3
and copy into the ssl directory usually found in the extras directory in your php installation
Then in the [curl] portion of you php.ini file simple set the path where cacert.perm is located.
Make sure you copy php.ini to back up you settings.

[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
;curl.cainfo =
curl.caininfo="C:/Program Files/PHP/v7.0/extras/ssl/cacert.pem"
;curl.cainfo="C:/wamp/cacert.pem"
openssl.cafile="C:/Program Files/PHP/v7.0/extras/ssl/cacert.pem"

I chose php because I am familiar with it and the documentation I could find used php example.  If I found a javascript call,
 I would have ajax and jquery to fetch the stream.  
my php installation is on a windows 10 laptop so one should have IIS and wamp installed and running.  
if the twitter app directory is used in a wwwroot directory then all that needs to be done to run the search is "locahost/twitterfetchapp" 
Note: at this time input of user name only searches my key account for tweets from that user.  I may at a later date add the user
history option to retrieve tweets from the user inputed.
 I have added error messaging for checking for needed parameters, invalid address location and invalid name. 
 If there are not tweets on the timeline for the specified user the response should inform the user.

