Laravel installeren op Mac

- Installeer composer

`composer global require "laravel/installer"`

- Zet het volgende pad in je ZSHRC of BASHRC

`export PATH=~/.composer/vendor/bin:$PATH`

- Database instellen, MYSQL aanmaken

php artisan make:model User

