Name:       levack-php-classes
Version:    1
Release:    1
Summary:    PHP class files to be used by other levack packages
License:    GNU GENERAL PUBLIC LICENSE Version 3
Requires:   php >= 5.4.16, php-mysql >= 5.4.16
URL:        https://github.com/DanLevack/php_classes

%description
PHP class files to be used by other levack packages.

%prep
# we have no source, so nothing here

%build

%install
mkdir -p %{buildroot}/var/lib/levack/php-classes/lib
install -m u+rw,g+r,o+r /var/lib/jenkins/workspace/Build_PHP_Classes_RPM/db.php %{buildroot}/var/lib/levack/php-classes/lib/db.php
install -m u+rw,g+r,o+r /var/lib/jenkins/workspace/Build_PHP_Classes_RPM/ini_files.php %{buildroot}/var/lib/levack/php-classes/lib/ini_files.php

%files
/var/lib/levack/php-classes
/var/lib/levack/php-classes/lib
/var/lib/levack/php-classes/lib/db.php
/var/lib/levack/php-classes/lib/ini_files.php

%changelog
# let's skip this for now
