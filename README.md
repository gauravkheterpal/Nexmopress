# Nexmopress
As the name itself suggests, Nexmopress is built to offer the best of both worlds - the power of Wordpress combined with the additional layer of security offered by Nexmo. Offered as a Wordpress plugin, Nexmopress lets Wordpress administrators verify guest users verify their identity using their phone number and helps cut down the threat of spam comments.

Nexmopress uses the Number Verify capabilities offered by Nexmo and integrates into the comment verification module for Wordpress to give you spam-free verified comments, thereby improving the overall quality of content on your site.

## Setup Prerequisites
1. [Wordpress 4.0 or above](https://wordpress.org/)
3. [MySQL](http://www.mysql.com) is used 

## Demo Video
http://www.screencast.com/t/XeYojcCWX7m

## Installation
1. Go to Plugins -> Upload.

2. Chose the Nexmopress.zip file and hit Install Now

3. Once installed, hit the 'Activate' button to activate Nexmopress plugin.

That's it, you are all set to experience the Nexmopress goodness!


## Verification
1. Enter your phone number
  
Open any blog post and go to Comments section. When you try to enter a comment, you're now prompted to enter your phone number.

2. Enter the verification code

Once you've entered your number, the plugin uses Nexmo's Verify Number capabilities to generate a verification code. Nexmopress then validates your verification code to determine whether the comment should be posted or not.

    1. If the entered verification code is valid, the comment is posted
    
    2. If the entered verification code is invalid, the user is prompted to try again and a fresh verification code is sent to the user's phone number
    
## What next?
Nexmopress is a demonstrator of how powerful the Nexmo platform capabilities are and how it can be integrated to enhance Wordpress to make it more secure. Of course, in it's current form, Nexmopress is just the tip of the iceberg and it can be expanded further to generate more powerful analytics for Wordpress users based on the wealth of information provided by Nexmo API.

I had a lot of fun building Nexmopress for the Nexmo Developer Contest and I hope you've as much fun evaluating it. May the best app win!


