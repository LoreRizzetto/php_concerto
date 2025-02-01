--(){ :;}
--; set -euxo pipefail

--; # you could argue that $RANDOM is not cryptographically secure
--; USER_PASSWORD=$( ( which openssl &>/dev/null && openssl rand -hex 64) || for i in {1..30}; do echo -n $RANDOM; done )

--; # Create user
--; echo "DROP USER IF EXISTS 'concerti_user'@'localhost'; CREATE USER 'concerti_user'@'localhost' IDENTIFIED BY '$USER_PASSWORD';"; 

--; # Write credentials to config
--; echo -e "<?php\nclass DbConf{\n    public static \$host='127.0.0.1';\n    public static \$database='concerti';\n\n    public static \$username='concerti_user';\n    public static \$password='$USER_PASSWORD';\n}" > config.$RANDOM.php

--; echo '
DROP DATABASE concerti;
CREATE DATABASE concerti;
--; '

--; echo "GRANT INSERT, UPDATE, DELETE, SELECT ON concerti.* TO 'concerti_user'@'localhost';";

--; echo '
CREATE TABLE concerti.concerti (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    codice TEXT, 
    titolo TEXT, 
    descrizione TEXT, 
    data DATETIME
);
--; '
