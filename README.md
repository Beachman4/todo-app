# Todo Item Application

*I made this to showcase a small portion of my development skills and also for personal use, mainly to track Pull Requests*

There are a few steps to take to set this up

*This will generate the application key used to encrypt data*

First run,

    composer install & npm install

Second run,
    
    php artisan key:generate
    
*This is for generating JWT Tokens for the front end*

Third,
    
    php artisan jwt:secret
    
Next, fill out the information in .env

# Testing

First run:

    php artisan db:seed
    
Second run the tests,

    php artisan dusk