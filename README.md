# ECCO 2010
Uploading it to GitHub just for the record

## About it
I developed this register form for a college project (around 2010). I found it recently and decided to upload it to GitHub... because reasons.

I'll try to work on the to-do's, but can't promise anything as it depends mostly on my spare time.

Some tweaks were done from the original, such as the sample database script due to it containing sensitive information (that probably nobody cares, but I prefer to avoid problems).

## Cui honorem, honorem honorem
This project was heavily based on the following:  
* _PHP 6 and MySQL 5 for Dynamic Web Sites: Visual QuickPro Guide_  
    * Find it on the [author site](http://www.larryullman.com/books/php-6-and-mysql-5-for-dynamic-web-sites-visual-quickpro-guide-3rd-edition/)
    * Or on [Amazon](https://www.amazon.com/PHP-MySQL-Dynamic-Web-Sites/dp/032152599X) (mostly for reference, current edition also linked there)


Larry Ullman can also be found on [GitHub](https://github.com/larryullman) (unless he's another guy with the same name that publishes on the same topic).

## To-do's
- Add border to text inputs
- Translate the filenames (and code) to English, because... [Do you speak it?](https://www.youtube.com/watch?v=HbvYeLxMKN8)
- General clean up
- Issues with charset (displaying unreadable characters for diacritics)
- Add icon to this readme
- Add sample db script to generate db

## Collaboration
If for some reason you were an organizer/staff for this event and want your name here ~~(even though you didn't have a clue about coding)~~, please feel free to contact me.

## Random
I didn't bother much about the exact LAMP stack from that time, so I just installed them separately from the Ubuntu repositories.

```
sudo apt install apache2

sudo apt install php libapache2-mod-php php-cli php-mysql

sudo apt install mysql-server
```

Which at the memoment they appear to be:
* Ubuntu 17.10 (Artful Aardvark)
* Apache 2.4.27
* MySQL 5.7.21
* PHP 7.1.11