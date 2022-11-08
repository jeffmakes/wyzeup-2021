# Summary
Restored from the /zip folder in the wyseupOrig backup. Hacking around to make it run on a Dreamhost instance with non-ancient PHP

Clone this into the root directory of a http server instance with PHP running and it should run.

Currently the main page loads, including all images and CSS, and the "Free Demo" button launches the "Game" itself in a new window. The game pulls in data from the database, allowing you to select and begin two different scenarios. I've now also fixed the Wyze/Unwyze buttons and the game is playable.

# Porting
The main work was to port the app to the version of PHP that Dreamhost is currently running for our instance (7.4). In version 7, the `mysql_` functions have changed to `mysqli_`. I didn't research much about what the change actually is, but the main impact on our app was in the `mysql_query()` function calls. They become `mysqli_query()` but it doesn't work quite the same - it requires an extra paramater to be passed to it, `mysqli $mysql` that represents the connection to the database.

My solution was to create a global variable `$con` that stores the connection object and can be included into each `.php` file that needs it by using `global $con` before passing it to `mysqli_query($con, $query)`. It's a pretty nasty hack - instead of the object being global it should probably be a part of some class somewhere, but that would require a deeper understanding of how the app works, so I'm sticking with the hack.

# Hosting

At present, the app is hosted on gordon, my DreamHost instance, in the /home/dh_spdipt/wyzeup.dreamhosters.com folder and is accessable here: [https://wyzeup.dreamhosters.com/](https://wyzeup.dreamhosters.com/)
