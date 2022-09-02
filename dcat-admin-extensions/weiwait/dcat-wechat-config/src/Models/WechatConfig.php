<?php

namespace Weiwait\Wechat\Models;

use Dcat\Admin\Widgets\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class WechatConfig extends Model
{
    const MINI_PROGRAM_APP_ID = 'mini_program_app_id';
    const MINI_PROGRAM_SECRET = 'mini_program_secret';
    const WECHAT_PAYMENT_MCH_ID = 'wechat_payment_mch_id';
    const WECHAT_PAYMENT_KEY = 'wechat_payment_key';
    const WECHAT_PAYMENT_KEY_V3 = 'wechat_payment_key_v3';
    const WECHAT_PAYMENT_CERT_PATH = 'wechat_payment_cert_path';
    const WECHAT_PAYMENT_KEY_PATH = 'wechat_payment_key_path';
    const WECHAT_PAYMENT_PLATFORM_PATH = 'wechat_payment_platform_path';

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

        if (null == $value = Cache::get('setting.wechat.config.' . $keys)) {
            $value = self::query()->where('key', $keys)->value('value');

            Cache::put('setting.wechat.config.' . $keys, $value, now()->addDay());
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

            Cache::put('setting.wechat.config.' . $key, $value, now()->addDay());
        }
    }

    public static function adminFormHandle(Form $form, array $input): \Dcat\Admin\Http\JsonResponse
    {
        try {
            if (!File::exists(storage_path('app/wechat-config')))
                File::makeDirectory(storage_path('app/wechat-config'));

            File::put(
                storage_path('app/wechat-config/api_client_cert.pem'),
                $input[self::WECHAT_PAYMENT_CERT_PATH]
            );

            File::put(
                storage_path('app/wechat-config/api_client_key.pem'),
                $input[self::WECHAT_PAYMENT_KEY_PATH]
            );

            File::put(
                storage_path('app/wechat-config/platform_certs.pem'),
                $input[self::WECHAT_PAYMENT_PLATFORM_PATH]
            );

            self::set($input);
        } catch (\Exception $exception) {
            return $form
                ->response()
                ->error($exception->getMessage());
        }

        return $form
            ->response()
            ->success('修改成功');
    }
}
