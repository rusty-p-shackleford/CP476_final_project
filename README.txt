
Hey guys. 

So this is just here to try and help you get everything set up.
Also on a side note, phpmyadmin makes some of this database stuff easier if you want to go through the trouble of getting it set up.

1. First you will need to create a database. We have been using one called 'sportsball' but you can call yours whatever you want.

2. Once you do that, you need to change to the local sql variables in the file DBConfig.php in the main directory.
	This is the file that you can call include('../DBConfig.php') in another file in order to create a connection to the database. 

3. Now we need to manually create the tables in the database. The sql commands for this are included in the table_cmds.txt file in the main directory.
	There are 2 main tables 'users' and 'groups'.

4. Also we need to import the hockeyPlayers.csv into a table called 'hockey' in the database. 
	There is lots of stuff online about how to import csv files into mysql that will be able to explain it better than I can here.
	We will need to add rosters for other sports later, but if we can get this one working then the others should be a breeze.

5. In the file: /etc/apache2/sites-available/000-default.conf
	We need to include this line: 'DirectoryIndex index.html index.php ./home/main_page.php' (without the quotes)
	This just lets the apache2 know where to find the page we want it to load for localhost by default, instead of the usual index.php file.

6. You will now need to restart your apache server.


Hopefully that should be enough to get you started. We tried to comment most things as much as possible, so hopefully that helps.

If you notice anything that looks odd, let us know. Hopefully there is nothing major.

I think we have most of the core functionality working more or less. But there is still lots that can be done.

I can appreciate that this might be a bit much at first glance, so if you have any questions or if I can help in any way just me know on the discord.

Thanks guys. 
