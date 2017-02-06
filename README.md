# Valet SilverStripe

Custom [Laravel Valet](https://github.com/laravel/valet/) driver for [SilverStripe](https://github.com/silverstripe/silverstripe-installer)
 

### Admin Errors 

If you find yourself experiencing 502 bad gateway errors whilst trying to access SilverStripe's admin.
A fix is to specify fastcgi_buffers, and fastcgi_buffer_size in valet.conf.

```
# /usr/local/etc/nginx/valet/valet.conf

location ~ \.php$ {
  # added params:
  fastcgi_buffers 16 16k;
  fastcgi_buffer_size 32k;
}
```

After updating your config besure to restart Valet.

```
valet restart
```