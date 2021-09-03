# Dcat Admin Extension

### 演示地址
[demo: http://dcat.weiwait.cn (admin:admin)](http://dcat.weiwait.cn/admin/demo-distpickers/create 'user: admin psw: admin')

### 通过 composer 安装扩展
```shell
  composer require weiwait/dcat-smtp
```

### 通过选项卡使用
```php
    public function index(Content $content): Content
    {
        $tab = Tab::make();
        $tab->add('SMTP', new \Weiwait\DcatSmtp\Forms\SmtpConfig());

        return $content->title('配置')
            ->body($tab->withCard());
    }
```

### 通过一级菜单使用
![](https://github.com/weiwait/images/blob/main/dcat-smtp-menu.png?raw=true)

### 示例图片
![示例图片](https://github.com/weiwait/images/blob/main/dcat-smtp.png?raw=true)

### Donate
![示例图片](https://github.com/weiwait/images/blob/main/donate.png?raw=true)

### Dcat-admin 扩展列表
1. [单图裁剪](https://github.com/weiwait/dcat-cropper)
2. [区划级联+坐标拾取](https://github.com/weiwait/dcat-distpicker)
3. [smtp快速便捷配置](https://github.com/weiwait/dcat-smtp)
