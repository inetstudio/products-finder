<?php

namespace InetStudio\ProductsFinder\Products\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\ProductsFinder\Products\Contracts\Http\Requests\Back\SaveItemRequestContract;

/**
 * Class SaveItemRequest.
 */
class SaveItemRequest extends FormRequest implements SaveItemRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Поле «Название» обязательно для заполнения',
            'title.max' => 'Поле «Название» не должно превышать 255 символов',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
        ];
    }
}
