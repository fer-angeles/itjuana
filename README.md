<p align="center">
    <a href="https://www.linkedin.com/in/juan-fr%C3%ADas-968a4166/" target="_blank">
        <img src="https://media-exp1.licdn.com/dms/image/D5635AQH0j71Ilh0KFw/profile-framedphoto-shrink_200_200/0/1642440881921?e=1645473600&v=beta&t=HTwEjnY-nGf9GwT-TKPwMv5bq9w1-s46zo3VFooD5cA" width="400">
    </a>
</p>

<p align="center">
    <a href="#">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

## About Aplication

The app helps to find the suitability score (SS) that maximizes all the deliveries to the drivers. <br>    
The app is done in Laravel 9, inside the framework a command that looks and finds the SS among the delivery file data address and the drivers’ company file was written.

## The steps to run the program:
To have installed **PHP** in the environment where the application will be executed
- [Install PHP on Windows](https://www.php.net/manual/en/install.windows.php).
- [Install PHP on Mac](https://www.php.net/manual/en/install.macosx.php).
- [Install PHP on Linux](https://www.php.net/manual/en/install.unix.debian.php).

## PHP Version

Once the PHP is installed we open a system terminal to confirm the PHP version that we have installed. The application can only be executed with php >= 8.0
```
php -v 
```

## Composer

When we have the correct PHP version in our environment we will proceed to install the [**composer**](https://getcomposer.org/download/) library to install the necessary Laravel’s dependencies.
- [Install **composer** on Windows](https://getcomposer.org/doc/00-intro.md#installation-windows).
- [Install **composer** on Mac](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos).
- [Install **composer** on Linux](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos).

## Creating Path and Cloning the repository

We open a system’s terminal and we go to the path where we want to clone our repository. **Example**:
```
cd Documents 
```
Once in our file, we clone the repository in our environment in the following way:

```
git clone https://github.com/fer-angeles/itjuana.git new_floder
```

Once the repository is finished to clone, we go inside the file which was created when cloning the repository.

```
cd new_folder
```
Inside the file we install all the necessary library so the framework works in the correct way with the following command
```
composer install
```
Once the library is finished to install, a file called vendor will be created. In it we can use the library that includes the framework called artisan, with the following command we can visualize the list of commands that were created and that Laravel includes
```
php artisan list
```


## Command PSCE

The command we are going to use to find the SS of the drivers is: psce:ss, the correct way to execute the command is the following:
```
php artisan psce:ss
```

The command will ask us the complete path where the address file and the driver’s file are found. <br>

As a result, the command generates in the terminal which driver will go to which address.


## License

The **APP** framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
