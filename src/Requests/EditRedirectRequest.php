<?php

namespace MasterDmx\LaravelManagedRedirect\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use MasterDmx\LaravelManagedRedirect\RedirectManager;

class EditRedirectRequest extends FormRequest
{
    private RedirectManager $manager;

    public function authorize()
    {
        return true;
    }

    public function rules(RedirectManager $manager)
    {
        $this->manager = $manager;

        return [
            'from_url' => 'required|max:255',
            'to_url' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'from_url.required' => 'URL "откуда" обязателен к заполнению',
            'from_url.max' => 'Превышена максимальная длина строки для URL "откуда" ',
            'to_url.required' => 'URL "куда" обязателен к заполнению',
            'to_url.max' => 'Максимальная длина URL "куда" 255 символов',
        ];
    }

    /**
     * Проверить существование
     *
     * @param int|null $except
     *
     * @throws ValidationException
     */
    public function checkExist(?int $except = null)
    {
        if ($this->manager->checkExist($this->get('from_url'), $except)) {
            throw ValidationException::withMessages([
                'slug' => 'Редирект уже существует (' . $this->get('from_url') . ')',
            ]);
        }
    }
}
