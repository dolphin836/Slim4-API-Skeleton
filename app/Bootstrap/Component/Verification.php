<?php

namespace Dolphin\Ting\Bootstrap\Component;

use Dolphin\Ting\Http\Exception\CommonException;
use Dolphin\Ting\Http\Model\Model;
use DI\Container;

class Verification implements ComponentInterface
{
    const PARAMETER_TYPE_CONFIG = [
        'int',
        'string',
        'numeric',
        'float',
        'array',
        'object',
        'bool'
    ];

    private $model;

    public function __construct (Container $app)
    {
        $this->model = new Model($app);
    }

    /**
     * Verification register.
     *
     * @param Container $container
     */
    public static function register (Container $container)
    {
        $container->set('Verification', function () use ($container) {
            return new Verification($container);
        });
    }

    /**
     * @param  array            $content
     * @param  array            $contentRuleArr
     * @throws CommonException
     */
    public function run ($content, $contentRuleArr)
    {
        if (empty($contentRuleArr)) {
            return;
        }

        foreach ($contentRuleArr as $contentKey => $contentRule) {
            $methodArr = explode('|', $contentRule);

            foreach ($methodArr as $method) {
                $methodNameAndParameter = explode(':', $method);
                $methodName             = $methodNameAndParameter[0];
                // 类型校验
                if (in_array($methodName, self::PARAMETER_TYPE_CONFIG)) {
                    if (isset($content[$contentKey]) && ! call_user_func('is_' . $methodName, $content[$contentKey])) {
                        throw new CommonException('PARAMETER_TYPE_ERROR', [
                            $contentKey,
                            ucfirst($methodName)
                        ]);
                    }

                    continue;
                }
                // 自定义校验
                // 删除第一个元素方法名
                unset( $methodNameAndParameter[0]);
                // 将校验的内容和 KEY 插入参数列表前面
                array_unshift($methodNameAndParameter, $content, $contentKey);

                call_user_func_array(
                    [
                        Verification::class,
                        $methodName
                    ],
                    $methodNameAndParameter
                );
            }
        }
    }

    /**
     * @param  array           $content
     * @param  string          $contentKey
     * @param  string          $tableAndField
     * @throws CommonException
     */
    public function isUnique ($content, $contentKey, $tableAndField)
    {
        if (! isset($content[$contentKey])) {
            return;
        }

        $contentValue = $content[$contentKey];

        list($tableName, $fieldName) = explode('.', $tableAndField);

        $tableClassName = 'Dolphin\\Ting\\Http\\Entity\\' . ucfirst($tableName);

        if ($this->model->isHas($tableClassName, [
            $fieldName => $contentValue
        ])) {
            throw new CommonException('RECORD_ALREADY_EXIST', [
                $contentKey,
                $contentValue
            ]);
        }
    }

    /**
     * @param  array           $content
     * @param  string          $contentKey
     * @throws CommonException
     */
    public function required ($content, $contentKey)
    {
        if (! isset($content[$contentKey])) {
            throw new CommonException('PARAMETER_REQUIRED', [
                $contentKey
            ]);
        }
    }

    /**
     * @param  array           $content
     * @param  string          $contentKey
     * @param  int             $minLength
     * @throws CommonException
     */
    public function minLength ($content, $contentKey, $minLength)
    {
        if (! isset($content[$contentKey])) {
            return;
        }

        $string = $content[$contentKey];

        if ((int) $minLength > mb_strlen($string)) {
            throw new CommonException('PARAMETER_MIN_LENGTH', [
                $contentKey,
                $minLength
            ]);
        }
    }

    /**
     * @param  array           $content
     * @param  string          $contentKey
     * @param  int             $maxLength
     * @throws CommonException
     */
    public function maxLength ($content, $contentKey, $maxLength)
    {
        if (! isset($content[$contentKey])) {
            return;
        }

        $string = $content[$contentKey];

        if ((int) $maxLength < mb_strlen($string)) {
            throw new CommonException('PARAMETER_MAX_LENGTH', [
                $contentKey,
                $maxLength
            ]);
        }
    }

    /**
     * @param  array           $content
     * @param  string          $contentKey
     * @param  number          $maxValue
     * @throws CommonException
     */
    public function maxValue ($content, $contentKey, $maxValue)
    {
        if (! isset($content[$contentKey])) {
            return;
        }

        $value = $content[$contentKey];

        if ($value > $maxValue) {
            throw new CommonException('PARAMETER_MAX_VALUE', [
                $contentKey,
                $maxValue
            ]);
        }
    }

    /**
     * @param  array           $content
     * @param  string          $contentKey
     * @param  number          $minValue
     * @throws CommonException
     */
    public function minValue ($content, $contentKey, $minValue)
    {
        if (! isset($content[$contentKey])) {
            return;
        }

        $value = $content[$contentKey];

        if ($value < $minValue) {
            throw new CommonException('PARAMETER_MIN_VALUE', [
                $contentKey,
                $minValue
            ]);
        }
    }
}