# Dcat Admin Extension

### 演示地址
[demo: http://dcat.weiwait.cn (admin:admin)](http://dcat.weiwait.cn/admin/demo-distpickers/create 'user: admin psw: admin')

### 通过 composer 安装扩展
```shell
  composer require weiwait/dcat-icon
```
### 发布静态资源
```shell
  php artisan vendor:publish --tag=weiwait.dcat-icon --force
```

### 更新 dcat-admin ide-helper
```shell
  php artisan admin:ide-helper
```

```php
    $form->icon('column', 'label');
    
    $form->oIcon('column', 'label'); // 原图标
```

![示例图片](https://github.com/weiwait/images/blob/main/icon-effect.png?raw=true)
![示例图片](https://github.com/weiwait/images/blob/main/icon-add-svg.png?raw=true)
![示例图片](https://github.com/weiwait/images/blob/main/icon-field.png?raw=true)

[comment]: <> (### Donate)

[comment]: <> (![示例图片]&#40;https://github.com/weiwait/images/blob/main/donate.png?raw=true&#41;)

### Other
1. 如有无版权图标需要内置可以发送到邮箱或者提交pr(seeder)
2. 暂时仅支持svg，如无需求或者本人无需求不会增加

### Dcat-admin 扩展列表
1. [单图裁剪](https://github.com/weiwait/dcat-cropper)
2. [区划级联+坐标拾取](https://github.com/weiwait/dcat-distpicker)
3. [smtp快速便捷配置](https://github.com/weiwait/dcat-smtp)
4. [sms channel 快速便捷配置](https://github.com/weiwait/dcat-easy-sms)
