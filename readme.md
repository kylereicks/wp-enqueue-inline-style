WP Enqueue Inline Style
=======================

A WordPress plugin to add inline CSS in the `<head>`.

Functions
---------

### wp_register_inline_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all')

### wp_enqueue_inline_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all')

Use
---

### Add an inline style

```php
wp_enqueue_inline_style('priority-style', 'http://www.site.com/path/to/style/priority-style.css', array(), '1.0', 'all');
```

### Register an inline style to be enqueued later

```php
wp_register_inline_style('priority-style', 'http://www.site.com/path/to/style/priority-style.css', array(), '1.0', 'all');
```

### Register an existing style as inline

```php
wp_register_inline_style('existing-style');
```
