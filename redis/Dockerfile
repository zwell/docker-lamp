FROM redis:5.0.5
RUN mkdir -p /usr/local/redis/
COPY redis.conf /usr/local/redis/redis.conf
CMD ["redis-server","/usr/local/redis/redis.conf"]
#CMD ["redis-server"]
