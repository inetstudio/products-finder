<?php

namespace InetStudio\ProductsFinder\Products\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\ProductsFinder\Products\Contracts\Http\Requests\Back\SaveProductRequestContract;

/**
 * Class SaveProductRequest.
 */
class SaveProductRequest extends FormRequest implements SaveProductRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Поле «Название» обязательно для заполнения',
            'name.max' => 'Поле «Название» не должно превышать 255 символов',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
