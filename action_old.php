        ServerAdmin admin@your-domain.com

        DocumentRoot /var/www/html/django_project/

        ErrorLog ${APACHE_LOG_DIR}/your-domain.com_error.log
        CustomLog ${APACHE_LOG_DIR}/your-domain.com_access.log combined

        Alias /static /var/www/html/django_project/static
        <Directory /var/www/html/django_project/static>
                Require all granted
        </Directory>

        Alias /media /var/www/html/django_project/media
        <Directory /var/www/html/django_project/media>
                Require all granted
         </Directory>

        <Directory /var/www/html/django_project/django_app/django_app>
                <Files wsgi.py>
                        Require all granted
                </Files>
        </Directory>

        WSGIDaemonProcess django_app python-path=/var/www/html/django_project/django_app python-home=/var/www/html/django_project/django_env
        WSGIProcessGroup django_app
        WSGIScriptAlias / /var/www/html/django_project/django_app/django_app/wsgi.py
