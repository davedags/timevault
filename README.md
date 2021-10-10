Lazy  way to quickly encrypt a string that can only be decrypted after chosen date.  Not meant to be secure by any means.

Create master.key in root dir

Lock:

php ./lock.php stringtoencrypt "2021-10-12 12:00:00"

Unlock:

php ./unlock ./encstore/encrypted-1633840636

