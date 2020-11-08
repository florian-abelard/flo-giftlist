FROM httpd:2.4-alpine

RUN sed -i "s/#LoadModule\ rewrite_module/LoadModule\ rewrite_module/" /usr/local/apache2/conf/httpd.conf;
RUN sed -i "s/#LoadModule\ deflate_module/LoadModule\ deflate_module/" /usr/local/apache2/conf/httpd.conf;
RUN sed -i "s/#LoadModule\ proxy_module/LoadModule\ proxy_module/" /usr/local/apache2/conf/httpd.conf;
RUN sed -i "s/#LoadModule\ proxy_fcgi_module/LoadModule\ proxy_fcgi_module/" /usr/local/apache2/conf/httpd.conf;

# Copy apache vhost file to proxy php requests to php-fpm container
COPY app.conf /usr/local/apache2/conf/app.conf
RUN echo "Include /usr/local/apache2/conf/app.conf" \
    >> /usr/local/apache2/conf/httpd.conf
