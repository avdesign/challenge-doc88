FROM wyveo/nginx-php-fpm:latest
WORKDIR /usr/share/nginx/
#RUN rm -rf /usr/share/nginx/html
#COPY . /usr/share/nginx
RUN ln -s public html

