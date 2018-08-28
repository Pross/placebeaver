# PlaceBeaver
Literally!

### NGINX Config
```
location / {
    rewrite ^/([\d]+)\/([\d]+)\/([\d]+)/?$ /index.php?width=$1&height=$2&compress=$3 last;
    rewrite ^/([\d]+)\/([\d]+)\/?$ /index.php?width=$1&height=$2 last;
    try_files $uri $uri/ index.html;
}
```
