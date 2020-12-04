FROM php:7.4-cli
COPY . /home/html/Slim4-API-Skeleton
WORKDIR /home/html/Slim4-API-Skeleton
CMD [ "php", "./public/index.php" ]