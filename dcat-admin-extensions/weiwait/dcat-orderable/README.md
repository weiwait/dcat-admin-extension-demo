# Dcat Admin Extension


# Dcat Admin Extension

### 演示地址
[demo: http://dcat.weiwait.cn (admin:admin)](http://dcat.weiwait.cn/admin/demo-distpickers/create 'user: admin psw: admin')

### 通过 composer 安装扩展
```shell
  composer require weiwait/dcat-orderable
```

### 更新 dcat-admin ide-helper
```shell
  php artisan admin:ide-helper
```

```php
// 升序
$grid->model()->orderBy('order');
$grid->column('order')->sequencable();
class Model implements \Spatie\EloquentSortable\Sortable
{
    protected array $sortable = [
        'order_column_name' => 'order',
        // alias: 'column' => 'order'
        'sort_when_creating' => true, // default
        // alias: 'sortable' => true
    ]
}
// 降序
$grid->model()->orderByDesc('order');
$grid->column('order')->sequencable();

class Model implements \Spatie\EloquentSortable\Sortable
{
    protected array $sortable = [
        'order_column_name' => 'order',
        // alias: 'column' => 'order'
        'sort_when_creating' => true, // default
        // alias: 'sortable' => true
        'direction' => 'desc' // when using descend method is required
    ]
}

// 分组排序
// 一般场景：二级分类排序、商品根据分类排序...
$grid->model()->orderByDesc('order');
if (request('parent_id')) {
    $grid->column('order')->sequencable();
}
$grid->filter(function ($filter) {
    $filter->equal('parent_id')
        ->select([...$options])
})

class Model implements \Spatie\EloquentSortable\Sortable
{
    // an attribute of this model
    protected $parent_id;

    protected array $sortable = [
        'order_column_name' => 'order',
        // alias: 'column' => 'order'
        'sort_when_creating' => true, // default
        // alias: 'sortable' => true
        'direction' => 'desc' // when using descend method is required
        'restiction' => 'parent_id' // where('parent_id', $this->parent_id)
    ]
}
```

[comment]: <> (### Donate)

[comment]: <> (![示例图片]&#40;https://github.com/weiwait/images/blob/main/donate.png?raw=true&#41;)

### Dcat-admin 扩展列表
1. [图片裁剪](https://github.com/weiwait/dcat-cropper)
2. [区划级联+坐标拾取](https://github.com/weiwait/dcat-distpicker)
3. [smtp快速便捷配置](https://github.com/weiwait/dcat-smtp)
4. [sms channel 快速便捷配置](https://github.com/weiwait/dcat-easy-sms)
