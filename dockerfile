FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip

# mysqli 확장 설치
RUN docker-php-ext-install \
    mysqli \
    zip
# (선택) 기타 필요한 확장도 함께 설치 가능
# RUN docker-php-ext-install pdo pdo_mysql

RUN echo "upload_max_filesize=210M" > /usr/local/etc/php/conf.d/uploads.ini \
 && echo "post_max_size=220M"      >> /usr/local/etc/php/conf.d/uploads.ini \
 && echo "memory_limit=512M"       >> /usr/local/etc/php/conf.d/uploads.ini \
 && echo "max_execution_time=120"  >> /usr/local/etc/php/conf.d/uploads.ini \
 && echo "max_input_time=120"      >> /usr/local/etc/php/conf.d/uploads.ini


# 아파치 설정 재로드
RUN a2enmod rewrite