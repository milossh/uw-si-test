# UpWork project for S.I.

## Apache VHOST configuration

	ServerAdmin webmaster@localhost
	DocumentRoot /home/milos/projects/uwsi
	
	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

	<Directory "/home/milos/projects/uwsi">
            Options Indexes MultiViews FollowSymLinks
            AllowOverride All
            Require all granted
	</Directory>


## API Endpoints
Test intro was a tad incomplete, and I was worried about the first *.php vs. *.html filename restraint, so I chose to simply bootstrap my REST Endpoints in .htaccess in the form of RewriteRule(s).

## Libraries
For projects of this size, I would never ever use 3rd party libraries, like jQuery and Bootstrap. That said, in the original job posting, you mentioned you need someone with experience with jQuery and Bootstrap, so I decided to go with it.

