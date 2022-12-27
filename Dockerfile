FROM php:7.4-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    libncursesw5-dev \
    libreadline-dev \
    git

## Install TUI dependencies
#RUN pecl install ncurses
#RUN docker-php-ext-enable ncursed

# Copy project files
COPY . /app
WORKDIR /app

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

### Set the entrypoint for the container
#ENTRYPOINT ["php", "index.php"]