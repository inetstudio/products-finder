<?php

namespace InetStudio\ProductsFinder\Products\Contracts\Http\Requests\Back;

/**
 * Interface SaveItemRequestContract.
 */
interface SaveItemRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool;

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array;

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules(): array;

    /**
     * Get all of the input and files for the request.
     *
     * @param  array|mixed  $keys
     *
     * @return array
     */
    public function all($keys = null);
}
