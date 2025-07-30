# BlackTek-AAC
An opinionated AAC for Black Tek Server, built with Laravel 12, using React as frontend (Inertia) and Tailwind for styling.

## Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL
- Git

## Linux

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/Black-Tek/BlackTek-AAC.git
   cd BlackTek-AAC
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies and build frontend:
   ```bash
   npm install && npm run build
   ```

4. Copy environment file and configure:
   ```bash
   cp .env.example .env
   ```
   Edit `.env` to set MySQL database credentials and other settings.

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

### Running the Project
1. Start the Laravel development server:
   ```bash
   composer run dev
   ```

2. Access the application at `http://localhost:8000`.

## Windows

### Installation
1. Install and configure all the prerequisites.
   -  When installing Node.js you can target already existing php and mysql, even from a webstack like xampp or uniserver.
   - Make sure to install mysql and php before installing nodejs and composer, in that order is recommended.
   - Git is not explicitly necessary for these windows instructions if you prefer to just download instead of forking, but it is an extremely useful tool to have installed and recommended for any OS.

2. Obtain the AAC

   - You can clone the repo if you have git installed, or a tool for using git like sublime merge, github desktop, ect.
   ```bash
   git clone https://github.com/Black-Tek/BlackTek-AAC.git
   ```
   - Or you can just download this repository from github directly.

3. Install AAC Dependencies

   Now that you have the sources and configuration files, as well as all the prerequisites for this installation, we need to get all the things that this this AAC specifically depends on, and we do that by starting off using the ``Composer`` program we just installed.

   Navigate to the root folder of the project with a command prompt (or other terminal), if you happen to still be in a terminal after using ``git`` to clone this repo, you can use this command ``   cd BlackTek-AAC`` to be where you need to be.. Once you have entered the folder with a terminal run the following command:
   ```bash
      composer install
   ``` 
   If all is well you should see some green text indicating all went smoothly and you can move on to the next step: However if you did not see green text, you may have gotten an error like this instead:

   ```lua
   Your lock file does not contain a compatible set of packages. Please run composer update.

     Problem 1
       - league/flysystem-local is locked to version 3.30.0 and an update of this package was not requested.
       - league/flysystem-local 3.30.0 requires ext-fileinfo * -> it is missing from your system. Install or enable PHP's fileinfo extension.
     Problem 2
       - league/mime-type-detection is locked to version 1.16.0 and an update of this package was not requested.
       - league/mime-type-detection 1.16.0 requires ext-fileinfo * -> it is missing from your system. Install or enable PHP's fileinfo extension.
     Problem 3
       - league/flysystem is locked to version 3.30.0 and an update of this package was not requested.
       - league/flysystem 3.30.0 requires league/flysystem-local ^3.0.0 -> satisfiable by league/flysystem-local[3.30.0].
       - league/flysystem-local 3.30.0 requires ext-fileinfo * -> it is missing from your system. Install or enable PHP's fileinfo extension.

   To enable extensions, verify that they are enabled in your .ini files:
       - C:\WorkZone\packages\php\php.ini
   You can also run `php --ini` in a terminal to see which files are used by PHP in CLI mode.
   Alternatively, you can run Composer with `--ignore-platform-req=ext-fileinfo` to temporarily ignore these required extensions.
   ```
   Or it's possible your error looks something like this:

   ```lua
   Your requirements could not be resolved to an installable set of packages.

     Problem 1
       - Root composer.json requires tightenco/ziggy ^2.4 -> satisfiable by tightenco/ziggy[v2.4.0, ..., v2.5.3].
       - laravel/framework[v12.0.0, ..., v12.20.0] require league/flysystem-local ^3.25.1 -> satisfiable by league/flysystem-local[3.25.1, 3.28.0, 3.29.0, 3.30.0].
       - league/flysystem-local[3.15.0, ..., 3.30.0] require ext-fileinfo * -> it is missing from your system. Install or enable PHP's fileinfo extension.
       - tightenco/ziggy[v2.4.0, ..., v2.5.3] require laravel/framework >=9.0 -> satisfiable by laravel/framework[v12.0.0, ..., v12.20.0].

   To enable extensions, verify that they are enabled in your .ini files:
       - C:\WorkZone\packages\php\php.ini
   You can also run `php --ini` in a terminal to see which files are used by PHP in CLI mode.
   Alternatively, you can run Composer with `--ignore-platform-req=ext-fileinfo` to temporarily ignore these required extensions.

   Use the option --with-all-dependencies (-W) to allow upgrades, downgrades and removals for packages currently locked to specific versions.
   ```

   If you come across this error don't fret, the solution is to navigate to your php.ini file it mentions, and remove the ``;`` from ``;extension=fileinfo`` so that it looks like this after ``extension=fileinfo`` and save the php.ini, you will need to do the exact same thing to the line that reads ``;extension=pdo_mysql`` to enable it by changing it to ``extension=pdo_mysql``.

4. Install and build Node.js and AAC:
   ```bash
   npm install && npm run build
   ```
5. Rename environment file and configure:
 Remove the ``example`` so that it's left with the name as only ``.env`` (Note: You may need to enable viewing of file extensions to do be able to do so)
 Edit `.env` to set MySQL database credentials and other settings
- **BLACKTEK_SERVER_ROOT** (path for the BlackTek Server)
- **DB_USERNAME** (Mysql username)
- **DB_PASSWORD**  (Mysql password)
- **DB_PORT** (Mysql port)
- **DB_HOST** (Mysql host ip : Can be 127.0.0.1 for local)
   (Please note: If you change from using local host for your webserver, you will need to also change 127.0.0.1 in some settings in this file as well)
6. Generate application key:
   If you are still in the terminal in the projects path you can run the following command (if not, get there)
   ```bash
   php artisan key:generate
   ```
7. Run database migrations:
   ```bash
   php artisan migrate
   ```
### Running the project
Navigate to the project's folder inside any terminal and start the server:
   ```bash
   composer run dev
   ```
Then to use the AAC open in browser with ```http://localhost:8000```
