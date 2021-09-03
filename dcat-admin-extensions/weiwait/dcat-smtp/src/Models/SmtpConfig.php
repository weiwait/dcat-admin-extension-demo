<?php

namespace Weiwait\DcatSmtp\Models;

use Dcat\Admin\Widgets\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SmtpConfig extends Model
{
    const SMTP_HOST = 'smtp_host';
    const SMTP_PORT = 'smtp_port';
    const MAIL_USERNAME = 'mail_username';
    const MAIL_PASSWORD = 'mail_password';
    const MAIL_ENCRYPTION = 'mail_encryption';
    const MAIL_FROM_ADDRESS = 'mail_from_address';
    const MAIL_FROM_NAME = "mail_from_name";

    const INDEPENDENT = "independent";

    protected $guarded = [];

    /**
     * key 或者数组 keys 获取配置
     */
    public static function get($keys, $default = '')
    {
        if (is_array($keys)) {
            $data = [];
            foreach ($keys as $key) {
                $data[$key] = self::get($key);
            }

            return $data;
        }

        if (!$value = Cache::get('settings.' . $keys)) {
            $value = self::query()->where('key', $keys)->value('value');

            Cache::put('settings.' . $keys, $value, now()->addDay());
        }

        return $value ?? $default;
    }

    /**
     * 设置配置项
     */
    public static function set(array $settings)
    {
        foreach ($settings as $key => $value) {
            self::query()->updateOrCreate(['key' => $key], ['value' => $value ?? '']);

            Cache::put('settings.' . $key, $value, now()->addDay());
        }
    }

    public static function adminFormHandle(Form $form, array $input): \Dcat\Admin\Http\JsonResponse
    {

        try {
            self::set($input);
        } catch (\Exception $exception) {
            return $form
                ->response()
                ->error($exception->getMessage())
                ->refresh();
        }

        return $form
            ->response()
            ->success('修改成功')
            ->refresh();
    }
}
