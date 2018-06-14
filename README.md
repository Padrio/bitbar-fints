# bitbar-fints - A Bitbar Plugin written in PHP
```
Licence: GPL-3.0
Author: Pascal Krason <p.krason@padr.io>
Language: PHP 7
```
Please note: by using this Plugin, anyone who looks at your screen can see your current account balance.

# Setup
First of all you need Composer and PHP (atleast Version 7.0) with the curl extension installed on your machine. Then you can go ahead and clone the repository into your Bitbar Plugin Directory:

```bash
# This directory can be different on your system
cd .bitbar

# Clone repository
git clone https://github.com/Padrio/bitbar-fints.git

# Change working directory
cd bitbar-fints

# Install requirements
composer install

# Create sample configuration
cp config.yaml.dist config.yaml

# Create a symlink to binary
ln -s diba-balance/console ../fints-history.1h
```

# Configuring
You can open the config.yaml with any editor. The file is well documented and should need no explaination.