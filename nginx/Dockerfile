FROM nginx:1.16.0
RUN groupadd www && useradd -g www -s /sbin/nologin www
COPY nginx.conf /etc/nginx/nginx.conf